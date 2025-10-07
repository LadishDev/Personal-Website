<script setup>
import { ref, computed, inject } from 'vue'
import { useLabNotes } from '../composables/useLabNotes.js'

// Inject navigation function
const viewNote = inject('viewNote')

// Load lab notes from MDX files
const { notes, loading } = useLabNotes()

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
        <span class="note-category">{{ note.category }}</span>
        <h3 class="note-title">{{ note.title }}</h3>
        <p class="note-preview">{{ note.preview }}</p>
        <div class="note-meta">
          <span>Last updated: {{ note.date }}</span>
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

.note-category {
  display: inline-block;
  align-self: flex-start;
  padding: 4px 12px;
  background: rgba(255, 153, 0, 0.2);
  border: 1px solid #ff9900;
  font-size: 0.75rem;
  font-weight: 700;
  text-transform: uppercase;
  color: #ff9900;
  text-shadow: 0 0 5px rgba(255, 153, 0, 0.6);
  margin-bottom: 10px;
}

.note-title {
  font-size: 1.2rem;
  color: var(--color-heading);
  margin: 0 0 10px 0;
  text-transform: uppercase;
  letter-spacing: 1px;
  text-shadow: 0 0 8px rgba(255, 153, 0, 0.6);
}

.note-preview {
  font-size: 0.95rem;
  color: var(--color-text);
  line-height: 1.6;
  margin: 10px 0;
}

.note-meta {
  margin-top: 15px;
  padding-top: 10px;
  border-top: 1px solid rgba(255, 153, 0, 0.3);
  font-size: 0.85rem;
  color: rgba(255, 170, 0, 0.6);
  font-style: italic;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.read-more {
  font-size: 0.9rem;
  color: #ff9900;
  font-weight: 700;
  text-shadow: 0 0 5px rgba(255, 153, 0, 0.6);
  font-style: normal;
}
</style>
