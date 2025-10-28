<script setup>
import { inject, computed } from 'vue'
import commitsFile from '../data/homelab-commits.json'
import IconSupport from '../components/icons/IconSupport.vue'
import IconEcosystem from '../components/icons/IconEcosystem.vue'
import IconCommunity from '../components/icons/IconCommunity.vue'
import IconDocumentation from '../components/icons/IconDocumentation.vue'
import { useDocs } from '../composables/useDocumentation.js'

const viewDoc = inject('viewDoc')
const setPage = inject('setPage')
function viewDocs() { setPage && setPage('docs') }

// Array of featured services (edit/add/remove here)
const featuredServices = [
  {
    slug: 'pihole',
    icon: IconSupport,
    color: '#ff9900',
    url: null
  },
  {
    slug: 'docker',
    icon: IconEcosystem,
    color: '#ff9900',
    url: null
  },
  {
    slug: 'zoraxy',
    icon: IconCommunity,
    color: '#ff9900',
    url: null
  },
  {
    slug: 'immich',
    icon: IconDocumentation,
    color: '#ff9900',
    url: null
  },
  {
    slug: 'monitoring',
    icon: IconEcosystem,
    color: '#ff9900',
    url: null
  }
]

const { docs } = useDocs()
const featuredData = computed(() => {
  return featuredServices.map(svc => {
    const doc = docs.value.find(d => d.slug === svc.slug)
    return {
      ...svc,
      title: doc?.title || svc.slug,
      description: doc?.description || '',
      link: svc.url || null
    }
  })
})

function handleServiceClick(service) {
  if (service.link) {
    window.open(service.link, '_blank')
  } else {
    viewDoc && viewDoc(service.slug, 'service')
  }
}

// Use build-time generated commit data. The script writes src/data/homelab-commits.json
const rawCommits = (commitsFile && commitsFile.commits) || []

const formattedCommits = computed(() => {
  const dtf = new Intl.DateTimeFormat(undefined, { year: 'numeric', month: 'short', day: 'numeric' })
  return rawCommits.map(c => ({
    message: c.message || '',
    shortSha: c.shortSha || (c.sha ? c.sha.slice(0, 7) : ''),
    url: c.url || '#',
    date: c.date ? dtf.format(new Date(c.date)) : null
  }))
})

defineExpose({ viewDoc, viewDocs, handleServiceClick })

</script>

<template>
  <div class="page-content">

    <h1>Welcome to My Homelab!</h1>
    <p class="intro-text">
      This is my playground for learning, experimenting, and self-hosting services.  
      Below are some of the highlights, with links to documentation if you'd like to dive deeper.
    </p>
    

    <section class="section-group recent-updates compact">
      <h2 class="section-title">Recent Updates</h2>
      <ul class="recent-list compact-list" aria-label="Recent commit updates">
        <li v-for="(c, idx) in formattedCommits" :key="c.shortSha || idx" class="recent-item-compact">
          <div class="commit-top-row">
            <a class="commit-sha-compact" :href="c.url" target="_blank" rel="noopener noreferrer" title="View commit {{ c.shortSha }}">{{ c.shortSha }}</a>
            <span class="commit-date-mobile">{{ c.date }}</span>
          </div>
          <div class="commit-body">
            <span class="commit-message-compact" title="{{ c.message }}">{{ c.message }}</span>
            <span class="commit-date-desktop">{{ c.date }}</span>
          </div>
        </li>
      </ul>
    </section>

    <section class="section-group">
      <h2 class="section-title">Featured Services</h2>
      <div class="service-grid">
        <div
          v-for="service in featuredData"
          :key="service.slug"
          class="service-card clickable with-cursor"
          @click="handleServiceClick(service)"
        >
          <span class="service-cursor">&gt;</span>
          <component :is="service.icon" :style="`margin-bottom:8px;color:${service.color}`" />
          <h3>{{ service.title }}</h3>
          <p>{{ service.description }}</p>
        </div>
      </div>
    </section>


  </div>
</template>

