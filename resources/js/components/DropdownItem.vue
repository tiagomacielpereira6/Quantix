<template>
  <component 
    :is="componentType"
    :href="href"
    :class="itemClasses"
    class="group flex items-center px-4 py-2 text-sm transition-colors duration-200"
    role="menuitem"
    tabindex="-1"
    @click="handleClick"
  >
    <span class="mr-3 flex-shrink-0" v-if="icon">{{ icon }}</span>
    <div class="flex flex-col flex-1">
      <span class="font-medium">{{ label }}</span>
      <span v-if="description" class="text-xs text-gray-500">{{ description }}</span>
    </div>
  </component>
</template>

<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
  label: {
    type: String,
    required: true
  },
  description: {
    type: String,
    default: ''
  },
  icon: {
    type: String,
    default: ''
  },
  href: {
    type: String,
    default: null
  },
  variant: {
    type: String,
    default: 'default', // default, danger, success, warning
    validator: (value) => ['default', 'danger', 'success', 'warning'].includes(value)
  },
  disabled: {
    type: Boolean,
    default: false
  }
});

const emit = defineEmits(['click']);

const componentType = computed(() => {
  return props.href ? Link : 'button';
});

const itemClasses = computed(() => {
  const base = 'w-full text-left';
  
  if (props.disabled) {
    return `${base} text-gray-400 cursor-not-allowed opacity-50`;
  }
  
  const variants = {
    default: 'text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:bg-gray-100',
    danger: 'text-red-700 hover:bg-red-50 hover:text-red-900 focus:bg-red-50',
    success: 'text-green-700 hover:bg-green-50 hover:text-green-900 focus:bg-green-50',
    warning: 'text-yellow-700 hover:bg-yellow-50 hover:text-yellow-900 focus:bg-yellow-50'
  };
  
  return `${base} ${variants[props.variant]}`;
});

const handleClick = (event) => {
  if (props.disabled) {
    event.preventDefault();
    return;
  }
  
  emit('click', event);
};
</script>