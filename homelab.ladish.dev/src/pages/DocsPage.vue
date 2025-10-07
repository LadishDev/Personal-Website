<script setup>
import { ref, computed, inject } from 'vue'
import SearchBar from '../components/SearchBar.vue'
import { useDocs } from '../composables/useDocumentation.js'

const searchQuery = ref('')
const activeFilter = ref('all') // 'all', 'services', 'guides'

// Inject navigation function
const viewDoc = inject('viewDoc')

// Load documentation and guides dynamically from MDX files
const { docs: allDocs, guides: allGuides, loading, error } = useDocs()

// Computed filtered results
const filteredDocs = computed(() => {
  if (!searchQuery.value) return allDocs.value
  
  const query = searchQuery.value.toLowerCase()
  return allDocs.value.filter(doc => {
    return (
      doc.title.toLowerCase().includes(query) ||
      doc.description.toLowerCase().includes(query) ||
      doc.tags.some(tag => tag.includes(query))
    )
  })
})

const filteredGuides = computed(() => {
  if (!searchQuery.value) return allGuides.value
  
  const query = searchQuery.value.toLowerCase()
  return allGuides.value.filter(guide => {
    return (
      guide.title.toLowerCase().includes(query) ||
      guide.description.toLowerCase().includes(query) ||
      guide.tags.some(tag => tag.includes(query))
    )
  })
})

// Show/hide sections based on active filter
const showServices = computed(() => activeFilter.value === 'all' || activeFilter.value === 'services')
const showGuides = computed(() => activeFilter.value === 'all' || activeFilter.value === 'guides')

const hasResults = computed(() => 
  filteredDocs.value.length > 0 || filteredGuides.value.length > 0
)

const isSearching = computed(() => searchQuery.value.length > 0)
</script>

<template>
  <div class="page-content">
    <h1>Documentation</h1>
    <p class="intro-text">
      Comprehensive documentation for all services running in my homelab.  
      Click on any service below to view detailed setup guides, configurations, and troubleshooting tips.
    </p>

    <!-- Search Field --> 
    <SearchBar 
      v-model="searchQuery"
      :result-count="filteredDocs.length + filteredGuides.length"
      placeholder="search documentation..."
    />

    <!-- Filter Tabs -->
    <div class="filter-tabs">
      <button 
        class="filter-tab" 
        :class="{ active: activeFilter === 'all' }"
        @click="activeFilter = 'all'"
      >
        All ({{ filteredDocs.length + filteredGuides.length }})
      </button>
      <button 
        class="filter-tab" 
        :class="{ active: activeFilter === 'services' }"
        @click="activeFilter = 'services'"
      >
        Services ({{ filteredDocs.length }})
      </button>
      <button 
        class="filter-tab" 
        :class="{ active: activeFilter === 'guides' }"
        @click="activeFilter = 'guides'"
      >
        Guides ({{ filteredGuides.length }})
      </button>
    </div>

    <!-- Loading State -->
    <div v-if="loading" class="loading-state">
      <span class="loading-spinner">⟳</span> Loading documentation...
    </div>

    <!-- Error State -->
    <div v-else-if="error" class="error-state">
      ⚠ Error loading documentation: {{ error }}
    </div>

    <!-- Content -->
    <template v-else>
      <div v-if="isSearching && !hasResults" class="no-results">
        No results found for: <span class="search-query-display">{{ searchQuery }}</span>
      </div>

    <section class="section-group" v-if="showServices && filteredDocs.length > 0">
      <h2 class="section-title">Services</h2>
      <div class="doc-grid">
        <div 
          v-for="doc in filteredDocs" 
          :key="doc.slug"
          class="doc-card"
          @click="viewDoc(doc.slug, 'service')"
        >
          <div class="doc-header">
            <h3>{{ doc.title }}</h3>
            <span class="doc-status" :class="{ pending: doc.status === 'pending' }">
              {{ doc.status === 'documented' ? '● DOCUMENTED' : '○ IN PROGRESS' }}
            </span>
          </div>
          <p>{{ doc.description }}</p>
          <div class="doc-meta">
            <span>Last updated: {{ doc.updated }}</span>
            <span class="read-more">Read More →</span>
          </div>
        </div>
      </div>
    </section>

    <section class="section-group" v-if="showGuides && filteredGuides.length > 0">
      <h2 class="section-title">Guides & Tutorials</h2>
      <div class="guide-list">
        <div 
          v-for="guide in filteredGuides" 
          :key="guide.slug"
          class="guide-item"
          @click="viewDoc(guide.slug, 'guide')"
        >
          <span class="guide-icon">{{ guide.icon }}</span>
          <div class="guide-content">
            <div class="guide-header">
              <h3>{{ guide.title }}</h3>
              <span class="doc-status" :class="{ pending: guide.status === 'pending' }">
                {{ guide.status === 'documented' ? '● DOCUMENTED' : '○ IN PROGRESS' }}
              </span>
            </div>
            <p>{{ guide.description }}</p>
            <div class="guide-meta">
              <span>Last updated: {{ guide.updated }}</span>
              <span class="read-more">Read More →</span>
            </div>
          </div>
        </div>
      </div>
    </section>
    </template>
  </div>
