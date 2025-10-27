<script setup>
import { inject, defineExpose, computed } from 'vue'
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


defineExpose({ viewDoc, viewDocs, handleServiceClick })

</script>

<template>
  <div class="page-content">

    <h1>Welcome to My Homelab!</h1>
    <p class="intro-text">
      This is my playground for learning, experimenting, and self-hosting services.  
      Below are some of the highlights, with links to documentation if you'd like to dive deeper.
    </p>
    

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
  opacity: 1;
  transition: opacity 0.3s ease;
  pointer-events: none;
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
