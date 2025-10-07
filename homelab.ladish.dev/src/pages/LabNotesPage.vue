<script setup>
import { ref, computed, inject } from 'vue'
import { useLabNotes } from '../composables/useLabNotes.js'

// Inject navigation function
const viewNote = inject('viewNote')

// Load lab notes from MDX files
const { notes, loading } = useLabNotes()

// Sample notes - you can expand this with more notes
const sampleNotes = ref([
  {
    id: 1,
    title: 'Home Automation Ideas',
    date: 'Oct 2025',
    category: 'Project',
    preview: 'Integrate Home Assistant with presence detection using Bluetooth beacons...',
    content: `## Home Automation Ideas

### Goals
- Integrate Home Assistant with presence detection
- Use Bluetooth beacons for room-level tracking
- Automate lights based on presence and time of day

### Components Needed
- ESP32 boards with Bluetooth
- Home Assistant integration
- Node-RED for automation flows

### Status
Planning phase - researching best beacon hardware`
  },
  {
    id: 2,
    title: 'Network Segmentation Plan',
    date: 'Oct 2025',
    category: 'Infrastructure',
    preview: 'Plan for VLAN segmentation to improve security and network performance...',
    content: `## Network Segmentation Plan

### VLANs to Create
- VLAN 10: Management (servers, switches)
- VLAN 20: IoT devices
- VLAN 30: Guest network
- VLAN 40: Media (Plex, streaming)

### Firewall Rules
- Isolate IoT from main network
- Allow media VLAN access to storage
- Block guest network from internal resources

### Implementation Steps
1. Configure VLANs on switch
2. Update DHCP server
3. Configure firewall rules
4. Test connectivity`
  },
  {
    id: 3,
    title: 'Kubernetes Migration',
    date: 'Oct 2025',
    category: 'Idea',
    preview: 'Consider migrating Docker containers to Kubernetes for better orchestration...',
    content: `## Kubernetes Migration

### Why?
- Better orchestration and scaling
- Self-healing capabilities
- Easier service mesh implementation

### Concerns
- Increased complexity
- Resource overhead
- Learning curve

### Next Steps
- Set up test K3s cluster
- Migrate one service as proof of concept
- Document process and issues`
  },
  {
    id: 4,
    title: 'Backup Improvement',
    date: 'Oct 2025',
    category: 'Infrastructure',
    preview: 'Implement 3-2-1 backup strategy with offsite replication...',
    content: `## Backup Improvement Plan

### Current State
- Local backups only
- Manual backup process
- No testing of restores

### Target State
- Automated daily backups
- Offsite replication to cloud
- Monthly restore testing

### Tools to Evaluate
- Restic for encrypted backups
- Backblaze B2 for offsite storage
- Automated restore testing scripts`
  },
  {
    id: 5,
    title: 'Monitoring Dashboard',
    date: 'Oct 2025',
    category: 'Project',
    preview: 'Create a unified monitoring dashboard with Grafana and Prometheus...',
    content: `## Monitoring Dashboard Project

### Components
- Prometheus for metrics collection
- Grafana for visualization
- Node exporter for server metrics
- cAdvisor for container metrics
- Alertmanager for notifications

### Metrics to Track
- CPU, RAM, disk usage
- Network traffic
- Container health
- Service uptime
- Response times

### Alert Rules
- Disk space < 10%
- CPU usage > 80% for 5 minutes
- Service down
- High memory usage`
  },
  {
    id: 6,
    title: 'Documentation System',
    date: 'Oct 2025',
    category: 'Idea',
    preview: 'Set up a personal wiki for technical documentation and runbooks...',
    content: `## Documentation System

### Options
- BookStack - Simple, organized
- Wiki.js - Modern, feature-rich
- Obsidian - Markdown-based, local-first

### Content to Document
- Server configurations
- Network topology
- Service dependencies
- Troubleshooting guides
- Disaster recovery procedures

### Integration
- Link from homelab dashboard
- Searchable from all devices
- Version control with Git`
  }
])

const filterCategory = ref('all')

const categories = ['all', 'Project', 'Infrastructure', 'Idea']

// Computed filtered notes
const filteredNotes = computed(() => {
  if (filterCategory.value === 'all') {
    return notes.value
  } else {
    return notes.value.filter(note => note.category === filterCategory.value)
  }
})

const filterNotes = (category) => {
  filterCategory.value = category
}

const openNote = (noteSlug) => {
  viewNote(noteSlug)
}
</script>

