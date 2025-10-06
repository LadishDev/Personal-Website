<template>
  <div class="search-container">
    <div class="search-wrapper">
      <span class="search-prompt">root@homelab:~$</span>
      <input 
        type="text" 
        v-model="localSearchQuery"
        @keydown.esc="clearSearch"
        :placeholder="placeholder"
        class="search-input"
      />
      <span class="search-cursor" v-if="!localSearchQuery">_</span>
      <button v-if="localSearchQuery" @click="clearSearch" class="clear-btn" title="Clear search (ESC)">✕</button>
    </div>
    <div class="search-hint" v-if="localSearchQuery">
      <span v-if="resultCount > 0">
        Found <span class="search-query-display">{{ resultCount }}</span> result{{ resultCount !== 1 ? 's' : '' }} 
        for "<span class="search-query-display">{{ localSearchQuery }}</span>"
      </span>
    </div>
  </div>
</template>

<script setup>
import { ref, watch, computed } from 'vue'

const props = defineProps({
  modelValue: {
    type: String,
    default: ''
  },
  resultCount: {
    type: Number,
    default: null
  },
  placeholder: {
    type: String,
    default: 'Type to search documentation...'
  }
})

const emit = defineEmits(['update:modelValue'])

const localSearchQuery = ref(props.modelValue)

// Watch for changes and emit to parent
watch(localSearchQuery, (newValue) => {
  emit('update:modelValue', newValue)
})

// Watch for external changes
watch(() => props.modelValue, (newValue) => {
  localSearchQuery.value = newValue
})

const isSearching = computed(() => localSearchQuery.value.length > 0)

const clearSearch = () => {
  localSearchQuery.value = ''
}
</script>

<style scoped>
/* Search Field */
.search-container {
  margin: 30px 0 40px 0;
  max-width: 800px;
}

.search-wrapper {
  display: flex;
  align-items: center;
  background: rgba(255, 153, 0, 0.05);
  border: 2px solid #ff9900;
  padding: 15px 20px;
  box-shadow: 0 0 15px rgba(255, 153, 0, 0.3), inset 0 0 15px rgba(255, 153, 0, 0.1);
  position: relative;
  transition: all 0.3s ease;
}

.search-wrapper:focus-within {
  box-shadow: 0 0 25px rgba(255, 153, 0, 0.5), inset 0 0 20px rgba(255, 153, 0, 0.15);
  border-color: #ffaa00;
  background: rgba(255, 153, 0, 0.08);
}

.search-prompt {
  color: #ff9900;
  font-weight: 700;
  margin-right: 10px;
  text-shadow: 0 0 8px rgba(255, 153, 0, 0.8);
  white-space: nowrap;
}

.search-input {
  flex: 1;
  background: transparent;
  border: none;
  outline: none;
  color: #ffaa00;
  font-family: 'Courier New', 'Consolas', monospace;
  font-size: 1rem;
  font-weight: 600;
  text-shadow: 0 0 5px rgba(255, 170, 0, 0.6);
}

.search-input::placeholder {
  color: rgba(255, 170, 0, 0.4);
  font-style: italic;
}

.clear-btn {
  background: transparent;
  border: 2px solid #ff9900;
  color: #ff9900;
  padding: 5px 12px;
  cursor: pointer;
  font-family: 'Courier New', 'Consolas', monospace;
  font-weight: 700;
  transition: all 0.3s ease;
  text-shadow: 0 0 5px rgba(255, 153, 0, 0.6);
  margin-left: 10px;
}

.clear-btn:hover {
  background: rgba(255, 153, 0, 0.2);
  box-shadow: 0 0 10px rgba(255, 153, 0, 0.5);
  transform: scale(1.1);
}

.search-cursor {
  color: #ff9900;
  font-weight: 700;
  animation: blink 1s infinite;
  margin-left: 2px;
  text-shadow: 0 0 8px rgba(255, 153, 0, 0.8);
}

@keyframes blink {
  0%, 49% {
    opacity: 1;
  }
  50%, 100% {
    opacity: 0;
  }
}

.search-hint {
  margin-top: 10px;
  padding: 10px 15px;
  background: rgba(255, 153, 0, 0.1);
  border-left: 3px solid #ff9900;
  color: var(--color-text);
  font-size: 0.9rem;
}

.search-query-display {
  color: #ffaa00;
  font-weight: 700;
  text-shadow: 0 0 5px rgba(255, 170, 0, 0.6);
}

kbd {
  background: rgba(255, 153, 0, 0.2);
  border: 1px solid #ff9900;
  padding: 2px 6px;
  border-radius: 3px;
  font-family: 'Courier New', 'Consolas', monospace;
  font-size: 0.85rem;
  color: #ffaa00;
  box-shadow: 0 0 5px rgba(255, 153, 0, 0.3);
}
</style>