</template>

<style scoped>
.page-content {
  font-family: 'Courier New', 'Consolas', monospace;
}

.page-content h1 {
  font-size: 2.5rem;
  margin: 0 0 20px 0;
  color: var(--color-heading);
  text-transform: uppercase;
  letter-spacing: 3px;
  text-shadow: 0 0 15px rgba(255, 170, 0, 0.8);
  font-weight: 700;
}

.intro-text {
  font-size: 1.1rem;
  line-height: 1.8;
  color: var(--color-text);
  margin-bottom: 30px;
  max-width: 800px;
  border-left: 3px solid #ff9900;
  padding: 15px 20px;
  background: rgba(255, 153, 0, 0.05);
  box-shadow: 0 0 10px rgba(255, 153, 0, 0.2);
}

/* Filter Tabs */
.filter-tabs {
  display: flex;
  gap: 10px;
  margin: 30px 0;
  border-bottom: 2px solid rgba(255, 153, 0, 0.2);
  padding-bottom: 0;
}

.filter-tab {
  padding: 12px 24px;
  background: transparent;
  border: 2px solid rgba(255, 153, 0, 0.3);
  border-bottom: none;
  color: rgba(255, 170, 0, 0.7);
  font-family: 'Courier New', 'Consolas', monospace;
  font-size: 0.9rem;
  font-weight: 700;
  text-transform: uppercase;
  cursor: pointer;
  transition: all 0.3s ease;
  position: relative;
  bottom: -2px;
}

.filter-tab:hover {
  background: rgba(255, 153, 0, 0.1);
  color: #ff9900;
  text-shadow: 0 0 8px rgba(255, 153, 0, 0.6);
}

.filter-tab.active {
  background: rgba(255, 153, 0, 0.15);
  border-color: #ff9900;
  color: #ff9900;
  text-shadow: 0 0 10px rgba(255, 153, 0, 0.8);
  box-shadow: 0 0 15px rgba(255, 153, 0, 0.3);
}

/* No Results Message */
.no-results {
  text-align: center;
  padding: 60px 20px;
  color: #ff9900;
  font-size: 18px;
  font-weight: 700;
  text-shadow: 0 0 10px rgba(255, 153, 0, 0.6);
  border: 2px dashed rgba(255, 153, 0, 0.3);
  background: rgba(255, 153, 0, 0.03);
  border-radius: 4px;
  margin: 40px 0;
}

/* Loading State */
.loading-state {
  text-align: center;
  padding: 60px 20px;
  color: #ff9900;
  font-size: 18px;
  font-weight: 700;
  text-shadow: 0 0 10px rgba(255, 153, 0, 0.6);
  border: 2px solid rgba(255, 153, 0, 0.3);
  background: rgba(255, 153, 0, 0.05);
  border-radius: 4px;
  margin: 40px 0;
}

.loading-spinner {
  display: inline-block;
  animation: spin 1s linear infinite;
  font-size: 24px;
  margin-right: 10px;
}

@keyframes spin {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}

/* Error State */
.error-state {
  text-align: center;
  padding: 60px 20px;
  color: #ff4444;
  font-size: 18px;
  font-weight: 700;
  text-shadow: 0 0 10px rgba(255, 68, 68, 0.6);
  border: 2px solid rgba(255, 68, 68, 0.3);
  background: rgba(255, 68, 68, 0.05);
  border-radius: 4px;
  margin: 40px 0;
}

.search-query-display {
  color: #ffaa00;
  font-weight: 700;
  text-shadow: 0 0 5px rgba(255, 170, 0, 0.6);
}

/* Section Groups */
.section-group {
  margin-top: 40px;
}

