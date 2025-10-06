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
        <div class="service-card">
          <h3>Proxmox VE</h3>
          <p>Virtualization platform managing VMs and containers</p>
        </div>
        <div class="service-card">
          <h3>Pi-hole</h3>
          <p>Network-wide ad blocking and DNS management</p>
        </div>
        <div class="service-card">
          <h3>Docker</h3>
          <p>Container orchestration for various services</p>
        </div>
        <div class="service-card">
          <h3>Zoraxy</h3>
          <p>Reverse proxy with SSL certificate management</p>
        </div>
      </div>
    </section>

    <section class="section-group">
      <h2 class="section-title">System Status</h2>
      <div class="status-grid">
        <div class="status-card">
          <h3>All Systems Operational</h3>
          <p class="status-indicator operational">● ONLINE</p>
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

.status-indicator {
  font-size: 1.2rem;
  font-weight: 700;
  margin-top: 10px;
}

.status-indicator.operational {
  color: #00ff00;
  text-shadow: 0 0 10px rgba(0, 255, 0, 0.8);
}
</style>
