<template>
  <Teleport to="body">
    <div 
      v-if="isVisible" 
      class="fixed inset-0 z-[9999] overflow-y-auto"
      style="backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);"
      aria-labelledby="modal-title" 
      role="dialog" 
      aria-modal="true"
    >
      <!-- Overlay con backdrop blur -->
      <div 
        @click="handleOverlayClick"
        class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center"
      >
        <div 
          class="fixed inset-0 transition-opacity duration-300"
          style="background-color: rgba(0, 0, 0, 0.4); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px);" 
          aria-hidden="true"
        ></div>

        <!-- Modal Panel -->
        <div 
          @click.stop
          class="relative inline-block bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all duration-300 max-w-md w-full mx-4"
          :class="{ 'scale-100 opacity-100': isVisible, 'scale-95 opacity-0': !isVisible }"
          style="animation: modalSlideIn 0.3s ease-out;"
        >
          <!-- Header con icono -->
          <div class="px-6 pt-6 pb-4">
            <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 rounded-full" :class="iconBackgroundClass">
              <span class="text-3xl">{{ icon }}</span>
            </div>
            <div class="text-center">
              <h3 class="text-xl font-bold text-gray-900 mb-2" id="modal-title">
                {{ title }}
              </h3>
              <p class="text-sm text-gray-600 leading-relaxed">
                {{ message }}
              </p>
            </div>
          </div>

          <!-- Información adicional si existe -->
          <div v-if="additionalInfo" class="px-6 pb-4">
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-3 rounded-r-lg">
              <div class="flex">
                <div class="flex-shrink-0">
                  <span class="text-yellow-400">⚠️</span>
                </div>
                <div class="ml-3">
                  <p class="text-sm text-yellow-800">{{ additionalInfo }}</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Botones de acción -->
          <div class="px-6 py-4 bg-gray-50 flex flex-col space-y-2 sm:flex-row sm:space-y-0 sm:space-x-3 sm:justify-end">
            <button
              @click="handleCancel"
              type="button"
              class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200"
            >
              <span class="mr-2">✕</span>
              {{ cancelText }}
            </button>
            <button
              @click="handleConfirm"
              type="button"
              :class="confirmButtonClass"
              class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors duration-200"
            >
              <span class="mr-2">{{ confirmIcon }}</span>
              {{ confirmText }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </Teleport>
</template>

<script setup>
import { computed, watch } from 'vue';

const props = defineProps({
  isVisible: {
    type: Boolean,
    default: false
  },
  title: {
    type: String,
    required: true
  },
  message: {
    type: String,
    required: true
  },
  additionalInfo: {
    type: String,
    default: ''
  },
  icon: {
    type: String,
    required: true
  },
  variant: {
    type: String,
    default: 'danger', // danger, warning, success, info
    validator: (value) => ['danger', 'warning', 'success', 'info'].includes(value)
  },
  confirmText: {
    type: String,
    default: 'Confirmar'
  },
  cancelText: {
    type: String,
    default: 'Cancelar'
  },
  confirmIcon: {
    type: String,
    default: '✓'
  },
  closeOnOverlay: {
    type: Boolean,
    default: true
  }
});

const emit = defineEmits(['confirm', 'cancel', 'close']);

const iconBackgroundClass = computed(() => {
  const variants = {
    danger: 'bg-red-100',
    warning: 'bg-yellow-100',
    success: 'bg-green-100',
    info: 'bg-blue-100'
  };
  return variants[props.variant];
});

const confirmButtonClass = computed(() => {
  const variants = {
    danger: 'bg-red-600 hover:bg-red-700 focus:ring-red-500',
    warning: 'bg-yellow-600 hover:bg-yellow-700 focus:ring-yellow-500',
    success: 'bg-green-600 hover:bg-green-700 focus:ring-green-500',
    info: 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500'
  };
  return variants[props.variant];
});

const handleConfirm = () => {
  emit('confirm');
};

const handleCancel = () => {
  emit('cancel');
};

const handleOverlayClick = () => {
  if (props.closeOnOverlay) {
    emit('close');
  }
};

// Prevenir scroll del body cuando el modal está visible
watch(() => props.isVisible, (newValue) => {
  if (newValue) {
    document.body.style.overflow = 'hidden';
  } else {
    document.body.style.overflow = 'unset';
  }
});
</script>

<style scoped>
@keyframes modalSlideIn {
  from {
    opacity: 0;
    transform: translate3d(0, -20px, 0) scale3d(0.95, 0.95, 1);
  }
  to {
    opacity: 1;
    transform: translate3d(0, 0, 0) scale3d(1, 1, 1);
  }
}
</style>