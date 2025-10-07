<script setup>
import { ref, provide, onMounted, computed } from 'vue'
import HomelabSidebar from './components/HomelabSidebar.vue'
import HomelabNavbar from './components/HomelabNavbar.vue'
import OverviewPage from './pages/OverviewPage.vue'
import DocsPage from './pages/DocsPage.vue'
import DocDetailPage from './pages/DocDetailPage.vue'

// Route state
const currentPage = ref('overview')
const currentDocSlug = ref(null)
const currentDocType = ref(null) // 'service' or 'guide'

// Get initial page from URL
const getPageFromURL = () => {
  const path = window.location.pathname
  
  // Check for doc detail routes like /docs/service/docker or /docs/guide/backup
  const docMatch = path.match(/\/docs\/(service|guide)\/([^/]+)/)
  if (docMatch) {
    currentDocType.value = docMatch[1]
    currentDocSlug.value = docMatch[2]
    return 'doc-detail'
  }
  
  if (path.includes('/docs') || path.includes('/documentation')) return 'docs'
  if (path.includes('/services')) return 'services'
  if (path.includes('/network')) return 'network'
  return 'overview'
}

const setPage = (page) => {
  currentPage.value = page
  currentDocSlug.value = null
  currentDocType.value = null
  
  // Update URL without page reload
  const path = page === 'overview' ? '/' : `/${page}`
  window.history.pushState({ page }, '', path)
}

const viewDoc = (slug, type) => {
  currentPage.value = 'doc-detail'
  currentDocSlug.value = slug
  currentDocType.value = type
  
  // Update URL
  const path = `/docs/${type}/${slug}`
  window.history.pushState({ page: 'doc-detail', slug, type }, '', path)
}

// Handle browser back/forward buttons
const handlePopState = (event) => {
  if (event.state?.page === 'doc-detail') {
    currentPage.value = 'doc-detail'
    currentDocSlug.value = event.state.slug
    currentDocType.value = event.state.type
  } else {
    currentPage.value = event.state?.page || getPageFromURL()
    currentDocSlug.value = null
    currentDocType.value = null
  }
}

onMounted(() => {
  // Set initial page
  currentPage.value = getPageFromURL()
  
  // Set initial state
  const state = { page: currentPage.value }
  if (currentDocSlug.value) {
    state.slug = currentDocSlug.value
    state.type = currentDocType.value
  }
  window.history.replaceState(state, '', window.location.pathname)
  
  // Listen for back/forward navigation
  window.addEventListener('popstate', handlePopState)
})

// Provide the navigation functions to child components
provide('setPage', setPage)
provide('viewDoc', viewDoc)
provide('currentPage', currentPage)
</script>

<template>
  <div class="homelab-container">
    <!-- Sidebar - Only visible on larger screens -->
    <HomelabSidebar class="desktop-only" />

    <!-- Main Content -->
    <main class="homelab-main">
      <HomelabNavbar />

      <div class="content-section">
        <!-- Page Components -->
        <OverviewPage v-if="currentPage === 'overview'" />
        <DocsPage v-else-if="currentPage === 'docs'" />
        <DocDetailPage 
          v-else-if="currentPage === 'doc-detail'" 
          :slug="currentDocSlug"
          :type="currentDocType"
        />
        <div v-else-if="currentPage === 'services'" class="page-content">
          <h1>Services</h1>
          <p class="intro-text">Services page coming soon...</p>
        </div>
        <div v-else-if="currentPage === 'network'" class="page-content">
          <h1>Network</h1>
          <p class="intro-text">Network page coming soon...</p>
        </div>
      </div>
    </main>
  </div>
</template>

<style scoped>
.homelab-container {
  display: flex;
  min-height: 100vh;
  gap: 0;
  background: var(--color-background);
  align-items: stretch;
}

/* Hide sidebar on screens smaller than 1024px */
.desktop-only {
  display: none;
}

@media (min-width: 1024px) {
  .desktop-only {
    display: block;
  }
}

/* Main Content */
.homelab-main {
  flex: 1;
  padding: 0;
  overflow-x: hidden;
}

.content-section {
  padding: 40px;
  width: 100%;
  font-family: 'Courier New', 'Consolas', monospace;
}

.content-section h1 {
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
  margin-bottom: 40px;
  max-width: 800px;
  border-left: 3px solid #ff9900;
  padding-left: 20px;
  background: rgba(255, 153, 0, 0.05);
  padding: 15px 20px;
  box-shadow: 0 0 10px rgba(255, 153, 0, 0.2);
}

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

.service-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: 20px;
  margin-top: 20px;
}

.service-card {
  background: rgba(255, 153, 0, 0.03);
  border: 2px solid #ff9900;
  border-radius: 0;
  padding: 25px;
  transition: all 0.3s ease;
  box-shadow: 0 0 10px rgba(255, 153, 0, 0.2), inset 0 0 10px rgba(255, 153, 0, 0.05);
  position: relative;
}

.service-card::before {
  content: '>';
  position: absolute;
  top: 10px;
  left: 10px;
  color: #ff9900;
  font-size: 1.2rem;
  opacity: 0;
  transition: opacity 0.3s ease;
}

.service-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 0 20px rgba(255, 153, 0, 0.5), inset 0 0 20px rgba(255, 153, 0, 0.1);
  border-color: #ffaa00;
  background: rgba(255, 153, 0, 0.08);
}

.service-card:hover::before {
  opacity: 1;
}

.service-card h3 {
  font-size: 1.3rem;
  margin: 0 0 10px 0;
  color: var(--color-heading);
  text-transform: uppercase;
  letter-spacing: 1px;
  text-shadow: 0 0 8px rgba(255, 170, 0, 0.6);
}

.service-card p {
  font-size: 0.95rem;
  color: var(--color-text);
  margin: 0;
  line-height: 1.6;
}

/* Responsive Design */
@media (max-width: 1023px) {
  .content-section {
    padding: 20px;
  }

  .content-section h1 {
    font-size: 2rem;
  }

  .service-grid {
    grid-template-columns: 1fr;
  }
}

/* Dark mode adjustments */
@media (prefers-color-scheme: dark) {
  .service-card {
    background: var(--color-background-mute);
  }
}
</style>
