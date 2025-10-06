<script setup>
import { ref, computed } from 'vue'
import SearchBar from '../components/SearchBar.vue'

const searchQuery = ref('')

// All documentation items
const allDocs = [
  // Infrastructure
  {
    category: 'infrastructure',
    title: 'Proxmox VE',
    description: 'Virtualization platform setup, VM management, and container orchestration',
    status: 'documented',
    updated: 'Oct 2025',
    link: '#proxmox',
    tags: ['virtualization', 'vm', 'containers', 'proxmox']
  },
  {
    category: 'infrastructure',
    title: 'Network Configuration',
    description: 'VLANs, firewall rules, and network topology',
    status: 'documented',
    updated: 'Oct 2025',
    link: '#networking',
    tags: ['network', 'vlan', 'firewall', 'topology']
  },
  // Services
  {
    category: 'services',
    title: 'Pi-hole',
    description: 'Network-wide ad blocking, DNS configuration, and custom blocklists',
    status: 'documented',
    updated: 'Oct 2025',
    link: '#pihole',
    tags: ['dns', 'ad blocking', 'pihole', 'network']
  },
  {
    category: 'services',
    title: 'Docker & Compose',
    description: 'Container management, docker-compose stacks, and deployment strategies',
    status: 'documented',
    updated: 'Oct 2025',
    link: '#docker',
    tags: ['docker', 'containers', 'compose', 'deployment']
  },
  {
    category: 'services',
    title: 'Nginx Proxy Manager',
    description: 'Reverse proxy setup, SSL certificates, and domain management',
    status: 'documented',
    updated: 'Oct 2025',
    link: '#nginx',
    tags: ['proxy', 'nginx', 'ssl', 'certificates', 'reverse proxy']
  },
  {
    category: 'services',
    title: 'Monitoring Stack',
    description: 'Grafana, Prometheus, and system monitoring setup',
    status: 'pending',
    updated: 'Coming soon',
    link: '#monitoring',
    tags: ['monitoring', 'grafana', 'prometheus', 'metrics']
  }
]

const guides = [
  {
    icon: '[📝]',
    title: 'Getting Started with Homelab',
    description: 'A beginner\'s guide to setting up your first homelab server',
    tags: ['beginner', 'setup', 'guide', 'getting started']
  },
  {
    icon: '[🔧]',
    title: 'Backup & Recovery Strategies',
    description: 'How I backup my homelab and disaster recovery procedures',
    tags: ['backup', 'recovery', 'disaster recovery', 'restore']
  },
  {
    icon: '[🔒]',
    title: 'Security Best Practices',
    description: 'Securing your homelab: firewalls, VPNs, and access control',
    tags: ['security', 'firewall', 'vpn', 'access control']
  }
]

// Computed filtered results
const filteredDocs = computed(() => {
  if (!searchQuery.value) return allDocs
  
  const query = searchQuery.value.toLowerCase()
  return allDocs.filter(doc => {
    return (
      doc.title.toLowerCase().includes(query) ||
      doc.description.toLowerCase().includes(query) ||
      doc.tags.some(tag => tag.includes(query))
    )
  })
})

const filteredGuides = computed(() => {
  if (!searchQuery.value) return guides
  
  const query = searchQuery.value.toLowerCase()
  return guides.filter(guide => {
    return (
      guide.title.toLowerCase().includes(query) ||
      guide.description.toLowerCase().includes(query) ||
      guide.tags.some(tag => tag.includes(query))
    )
  })
})

const infrastructureDocs = computed(() => 
  filteredDocs.value.filter(doc => doc.category === 'infrastructure')
)

const servicesDocs = computed(() => 
  filteredDocs.value.filter(doc => doc.category === 'services')
)

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

    <div v-if="isSearching && !hasResults" class="no-results">
      No results found for: <span class="search-query-display">{{ searchQuery }}</span>
    </div>

    <section class="section-group" v-if="infrastructureDocs.length > 0">
      <h2 class="section-title">Infrastructure</h2>
      <div class="doc-grid">
        <a 
          v-for="doc in infrastructureDocs" 
          :key="doc.link"
          :href="doc.link" 
          class="doc-card"
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
          </div>
        </a>
      </div>
    </section>

    <section class="section-group" v-if="servicesDocs.length > 0">
      <h2 class="section-title">Services</h2>
      <div class="doc-grid">
        <a 
          v-for="doc in servicesDocs" 
          :key="doc.link"
          :href="doc.link" 
          class="doc-card"
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
          </div>
        </a>
      </div>
    </section>

    <section class="section-group" v-if="filteredGuides.length > 0">
      <h2 class="section-title">Guides & Tutorials</h2>
      <div class="guide-list">
        <div 
          v-for="guide in filteredGuides" 
          :key="guide.title"
          class="guide-item"
        >
          <span class="guide-icon">{{ guide.icon }}</span>
          <div class="guide-content">
            <h3>{{ guide.title }}</h3>
            <p>{{ guide.description }}</p>
          </div>
        </div>
      </div>
    </section>
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
  align-items: center;
  margin-bottom: 10px;
}

.doc-card h3 {
  font-size: 1.2rem;
  margin: 0;
  color: var(--color-heading);
  text-transform: uppercase;
  letter-spacing: 1px;
  text-shadow: 0 0 8px rgba(255, 170, 0, 0.6);
}

.doc-status {
  font-size: 0.8rem;
  font-weight: 700;
  color: #00ff00;
  text-shadow: 0 0 5px rgba(0, 255, 0, 0.8);
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

.guide-content h3 {
  font-size: 1.1rem;
  margin: 0 0 5px 0;
  color: var(--color-heading);
  text-transform: uppercase;
  letter-spacing: 1px;
  text-shadow: 0 0 8px rgba(255, 170, 0, 0.6);
}

.guide-content p {
  font-size: 0.9rem;
  color: var(--color-text);
  margin: 0;
  line-height: 1.5;
}
</style>
