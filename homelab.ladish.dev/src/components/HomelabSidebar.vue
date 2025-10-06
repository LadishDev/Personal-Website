<script setup>
import { ref, onMounted } from 'vue'

const stats = ref({
  cpu: '--',
  mem: '--',
  swap: '--',
  load: '--',
  containers: '--',
  vms: '--',
  storage: '--',
  lastUpdate: 'Never'
})

const fetchServerStats = async () => {
  try {
    const response = await fetch('https://ladish.dev/api/server-stats')
    if (response.ok) {
      const data = await response.json()
      stats.value = {
        cpu: data.cpu || '--',
        mem: data.memory || '--',
        swap: data.swap || '--',
        load: data.load || '--',
        containers: data.containers || '--',
        vms: data.vms || '--',
        storage: data.storage || '--',
        lastUpdate: new Date().toLocaleString()
      }
    }
  } catch (error) {
    console.error('Failed to fetch server stats:', error)
  }
}

onMounted(() => {
  fetchServerStats()
  // Update stats every 30 seconds
  setInterval(fetchServerStats, 30000)
})
</script>

<template>
  <aside class="homelab-sidebar">
    <div class="sidebar-card">
      <div class="sidebar-header">
        <div class="logo-circle">
          <img src="/favicon.ico" alt="Ladish Logo" />
        </div>
        <h2>ladish.dev</h2>
        <div class="social-icons">
          <a href="https://bsky.app/profile/ladish.dev" target="_blank" aria-label="Bluesky">
            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12 10.8c-1.087-2.114-4.046-6.053-6.798-7.995C2.566.944 1.561 1.266.902 1.565.139 1.908 0 3.08 0 3.768c0 .69.378 5.65.624 6.479.815 2.736 3.713 3.66 6.383 3.364.136-.02.275-.039.415-.056-.138.022-.276.04-.415.056-3.912.58-7.387 2.005-2.83 7.078 5.013 5.19 6.87-1.113 7.823-4.308.953 3.195 2.05 9.271 7.733 4.308 4.267-4.308 1.172-6.498-2.74-7.078a8.741 8.741 0 0 1-.415-.056c.14.017.279.036.415.056 2.67.297 5.568-.628 6.383-3.364.246-.828.624-5.79.624-6.478 0-.69-.139-1.861-.902-2.206-.659-.298-1.664-.62-4.3 1.24C16.046 4.748 13.087 8.687 12 10.8Z"/>
            </svg>
          </a>
          <a href="https://github.com/LadishDev" target="_blank" aria-label="GitHub">
            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
            </svg>
          </a>
          <a href="https://www.linkedin.com/in/callum-ladish/" target="_blank" aria-label="LinkedIn">
            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
              <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
            </svg>
          </a>
        </div>
      </div>

      <div class="sidebar-section">
        <h3>Server Stats</h3>
        <div class="stats">
          <div class="stat-row">
            <span>CPU % today</span>
            <span>{{ stats.cpu }}</span>
          </div>
          <div class="stat-row">
            <span>Used Mem</span>
            <span>{{ stats.mem }}</span>
          </div>
          <div class="stat-row">
            <span>Used Swap</span>
            <span>{{ stats.swap }}</span>
          </div>
          <div class="stat-row">
            <span>5 min Load Avg</span>
            <span>{{ stats.load }}</span>
          </div>
          <div class="stat-row">
            <span>Running Containers</span>
            <span>{{ stats.containers }}</span>
          </div>
          <div class="stat-row">
            <span>Running VMs</span>
            <span>{{ stats.vms }}</span>
          </div>
          <div class="stat-row">
            <span>Storage</span>
            <span>{{ stats.storage }}</span>
          </div>
        </div>
        <div class="stats-update">Last updated: <span>{{ stats.lastUpdate }}</span></div>
      </div>

      <div class="sidebar-section">
        <h3>Server Specs</h3>
        <div class="specs">
          <div class="spec-row">AMD Ryzen 5 2600 CPU @ 3.40GHz, 12 threads</div>
          <div class="spec-row">2x 16GB + 2x 32GB @ 3200mhz</div>
          <div class="spec-row">NVIDIA Corporation GT215 [GeForce GT 340] GPU</div>
        </div>
      </div>

      <div class="sidebar-section">
        <div class="sidebar-badges" style="flex-direction: column;">
          <img src="/badges/opensource.png" alt="Open Source" class="sidebar-badge-full" />
          <img src="/badges/amd.gif" alt="AMD" class="sidebar-badge-full" />
          <img src="/badges/linux.gif" alt="Linux" class="sidebar-badge-full" />
        </div>
      </div>
    </div>
  </aside>
