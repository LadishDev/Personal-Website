<script setup>
import { ref, inject } from 'vue'

const isMenuOpen = ref(false)
const setPage = inject('setPage')
const currentPage = inject('currentPage')

const toggleMenu = () => {
  isMenuOpen.value = !isMenuOpen.value
}

const closeMenu = () => {
  isMenuOpen.value = false
}

const navigate = (page) => {
  setPage(page)
  closeMenu()
}
</script>

<template>
  <nav class="navbar">
    <!-- Desktop Tabs -->
    <div class="tabs desktop-tabs">
      <a @click="navigate('overview')" class="tab" :class="{ active: currentPage === 'overview' }">Overview</a>
      <a @click="navigate('docs')" class="tab" :class="{ active: currentPage === 'docs' }">Docs</a>
      <a @click="navigate('services')" class="tab" :class="{ active: currentPage === 'services' }">Services</a>
      <a @click="navigate('infrastructure')" class="tab" :class="{ active: currentPage === 'infrastructure' }">Infrastructure</a>
    </div>

    <!-- Mobile Hamburger Menu -->
    <div class="mobile-nav">
      <button 
        class="hamburger" 
        :class="{ active: isMenuOpen }" 
        @click="toggleMenu"
        aria-label="Toggle menu"
      >
        <span class="hamburger-line"></span>
        <span class="hamburger-line"></span>
        <span class="hamburger-line"></span>
      </button>

      <!-- Mobile Menu Dropdown -->
      <div class="mobile-menu" :class="{ open: isMenuOpen }">
        <a @click="navigate('overview')" class="mobile-tab" :class="{ active: currentPage === 'overview' }">Overview</a>
        <a @click="navigate('docs')" class="mobile-tab" :class="{ active: currentPage === 'docs' }">Docs</a>
        <a @click="navigate('services')" class="mobile-tab" :class="{ active: currentPage === 'services' }">Services</a>
        <a @click="navigate('infrastructure')" class="mobile-tab" :class="{ active: currentPage === 'infrastructure' }">Infrastructure</a>
      </div>
    </div>
  </nav>
</template>

<style scoped>
.navbar {
  background: var(--color-background-soft);
  border-bottom: 3px solid #ff9900;
  box-shadow: 0 3px 15px rgba(255, 153, 0, 0.5), inset 0 -2px 10px rgba(255, 153, 0, 0.2);
  position: sticky;
  top: 0;
  z-index: 100;
  font-family: 'Courier New', 'Consolas', monospace;
}

/* Desktop Tabs */
.tabs {
  display: flex;
  padding: 0 40px;
  gap: 15px;
}

.desktop-tabs {
  display: none;
}

@media (min-width: 768px) {
  .desktop-tabs {
    display: flex;
  }
}

.tab {
  padding: 15px 20px;
  text-decoration: none;
  color: var(--color-text);
  border: 2px solid transparent;
  transition: all 0.3s ease;
  font-weight: 700;
  cursor: pointer;
  text-transform: uppercase;
  letter-spacing: 2px;
  position: relative;
  background: transparent;
}

.tab::before {
  content: '[ ';
  color: #ff9900;
  opacity: 0;
  transition: opacity 0.3s ease;
}

.tab::after {
  content: ' ]';
  color: #ff9900;
  opacity: 0;
  transition: opacity 0.3s ease;
}

.tab:hover {
  background: rgba(255, 153, 0, 0.1);
  color: var(--color-heading);
  text-shadow: 0 0 10px rgba(255, 170, 0, 0.8);
  border: 2px solid #ff9900;
  box-shadow: 0 0 10px rgba(255, 153, 0, 0.4), inset 0 0 10px rgba(255, 153, 0, 0.2);
}

.tab:hover::before,
.tab:hover::after {
  opacity: 1;
}

.tab.active {
  border: 2px solid #ff9900;
  color: #ffaa00;
  text-shadow: 0 0 15px rgba(255, 170, 0, 1);
  background: rgba(255, 153, 0, 0.15);
  box-shadow: 0 0 20px rgba(255, 153, 0, 0.6), inset 0 0 20px rgba(255, 153, 0, 0.3);
}

.tab.active::before,
.tab.active::after {
  opacity: 1;
  text-shadow: 0 0 10px rgba(255, 153, 0, 0.8);
}

/* Mobile Navigation */
.mobile-nav {
  display: block;
  position: relative;
  padding: 12px 0;
}

@media (min-width: 768px) {
  .mobile-nav {
    display: none;
  }
}

/* Hamburger Button */
.hamburger {
  display: flex;
  flex-direction: column;
  justify-content: space-around;
  width: 40px;
  height: 40px;
  background: transparent;
  border: none;
  cursor: pointer;
  padding: 8px;
  margin: 0;
  margin-left: 20px;
  z-index: 101;
}

.hamburger-line {
  width: 100%;
  height: 3px;
  background: #ff9900;
  border-radius: 0;
  transition: all 0.3s ease;
  transform-origin: center;
  box-shadow: 0 0 5px rgba(255, 153, 0, 0.6);
}

.hamburger.active .hamburger-line:nth-child(1) {
  transform: translateY(8px) rotate(45deg);
}

.hamburger.active .hamburger-line:nth-child(2) {
  opacity: 0;
}

.hamburger.active .hamburger-line:nth-child(3) {
  transform: translateY(-8px) rotate(-45deg);
}

/* Mobile Menu Dropdown */
.mobile-menu {
  position: absolute;
  top: 100%;
  left: 0;
  right: 0;
  background: var(--color-background-soft);
  border-bottom: 2px solid #ff9900;
  display: flex;
  flex-direction: column;
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.3s ease, opacity 0.3s ease;
  opacity: 0;
  box-shadow: 0 4px 8px rgba(255, 153, 0, 0.3);
}

.mobile-menu.open {
  max-height: 300px;
  opacity: 1;
}

.mobile-tab {
  padding: 15px 20px;
  text-decoration: none;
  color: var(--color-text);
  border-left: 3px solid transparent;
  transition: all 0.3s ease;
  font-weight: 700;
  cursor: pointer;
  text-transform: uppercase;
  letter-spacing: 2px;
  position: relative;
}

.mobile-tab::before {
  content: '> ';
  color: #ff9900;
  opacity: 0;
  transition: opacity 0.3s ease;
}

.mobile-tab:hover {
  background: rgba(255, 153, 0, 0.1);
  color: var(--color-heading);
  text-shadow: 0 0 10px rgba(255, 170, 0, 0.8);
  border-left-color: #ff9900;
}

.mobile-tab:hover::before {
  opacity: 1;
}

.mobile-tab.active {
  border-left-color: #ff9900;
  color: #ff9900;
  background: var(--color-background-mute);
  text-shadow: 0 0 5px rgba(255, 153, 0, 0.6);
}

/* Dark mode adjustments */
@media (prefers-color-scheme: dark) {
  .mobile-menu {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
  }
}
</style>