<style scoped>
.page-content {
  font-family: 'Courier New', 'Consolas', monospace;
  min-height: 100vh;


.hero-section {
  text-align: center;
  padding: 60px 0 30px 0;
  background: linear-gradient(90deg, #ff9900 0%, #ffcc80 100%);
  color: #222;
  border-radius: 0 0 24px 24px;
  box-shadow: 0 8px 32px rgba(255,153,0,0.08);
}
.hero-section h1 {
  font-size: 3.2rem;
  margin-bottom: 10px;
  letter-spacing: 2px;
  text-shadow: 0 2px 16px #fff7e6;
}
.hero-lead {
  font-size: 1.3rem;
  margin-bottom: 24px;
  color: #333;
}
.explore-btn {
  background: #ff9900;
  color: #fff;
  border: none;
  border-radius: 6px;
  font-size: 1.1rem;
  padding: 12px 32px;
  font-weight: 600;
  cursor: pointer;
  box-shadow: 0 2px 8px rgba(255,153,0,0.15);
  transition: background 0.2s, transform 0.2s;
}
.explore-btn:hover {
  background: #ffaa33;
  transform: translateY(-2px) scale(1.04);
}


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

.service-grid,
.status-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: 20px;
  margin-top: 20px;
}

.recent-updates {
  margin-top: 24px;
}
.recent-list {
  list-style: none;
  padding: 0;
  margin: 0 0 18px 0;
  font-family: 'Courier New', 'Consolas', monospace;
}
.compact .recent-list {
  margin: 0;
}
/* Mobile-first styles: stacked items, fully visible messages and dates */
.compact-list {
  display: flex;
  flex-direction: column;
  gap: 8px;
  padding: 0;
  margin: 0;
}
.recent-item-compact {
  display: flex;
  flex-direction: column;
  gap: 6px;
  color: #ff9900;
  font-size: 0.95rem;
  margin: 0;
  align-items: flex-start;
  /* faint terminal-style box to separate each commit */
  background: rgba(17,17,17,0.45);
  border: 1px solid rgba(255,153,0,0.08);
  padding: 8px 10px;
  border-radius: 6px;
  box-shadow: inset 0 0 6px rgba(255,153,0,0.02);
  width: 100%;
  box-sizing: border-box;
}
.commit-sha-compact {
  display: inline-block;
  /* show SHA fully and prevent wrapping */
  min-width: 64px;
  white-space: nowrap;
  text-align: left;
  background: #111;
  color: #ffcc80;
  border: 1px solid #ff9900;
  padding: 4px 8px;
  text-decoration: none;
  font-family: 'Courier New', monospace;
  border-radius: 4px;
  font-size: 0.9rem;
}
.commit-line {
  display: block;
  width: 100%;
}
.commit-message-compact {
  color: var(--color-heading);
  font-weight: 600;
  white-space: normal; /* allow wrapping on mobile */
  overflow: visible;
  text-overflow: unset;
}
.commit-date-compact {
  color: var(--color-text);
  font-size: 0.85rem;
  margin-top: 6px;
  white-space: nowrap;
  opacity: 0.95;
}

/* mobile-specific date placement (shown next to SHA on mobile) */
.commit-date-mobile {
  color: var(--color-text);
  font-size: 0.85rem;
  margin-left: 10px;
  white-space: nowrap;
  opacity: 0.95;
}

/* desktop-only date placed at far right */
.commit-date-desktop {
  display: none;
}

/* ensure wrapping and containment */
.commit-message-compact {
  overflow-wrap: anywhere;
  word-break: break-word;
}

/* Desktop and wider screens: compact single-line items with ellipsis */
@media (min-width: 641px) {
  .recent-item-compact {
    flex-direction: row;
    align-items: center;
    gap: 10px;
    padding: 8px 12px; /* slightly more horizontal space on desktop */
  }
  /* Desktop: SHA + message on left, date aligned to right inside the box */
  .commit-top-row { display: flex; align-items: center; gap: 10px; }
  .commit-body { display: flex; align-items: flex-start; gap: 12px; width: 100%; }
  .commit-message-compact {
    white-space: normal; /* allow wrapping to the next line if needed */
    overflow: visible;
    text-overflow: unset;
    min-width: 0; /* allow flex wrapping */
    flex: 1 1 auto; /* take remaining space and wrap if needed */
  }
  .commit-date-mobile { display: none; }
  .commit-date-desktop {
    display: inline-block;
    margin-left: 12px;
    white-space: nowrap;
    padding-left: 12px;
    border-left: 1px solid rgba(255,153,0,0.06);
    align-self: center;
  }
  .commit-sha-compact { min-width: 64px; }
}



.service-card,
.status-card {
  background: rgba(255, 153, 0, 0.03);
  border: 2px solid #ff9900;
  border-radius: 0;
  padding: 25px;
  transition: all 0.3s ease;
  box-shadow: 0 0 10px rgba(255, 153, 0, 0.2), inset 0 0 10px rgba(255, 153, 0, 0.05);
  position: relative;
  cursor: pointer;
}

.service-card.with-cursor .service-cursor {
  position: absolute;
  left: 10px;
  top: 10px;
  color: #ff9900;
  font-size: 1.2rem;
  opacity: 0; /* hidden by default */
  transition: opacity 0.18s ease;
  pointer-events: none;
}

.service-card.with-cursor:hover .service-cursor {
  opacity: 1; /* show on hover */
}

.service-card.with-cursor {
  padding-left: 32px;
}

.service-card::before,
.status-card::before {
  content: '>';
  position: absolute;
  top: 10px;
  left: 10px;
  color: #ff9900;
  font-size: 1.2rem;
  opacity: 0;
  transition: opacity 0.3s ease;
}

.service-card:hover,
.status-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 0 20px rgba(255, 153, 0, 0.5), inset 0 0 20px rgba(255, 153, 0, 0.1);
  border-color: #ffaa00;
  background: rgba(255, 153, 0, 0.08);
}

.service-card:hover::before,
.status-card:hover::before {
  opacity: 1;
}

.service-card h3,
.status-card h3 {
  font-size: 1.3rem;
  margin: 0 0 10px 0;
  color: var(--color-heading);
  text-transform: uppercase;
  letter-spacing: 1px;
  text-shadow: 0 0 8px rgba(255, 170, 0, 0.6);
}

.service-card p,
.status-card p {
  font-size: 0.95rem;
  color: var(--color-text);
  margin: 0;
  line-height: 1.6;
}

.service-card.clickable:hover {
  transform: translateY(-5px);
  box-shadow: 0 0 20px rgba(255, 153, 0, 0.5), inset 0 0 20px rgba(255, 153, 0, 0.1);
  border-color: #ffaa00;
  background: rgba(255, 153, 0, 0.08);
}
</style>
