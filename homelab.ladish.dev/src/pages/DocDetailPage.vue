<script setup>
import { ref, computed, onMounted, watch } from 'vue'
import { useDocs } from '../composables/useDocumentation.js'
import { marked } from 'marked'

const props = defineProps({
  slug: String,
  type: String // 'service' or 'guide'
})

const { docs, guides, loading } = useDocs()

const currentDoc = computed(() => {
  if (props.type === 'guide') {
    return guides.value.find(g => g.slug === props.slug)
  } else {
    return docs.value.find(d => d.slug === props.slug)
  }
})

const htmlContent = computed(() => {
  if (!currentDoc.value?.content) return ''
  return marked(currentDoc.value.content)
})

const goBack = () => {
  window.history.back()
}
</script>

<template>
  <div class="doc-detail-page">
    <!-- Back Button -->
    <button class="back-button" @click="goBack">
      ← Back to Documentation
    </button>

    <!-- Loading State -->
    <div v-if="loading" class="loading-state">
      <span class="loading-spinner">⟳</span> Loading...
    </div>

    <!-- Content -->
    <template v-else-if="currentDoc">
      <div class="doc-detail-header">
        <div class="doc-title-row">
          <h1>{{ currentDoc.title }}</h1>
          <span class="doc-status" :class="{ pending: currentDoc.status === 'pending' }">
            {{ currentDoc.status === 'documented' ? '● DOCUMENTED' : '○ IN PROGRESS' }}
          </span>
        </div>
        <p class="doc-description">{{ currentDoc.description }}</p>
        <div class="doc-meta-info">
          <span v-if="currentDoc.updated">Last updated: {{ currentDoc.updated }}</span>
          <span v-if="currentDoc.tags && currentDoc.tags.length > 0" class="tags">
            Tags: {{ currentDoc.tags.join(', ') }}
          </span>
        </div>
      </div>

      <!-- MDX Content -->
      <div class="doc-content markdown-body" v-html="htmlContent"></div>
    </template>

    <!-- Not Found -->
    <div v-else class="not-found">
      <h2>Document Not Found</h2>
      <p>The requested {{ type }} could not be found.</p>
      <button class="back-button" @click="goBack">
        ← Back to Documentation
      </button>
    </div>
  </div>
</template>

<style scoped>
.doc-detail-page {
  font-family: 'Courier New', 'Consolas', monospace;
  max-width: 900px;
  margin: 0 auto;
  padding: 20px;
}

.back-button {
  padding: 10px 20px;
  background: rgba(255, 153, 0, 0.1);
  border: 2px solid #ff9900;
  color: #ff9900;
  font-family: 'Courier New', 'Consolas', monospace;
  font-size: 0.9rem;
  font-weight: 700;
  text-transform: uppercase;
  cursor: pointer;
  transition: all 0.3s ease;
  margin-bottom: 30px;
  text-shadow: 0 0 8px rgba(255, 153, 0, 0.6);
}

.back-button:hover {
  background: rgba(255, 153, 0, 0.2);
  box-shadow: 0 0 15px rgba(255, 153, 0, 0.4);
  transform: translateX(-5px);
}

.doc-detail-header {
  margin-bottom: 40px;
  padding-bottom: 20px;
  border-bottom: 2px solid rgba(255, 153, 0, 0.3);
}

.doc-title-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 15px;
  flex-wrap: wrap;
  gap: 15px;
}

.doc-detail-header h1 {
  font-size: 2.5rem;
  margin: 0;
  color: var(--color-heading);
  text-transform: uppercase;
  letter-spacing: 2px;
  text-shadow: 0 0 10px rgba(255, 170, 0, 0.6);
}

.doc-status {
  font-size: 0.9rem;
  font-weight: 700;
  color: #00ff00;
  text-shadow: 0 0 5px rgba(0, 255, 0, 0.8);
  white-space: nowrap;
}

.doc-status.pending {
  color: #ffaa00;
  text-shadow: 0 0 5px rgba(255, 170, 0, 0.8);
}

.doc-description {
  font-size: 1.1rem;
  color: var(--color-text);
  margin: 15px 0;
  line-height: 1.6;
}

.doc-meta-info {
  display: flex;
  gap: 20px;
  font-size: 0.85rem;
  color: rgba(255, 170, 0, 0.6);
  font-style: italic;
  flex-wrap: wrap;
}

.tags {
  color: rgba(255, 170, 0, 0.8);
}

/* Markdown Content Styling */
.doc-content {
  line-height: 1.8;
  color: var(--color-text);
}

.markdown-body :deep(h2) {
  font-size: 1.8rem;
  color: #ff9900;
  margin-top: 40px;
  margin-bottom: 20px;
  text-transform: uppercase;
  letter-spacing: 1px;
  text-shadow: 0 0 8px rgba(255, 153, 0, 0.6);
  border-bottom: 2px solid rgba(255, 153, 0, 0.3);
  padding-bottom: 10px;
}

.markdown-body :deep(h3) {
  font-size: 1.4rem;
  color: #ffaa00;
  margin-top: 30px;
  margin-bottom: 15px;
  text-shadow: 0 0 5px rgba(255, 170, 0, 0.5);
}

.markdown-body :deep(p) {
  margin: 15px 0;
  line-height: 1.8;
}

.markdown-body :deep(code) {
  background: rgba(255, 153, 0, 0.1);
  border: 1px solid rgba(255, 153, 0, 0.3);
  padding: 2px 6px;
  border-radius: 3px;
  font-family: 'Courier New', 'Consolas', monospace;
  color: #ff9900;
}

.markdown-body :deep(pre) {
  background: rgba(0, 0, 0, 0.3);
  border: 2px solid #ff9900;
  border-left: 4px solid #ff9900;
  padding: 20px;
  overflow-x: auto;
  margin: 20px 0;
  box-shadow: 0 0 10px rgba(255, 153, 0, 0.2);
}

.markdown-body :deep(pre code) {
  background: transparent;
  border: none;
  padding: 0;
  color: #00ff00;
}

.markdown-body :deep(ul),
.markdown-body :deep(ol) {
  margin: 15px 0;
  padding-left: 30px;
}

.markdown-body :deep(li) {
  margin: 8px 0;
  line-height: 1.6;
}

.markdown-body :deep(a) {
  color: #ff9900;
  text-decoration: none;
  border-bottom: 1px solid rgba(255, 153, 0, 0.3);
  transition: all 0.3s ease;
}

.markdown-body :deep(a:hover) {
  text-shadow: 0 0 8px rgba(255, 153, 0, 0.8);
  border-bottom-color: #ff9900;
}

.markdown-body :deep(blockquote) {
  border-left: 4px solid #ff9900;
  padding-left: 20px;
  margin: 20px 0;
  color: rgba(255, 170, 0, 0.8);
  font-style: italic;
}

.markdown-body :deep(table) {
  width: 100%;
  border-collapse: collapse;
  margin: 20px 0;
}

.markdown-body :deep(th),
.markdown-body :deep(td) {
  border: 1px solid rgba(255, 153, 0, 0.3);
  padding: 10px;
  text-align: left;
}

.markdown-body :deep(th) {
  background: rgba(255, 153, 0, 0.1);
  color: #ff9900;
  font-weight: 700;
  text-transform: uppercase;
}

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

.not-found {
  text-align: center;
  padding: 60px 20px;
}

.not-found h2 {
  color: #ff9900;
  font-size: 2rem;
  margin-bottom: 20px;
  text-shadow: 0 0 10px rgba(255, 153, 0, 0.6);
}

.not-found p {
  color: var(--color-text);
  margin-bottom: 30px;
}
</style>
