<template>
  <div class="relative inline-block text-left" ref="dropdown">
    <!-- Botón trigger -->
    <div>
      <button 
        type="button"
        @click="toggleDropdown"
        :class="buttonClass"
        class="inline-flex items-center justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors"
        :id="'dropdown-button-' + dropdownId"
        aria-expanded="false"
        aria-haspopup="true"
      >
        <slot name="trigger">
          {{ triggerText }}
        </slot>
        <svg class="-mr-1 ml-2 h-5 w-5 transition-transform duration-200" 
             :class="{ 'rotate-180': isOpen }"
             xmlns="http://www.w3.org/2000/svg" 
             viewBox="0 0 20 20" 
             fill="currentColor" 
             aria-hidden="true">
          <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
        </svg>
      </button>
    </div>

    <!-- Menú dropdown -->
    <Teleport to="body">
      <div 
        v-show="isOpen"
        :style="dropdownStyle"
        class="absolute z-50 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none transform opacity-0 scale-95 transition-all duration-200"
        :class="{ 'opacity-100 scale-100': isOpen }"
        role="menu"
        :aria-orientation="'vertical'"
        :aria-labelledby="'dropdown-button-' + dropdownId"
        tabindex="-1"
      >
        <div class="py-1" role="none">
          <slot name="items"></slot>
        </div>
      </div>
    </Teleport>

    <!-- Backdrop para cerrar cuando se hace clic afuera -->
    <div 
      v-if="isOpen"
      @click="closeDropdown"
      class="fixed inset-0 z-40"
    ></div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted, nextTick } from 'vue';

const props = defineProps({
  triggerText: {
    type: String,
    default: 'Acciones'
  },
  buttonClass: {
    type: String,
    default: ''
  }
});

const dropdown = ref(null);
const isOpen = ref(false);
const dropdownId = ref(Math.random().toString(36).substr(2, 9));
const dropdownStyle = ref({});

const toggleDropdown = async () => {
  isOpen.value = !isOpen.value;
  
  if (isOpen.value) {
    await nextTick();
    updateDropdownPosition();
  }
};

const closeDropdown = () => {
  isOpen.value = false;
};

const updateDropdownPosition = () => {
  if (!dropdown.value) return;
  
  const rect = dropdown.value.getBoundingClientRect();
  const viewportHeight = window.innerHeight;
  const viewportWidth = window.innerWidth;
  
  let top = rect.bottom + window.scrollY;
  let left = rect.left + window.scrollX;
  
  // Ajustar si se sale por la derecha
  if (left + 224 > viewportWidth) { // 224px = w-56
    left = rect.right + window.scrollX - 224;
  }
  
  // Ajustar si se sale por abajo
  if (rect.bottom + 200 > viewportHeight) {
    top = rect.top + window.scrollY - 200;
  }
  
  dropdownStyle.value = {
    position: 'absolute',
    top: `${top}px`,
    left: `${left}px`
  };
};

const handleKeydown = (e) => {
  if (e.key === 'Escape') {
    closeDropdown();
  }
};

onMounted(() => {
  document.addEventListener('keydown', handleKeydown);
});

onUnmounted(() => {
  document.removeEventListener('keydown', handleKeydown);
});

defineExpose({
  closeDropdown
});
</script>