</template>

<style scoped>
/* Sidebar */
.homelab-sidebar {
  width: 320px;
  background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 100%);
  padding: 20px;
  color: #ffaa00;
  flex-shrink: 0;
  min-height: 100vh;
  font-family: 'Courier New', 'Consolas', monospace;
  position: relative;
}

/* Scanline effect overlay */
.homelab-sidebar::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: repeating-linear-gradient(
    0deg,
    rgba(0, 0, 0, 0.15),
    rgba(0, 0, 0, 0.15) 1px,
    transparent 1px,
    transparent 2px
  );
  pointer-events: none;
  z-index: 1;
}

.sidebar-card {
  background: rgba(255, 170, 0, 0.03);
  border-radius: 0;
  padding: 20px;
  border: 2px solid #ff9900;
  box-shadow: 0 0 10px rgba(255, 153, 0, 0.3), inset 0 0 10px rgba(255, 153, 0, 0.1);
  position: relative;
  z-index: 2;
}

.sidebar-header {
  text-align: center;
  margin-bottom: 20px;
  padding-bottom: 15px;
  border-bottom: 2px solid #ff9900;
  box-shadow: 0 2px 5px rgba(255, 153, 0, 0.3);
}

.logo-circle {
  width: 120px;
  height: 120px;
  margin: 0 auto 15px;
  background: radial-gradient(circle, #1a1a1a 0%, #0a0a0a 100%);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  border: 3px solid #ff9900;
  box-shadow: 0 0 20px rgba(255, 153, 0, 0.6), inset 0 0 20px rgba(255, 153, 0, 0.2);
}

.logo-circle img {
  width: 80px;
  height: 80px;
  object-fit: contain;
  filter: brightness(1.3) sepia(0.3) hue-rotate(15deg);
}

.sidebar-header h2 {
  font-size: 1.8rem;
  margin: 0 0 15px 0;
  color: #ffaa00;
  font-weight: 700;
  text-shadow: 0 0 10px rgba(255, 170, 0, 0.8);
  letter-spacing: 1px;
}

.social-icons {
  display: flex;
  gap: 15px;
  justify-content: center;
}

.social-icons a {
  color: #ff9900;
  transition: all 0.3s ease;
  opacity: 0.8;
  filter: drop-shadow(0 0 3px rgba(255, 153, 0, 0.6));
}

.social-icons a:hover {
  opacity: 1;
  color: #ffaa00;
  transform: translateY(-2px);
  filter: drop-shadow(0 0 8px rgba(255, 170, 0, 0.9));
}

.sidebar-section {
  margin-bottom: 20px;
  padding-bottom: 15px;
  border-bottom: 1px solid #ff9900;
  box-shadow: 0 1px 3px rgba(255, 153, 0, 0.2);
}

.sidebar-section:last-child {
  border-bottom: none;
}

.sidebar-section h3 {
  font-size: 1.1rem;
  margin: 0 0 15px 0;
  color: #ffaa00;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 2px;
  text-shadow: 0 0 8px rgba(255, 170, 0, 0.6);
}

.stats {
  display: flex;
  flex-direction: column;
  gap: 6px;
}

.stat-row {
  display: flex;
  justify-content: space-between;
  font-size: 0.95rem;
  padding: 4px 0;
}

.stat-row span:first-child {
  color: rgba(255, 170, 0, 0.6);
}

.stat-row span:last-child {
  color: #ffaa00;
  font-weight: 700;
  font-family: 'Courier New', 'Consolas', monospace;
  text-shadow: 0 0 5px rgba(255, 170, 0, 0.5);
}

.stats-update {
  margin-top: 8px;
  font-size: 0.85rem;
  color: rgba(255, 170, 0, 0.5);
  font-style: italic;
}

.specs {
  display: flex;
  flex-direction: column;
  gap: 6px;
}

.spec-row {
  font-size: 0.9rem;
  line-height: 1.6;
  color: rgba(255, 170, 0, 0.8);
  padding: 4px 0;
}

.specs-text {
  font-size: 0.9rem;
  line-height: 1.6;
  color: rgba(255, 170, 0, 0.8);
}

.sidebar-badges {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
  margin-bottom: 10px;
}

.sidebar-badge-full {
  width: 100%;
  height: auto;
  border-radius: 4px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

/* Dark mode adjustments */
@media (prefers-color-scheme: dark) {
  .homelab-sidebar {
    background: linear-gradient(135deg, #000000 0%, #0a0a0a 100%);
  }
}
</style>