<template>
  <div class="page-content">
    <h1>Lab Notes</h1>
    <p class="intro-text">
      Ideas, projects, and notes for my homelab. A collection of planned improvements, research, and documentation.
    </p>

    <!-- Loading State -->
    <div v-if="loading" class="loading-state">
      <span class="loading-spinner">⟳</span> Loading notes...
    </div>

    <!-- Category Filter -->
    <div v-else class="category-filter">
      <button 
        v-for="category in categories" 
        :key="category"
        class="filter-btn"
        :class="{ active: filterCategory === category }"
        @click="filterNotes(category)"
      >
        {{ category.charAt(0).toUpperCase() + category.slice(1) }}
      </button>
    </div>

    <!-- Notes Grid -->
    <div v-if="!loading" class="notes-grid">
      <div 
        v-for="note in filteredNotes" 
        :key="note.slug"
        class="note-card"
        @click="openNote(note.slug)"
      >
        <div class="note-header">
          <span class="note-category">{{ note.category }}</span>
          <span class="note-date">{{ note.date }}</span>
        </div>
        <h3 class="note-title">{{ note.title }}</h3>
        <p class="note-preview">{{ note.preview }}</p>
        <div class="note-footer">
          <span class="read-more">Read More →</span>
        </div>
      </div>
    </div>
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
  color: var(--color-text);
  margin-bottom: 30px;
  line-height: 1.6;
}

/* Loading State */
.loading-state {
  text-align: center;
  padding: 60px 20px;
  color: #ff9900;
  font-size: 18px;
}

.loading-spinner {
  display: inline-block;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}

/* Category Filter */
.category-filter {
  display: flex;
  gap: 10px;
  margin-bottom: 30px;
  flex-wrap: wrap;
}

.filter-btn {
  padding: 10px 20px;
  background: rgba(255, 153, 0, 0.1);
  border: 2px solid rgba(255, 153, 0, 0.3);
  color: rgba(255, 170, 0, 0.7);
  font-family: 'Courier New', 'Consolas', monospace;
  font-size: 0.9rem;
  font-weight: 700;
  text-transform: uppercase;
  cursor: pointer;
  transition: all 0.3s ease;
}

.filter-btn:hover {
  background: rgba(255, 153, 0, 0.2);
  color: #ff9900;
  text-shadow: 0 0 8px rgba(255, 153, 0, 0.6);
}

.filter-btn.active {
  background: rgba(255, 153, 0, 0.2);
  border-color: #ff9900;
  color: #ff9900;
  text-shadow: 0 0 10px rgba(255, 153, 0, 0.8);
  box-shadow: 0 0 15px rgba(255, 153, 0, 0.3);
}

/* Notes Grid */
.notes-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
  gap: 20px;
  margin-top: 30px;
}

.note-card {
  background: rgba(255, 153, 0, 0.03);
  border: 2px solid #ff9900;
  padding: 20px;
  cursor: pointer;
  transition: all 0.3s ease;
  box-shadow: 0 0 10px rgba(255, 153, 0, 0.2);
  display: flex;
  flex-direction: column;
}

.note-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 0 20px rgba(255, 153, 0, 0.4);
  background: rgba(255, 153, 0, 0.08);
}

.note-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 15px;
}

.note-category {
  padding: 4px 12px;
  background: rgba(255, 153, 0, 0.2);
  border: 1px solid #ff9900;
  font-size: 0.75rem;
  font-weight: 700;
  text-transform: uppercase;
  color: #ff9900;
  text-shadow: 0 0 5px rgba(255, 153, 0, 0.6);
}

.note-date {
  font-size: 0.85rem;
  color: rgba(255, 170, 0, 0.6);
  font-style: italic;
}

.note-title {
  font-size: 1.3rem;
  color: #ff9900;
  margin: 0 0 15px 0;
  text-transform: uppercase;
  letter-spacing: 1px;
  text-shadow: 0 0 8px rgba(255, 153, 0, 0.6);
}

.note-preview {
  font-size: 0.95rem;
  color: var(--color-text);
  line-height: 1.6;
  margin: 0 0 15px 0;
  flex: 1;
}

.note-footer {
  display: flex;
  justify-content: flex-end;
  padding-top: 10px;
  border-top: 1px solid rgba(255, 153, 0, 0.3);
}

.read-more {
  font-size: 0.9rem;
  color: #ff9900;
  font-weight: 700;
  text-shadow: 0 0 5px rgba(255, 153, 0, 0.6);
}
</style>