.section-title {
  font-size: 1.8rem;
  margin: 0 0 25px 0;
  color: var(--color-heading);
  border-bottom: 2px solid #ff9900;
  padding-bottom: 10px;
  text-transform: uppercase;
  letter-spacing: 2px;
  text-shadow: 0 0 10px rgba(255, 170, 0, 0.7);
  box-shadow: 0 2px 5px rgba(255, 153, 0, 0.3);
}

.doc-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 20px;
  margin-top: 20px;
}

.doc-card {
  background: rgba(255, 153, 0, 0.03);
  border: 2px solid #ff9900;
  border-radius: 0;
  padding: 25px;
  transition: all 0.3s ease;
  box-shadow: 0 0 10px rgba(255, 153, 0, 0.2), inset 0 0 10px rgba(255, 153, 0, 0.05);
  position: relative;
  text-decoration: none;
  display: block;
  cursor: pointer;
}

.doc-card::before {
  content: '>';
  position: absolute;
  top: 10px;
  left: 10px;
  color: #ff9900;
  font-size: 1.2rem;
  opacity: 0;
  transition: opacity 0.3s ease;
}

.doc-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 0 20px rgba(255, 153, 0, 0.5), inset 0 0 20px rgba(255, 153, 0, 0.1);
  border-color: #ffaa00;
  background: rgba(255, 153, 0, 0.08);
}

.doc-card:hover::before {
  opacity: 1;
}

.doc-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 10px;
  gap: 10px;
  flex-wrap: nowrap;
}

.doc-card h3 {
  font-size: 1.2rem;
  margin: 0;
  color: var(--color-heading);
  text-transform: uppercase;
  letter-spacing: 1px;
  text-shadow: 0 0 8px rgba(255, 170, 0, 0.6);
  flex: 1;
  min-width: 0;
  word-wrap: break-word;
}

.doc-status {
  font-size: 0.8rem;
  font-weight: 700;
  color: #00ff00;
  text-shadow: 0 0 5px rgba(0, 255, 0, 0.8);
  flex-shrink: 0;
  white-space: nowrap;
}

.doc-status.pending {
  color: #ffaa00;
  text-shadow: 0 0 5px rgba(255, 170, 0, 0.8);
}

.doc-card p {
  font-size: 0.95rem;
  color: var(--color-text);
  margin: 10px 0;
  line-height: 1.6;
}

.doc-meta {
  margin-top: 15px;
  padding-top: 10px;
  border-top: 1px solid rgba(255, 153, 0, 0.3);
  font-size: 0.85rem;
  color: rgba(255, 170, 0, 0.6);
  font-style: italic;
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 10px;
  flex-wrap: nowrap;
}

.read-more {
  font-size: 0.9rem;
  color: #ff9900;
  font-weight: 700;
  text-shadow: 0 0 5px rgba(255, 153, 0, 0.6);
  font-style: normal;
  flex-shrink: 0;
  white-space: nowrap;
}

.guide-list {
  display: flex;
  flex-direction: column;
  gap: 15px;
  margin-top: 20px;
}

.guide-item {
  display: flex;
  gap: 15px;
  padding: 20px;
  background: rgba(255, 153, 0, 0.03);
  border: 2px solid #ff9900;
  box-shadow: 0 0 10px rgba(255, 153, 0, 0.2);
  transition: all 0.3s ease;
  cursor: pointer;
}

.guide-item:hover {
  transform: translateX(5px);
  box-shadow: 0 0 15px rgba(255, 153, 0, 0.4);
  background: rgba(255, 153, 0, 0.08);
}

.guide-icon {
  font-size: 1.5rem;
  color: #ff9900;
  text-shadow: 0 0 10px rgba(255, 153, 0, 0.6);
  min-width: 40px;
}

.guide-content {
  flex: 1;
}

.guide-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 8px;
  gap: 10px;
  flex-wrap: nowrap;
}

.guide-content h3 {
  font-size: 1.1rem;
  margin: 0;
  color: var(--color-heading);
  text-transform: uppercase;
  letter-spacing: 1px;
  text-shadow: 0 0 8px rgba(255, 170, 0, 0.6);
  flex: 1;
  min-width: 0;
  word-wrap: break-word;
}

.guide-content p {
  font-size: 0.9rem;
  color: var(--color-text);
  margin: 0 0 10px 0;
  line-height: 1.5;
}

.guide-meta {
  margin-top: 15px;
  padding-top: 10px;
  border-top: 1px solid rgba(255, 153, 0, 0.3);
  font-size: 0.85rem;
  color: rgba(255, 170, 0, 0.6);
  font-style: italic;
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 10px;
  flex-wrap: nowrap;
}
</style>
