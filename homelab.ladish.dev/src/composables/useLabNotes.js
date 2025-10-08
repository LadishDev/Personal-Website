import { ref } from 'vue'
import matter from 'gray-matter'

// Module-level state (singleton pattern)
const notes = ref([])
let isInitialized = false

export function useLabNotes() {
  const loading = ref(false)

  const loadLabNotes = async () => {
    if (isInitialized) {
      return // Already loaded, skip
    }

    loading.value = true
    
    try {
      // Import all MDX files from the lab-notes directory
      const mdxFiles = import.meta.glob('../content/lab-notes/*.mdx', { 
        query: '?raw',
        import: 'default',
        eager: false
      })

      const loadedNotes = []

      for (const path in mdxFiles) {
        try {
          const content = await mdxFiles[path]()
          const { data: frontmatter, content: markdownContent } = matter(content)
          
          // Extract slug from filename
          const slug = path.split('/').pop().replace('.mdx', '')
          
          loadedNotes.push({
            slug,
            title: frontmatter.title || 'Untitled',
            category: frontmatter.category || 'Idea',
            date: frontmatter.date || 'N/A',
            preview: frontmatter.preview || '',
            tags: frontmatter.tags || [],
            content: markdownContent
          })
        } catch (err) {
          console.error(`Error loading ${path}:`, err)
        }
      }

      // Sort notes: newest first by date
      loadedNotes.sort((a, b) => {
        if (a.date === 'N/A' && b.date !== 'N/A') return 1
        if (a.date !== 'N/A' && b.date === 'N/A') return -1
        if (a.date === 'N/A' && b.date === 'N/A') return 0
        
        const dateA = new Date(a.date)
        const dateB = new Date(b.date)
        return dateB - dateA
      })

      notes.value = loadedNotes
      isInitialized = true
    } catch (error) {
      console.error('Error loading lab notes:', error)
    } finally {
      loading.value = false
    }
  }

  // Load notes if not already loaded
  if (!isInitialized && !loading.value) {
    loadLabNotes()
  }

  return {
    notes,
    loading
  }
}
