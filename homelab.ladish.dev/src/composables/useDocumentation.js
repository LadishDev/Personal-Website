import { ref, onMounted } from 'vue'
import matter from 'gray-matter'
import { Buffer } from 'buffer'

// Make Buffer available globally for gray-matter
if (typeof window !== 'undefined') {
  window.Buffer = Buffer
}

export function useDocs() {
  const docs = ref([])
  const guides = ref([])
  const loading = ref(true)
  const error = ref(null)

  const loadContent = async () => {
    try {
      loading.value = true
      error.value = null

      // Load both docs and guides in parallel
      await Promise.all([
        loadDocs(),
        loadGuides()
      ])
      
    } catch (err) {
      error.value = err.message
      console.error('Error loading content:', err)
    } finally {
      loading.value = false
    }
  }

  const loadDocs = async () => {
    try {
      // Use Vite's glob import to get all MDX files from content/docs/services
      const modules = import.meta.glob('../content/docs/services/*.mdx', { 
        query: '?raw',
        import: 'default',
        eager: false
      })

      const docsData = []

      for (const path in modules) {
        try {
          // Load the file content
          const content = await modules[path]()
          
          // Parse frontmatter
          const { data: frontmatter, content: body } = matter(content)
          
          // Extract filename without extension for slug
          const fileName = path.split('/').pop().replace('.mdx', '')
          
          docsData.push({
            slug: fileName.toLowerCase(),
            category: frontmatter.category || 'services',
            title: frontmatter.title || fileName,
            description: frontmatter.description || '',
            status: frontmatter.status || 'documented',
            updated: frontmatter.updated || 'N/A',
            link: frontmatter.link || `#${fileName.toLowerCase()}`,
            tags: frontmatter.tags || [],
            content: body
          })
        } catch (err) {
          console.error(`Error loading ${path}:`, err)
        }
      }

      // Sort by status (pending first) and then by newest updated date
      docs.value = docsData.sort((a, b) => {
        // Pending items always at the top
        if (a.status === 'pending' && b.status !== 'pending') return -1
        if (a.status !== 'pending' && b.status === 'pending') return 1
        
        // For other items, sort by updated date (newest first)
        if (a.updated === 'N/A' && b.updated !== 'N/A') return 1
        if (a.updated !== 'N/A' && b.updated === 'N/A') return -1
        if (a.updated === 'N/A' && b.updated === 'N/A') return 0
        
        // Parse dates and sort newest first
        const dateA = new Date(a.updated)
        const dateB = new Date(b.updated)
        return dateB - dateA
      })
      
      console.log('Loaded docs:', docs.value.length, docs.value)
    } catch (err) {
      console.error('Error loading docs:', err)
      throw err
    }
  }

  const loadGuides = async () => {
    try {
      // Use Vite's glob import to get all MDX files from content/docs/guides
      const modules = import.meta.glob('../content/docs/guides/*.mdx', { 
        query: '?raw',
        import: 'default',
        eager: false
      })

      const guidesData = []

      for (const path in modules) {
        try {
          // Load the file content
          const content = await modules[path]()
          
          // Parse frontmatter
          const { data: frontmatter, content: body } = matter(content)
          
          // Extract filename without extension for slug
          const fileName = path.split('/').pop().replace('.mdx', '')
          
          guidesData.push({
            slug: fileName.toLowerCase(),
            icon: frontmatter.icon || '📝',
            title: frontmatter.title || fileName,
            description: frontmatter.description || '',
            tags: frontmatter.tags || [],
            content: body
          })
        } catch (err) {
          console.error(`Error loading ${path}:`, err)
        }
      }

      // Sort by title
      guides.value = guidesData.sort((a, b) => a.title.localeCompare(b.title))
      
      console.log('Loaded guides:', guides.value.length, guides.value)
    } catch (err) {
      console.error('Error loading guides:', err)
      throw err
    }
  }

  onMounted(() => {
    loadContent()
  })

  return {
    docs,
    guides,
    loading,
    error,
    reload: loadContent
  }
}
