# 🎨 Documentación Frontend - Sistema Carrito Comida Rápida

## 📋 Índice
1. [Arquitectura Frontend](#-arquitectura-frontend)
2. [Tecnologías y Herramientas](#-tecnologías-y-herramientas)
3. [Estructura de Directorios](#-estructura-de-directorios)
4. [Componentes Principales](#-componentes-principales)
5. [Sistema de Routing](#-sistema-de-routing)
6. [Gestión de Estado](#-gestión-de-estado)
7. [Interfaz de Usuario](#-interfaz-de-usuario)
8. [Optimizaciones y Performance](#-optimizaciones-y-performance)

---

## 🏗️ Arquitectura Frontend

### Patrón Arquitectónico
El frontend implementa una **arquitectura SPA moderna** utilizando el patrón **MVVM (Model-View-ViewModel)** con las siguientes capas:

```
┌─────────────────────────────────────────────────────────┐
│                    Presentación                         │
├─────────────────────────────────────────────────────────┤
│  Vue.js Components + Tailwind CSS + Inertia.js         │
│  • Páginas (Views)                                      │
│  • Componentes Reutilizables                           │
│  • Layouts y Templates                                  │
├─────────────────────────────────────────────────────────┤
│                   Lógica de Negocio                     │
├─────────────────────────────────────────────────────────┤
│  Composables + Stores + Services                        │
│  • Gestión de estado                                    │
│  • Comunicación con backend                             │
│  • Validaciones frontend                                │
├─────────────────────────────────────────────────────────┤
│                  Capa de Datos                          │
├─────────────────────────────────────────────────────────┤
│  Inertia.js + Axios                                     │
│  • Sincronización con Laravel                           │
│  • Manejo de formularios                                │
│  • Cache local                                          │
└─────────────────────────────────────────────────────────┘
```

### Filosofía de Desarrollo
- **Component-First**: Cada funcionalidad se encapsula en componentes reutilizables
- **Responsive Design**: Diseño móvil primero con breakpoints progresivos
- **Accessibility**: Cumplimiento de estándares WCAG 2.1 AA
- **Performance**: Lazy loading y optimización de bundle
- **Developer Experience**: Hot reload, TypeScript support, debugging tools

---

## 🔧 Tecnologías y Herramientas

### Stack Principal

#### Vue.js 3 (Composition API)
```javascript
// Características utilizadas
- Composition API
- <script setup> syntax
- Reactive refs y computed
- Lifecycle hooks
- Custom composables
- Teleport para modales
- Suspense para async components
```

#### Inertia.js
```javascript
// Beneficios implementados
- SPA sin API REST
- Server-side routing
- Automatic CSRF protection
- Form handling
- Progress indicators
- Asset versioning
```

#### Tailwind CSS
```css
/* Utilidades utilizadas */
- Responsive design utilities
- Custom component classes
- Dark mode support
- Custom color palette
- Animation utilities
- Grid y Flexbox layouts
```

### Herramientas de Desarrollo

#### Vite (Build Tool)
```javascript
// vite.config.js
import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import laravel from 'laravel-vite-plugin'

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            '@': '/resources/js',
            '~': '/resources',
        },
    },
    build: {
        rollupOptions: {
            output: {
                manualChunks: {
                    vendor: ['vue', '@inertiajs/vue3'],
                    utils: ['lodash', 'date-fns'],
                }
            }
        }
    }
})
```

#### PostCSS y Autoprefixer
```javascript
// postcss.config.js
module.exports = {
    plugins: {
        tailwindcss: {},
        autoprefixer: {},
        ...(process.env.NODE_ENV === 'production' ? { cssnano: {} } : {})
    },
}
```

---

## 📁 Estructura de Directorios

### Organización del Código Frontend

```
resources/
├── js/                          # JavaScript principal
│   ├── app.js                   # Punto de entrada
│   ├── bootstrap.js             # Configuración inicial
│   │
│   ├── Components/              # Componentes reutilizables
│   │   ├── UI/                  # Componentes de interfaz
│   │   │   ├── Button.vue
│   │   │   ├── Modal.vue
│   │   │   ├── Table.vue
│   │   │   ├── Form/
│   │   │   │   ├── Input.vue
│   │   │   │   ├── Select.vue
│   │   │   │   └── Textarea.vue
│   │   │   └── Navigation/
│   │   │       ├── Navbar.vue
│   │   │       ├── Sidebar.vue
│   │   │       └── Breadcrumb.vue
│   │   │
│   │   ├── Business/            # Componentes de negocio
│   │   │   ├── ProductCard.vue
│   │   │   ├── OrderSummary.vue
│   │   │   ├── CustomerInfo.vue
│   │   │   └── PdfViewer.vue
│   │   │
│   │   └── Charts/              # Componentes de gráficos
│   │       ├── LineChart.vue
│   │       ├── PieChart.vue
│   │       └── BarChart.vue
│   │
│   ├── Pages/                   # Páginas principales
│   │   ├── Dashboard/
│   │   │   └── Index.vue
│   │   │
│   │   ├── Productos/
│   │   │   ├── Index.vue
│   │   │   ├── Create.vue
│   │   │   ├── Edit.vue
│   │   │   └── Show.vue
│   │   │
│   │   ├── Pedidos/
│   │   │   ├── Index.vue
│   │   │   ├── Create.vue
│   │   │   ├── Edit.vue
│   │   │   └── Show.vue
│   │   │
│   │   ├── Clientes/
│   │   │   ├── Index.vue
│   │   │   ├── Create.vue
│   │   │   └── Edit.vue
│   │   │
│   │   ├── Proveedores/
│   │   │   ├── Index.vue
│   │   │   ├── Create.vue
│   │   │   └── Edit.vue
│   │   │
│   │   └── Reportes/
│   │       ├── Index.vue
│   │       ├── Ventas.vue
│   │       └── Productos.vue
│   │
│   ├── Layouts/                 # Layouts principales
│   │   ├── AppLayout.vue
│   │   ├── AuthLayout.vue
│   │   └── GuestLayout.vue
│   │
│   ├── Composables/            # Lógica reutilizable
│   │   ├── useAuth.js
│   │   ├── useProducts.js
│   │   ├── useOrders.js
│   │   ├── useSearch.js
│   │   ├── usePagination.js
│   │   ├── useModal.js
│   │   └── useNotifications.js
│   │
│   ├── Utils/                  # Utilidades
│   │   ├── constants.js
│   │   ├── formatters.js
│   │   ├── validators.js
│   │   └── helpers.js
│   │
│   └── Types/                  # Definiciones TypeScript
│       ├── index.d.ts
│       ├── models.d.ts
│       └── components.d.ts
│
├── css/                        # Estilos
│   ├── app.css                 # Estilos principales
│   └── components.css          # Estilos de componentes
│
└── views/                      # Templates Blade (mínimos)
    └── app.blade.php           # Template principal
```

### Configuración de Imports

#### Archivo app.js (Punto de entrada)
```javascript
import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m'

// Importar estilos globales
import '../css/app.css'

// Configuración global
const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Carrito Comida'

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .mount(el)
    },
    progress: {
        color: '#4F46E5',
        showSpinner: true,
    },
})
```

---

## 🧩 Componentes Principales

### Layout Principal

#### AppLayout.vue
```vue
<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Navigation -->
    <Navbar 
      :user="$page.props.auth.user"
      @toggle-sidebar="sidebarOpen = !sidebarOpen"
    />

    <!-- Sidebar -->
    <Sidebar 
      :open="sidebarOpen"
      :navigation="navigation"
      @close="sidebarOpen = false"
    />

    <!-- Main Content -->
    <div class="lg:pl-64">
      <main class="py-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <!-- Breadcrumb -->
          <Breadcrumb 
            v-if="breadcrumb"
            :items="breadcrumb"
            class="mb-6"
          />

          <!-- Page Content -->
          <slot />
        </div>
      </main>
    </div>

    <!-- Notifications -->
    <NotificationContainer />

    <!-- Modals -->
    <teleport to="body">
      <div id="modal-root"></div>
    </teleport>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import Navbar from '@/Components/UI/Navigation/Navbar.vue'
import Sidebar from '@/Components/UI/Navigation/Sidebar.vue'
import Breadcrumb from '@/Components/UI/Navigation/Breadcrumb.vue'
import NotificationContainer from '@/Components/UI/NotificationContainer.vue'

const sidebarOpen = ref(false)
const page = usePage()

const navigation = [
  {
    name: 'Dashboard',
    href: route('dashboard'),
    icon: 'ChartBarIcon',
    current: route().current('dashboard')
  },
  {
    name: 'Productos',
    href: route('productos.index'),
    icon: 'CubeIcon',
    current: route().current('productos.*')
  },
  {
    name: 'Pedidos',
    href: route('pedidos.index'),
    icon: 'ShoppingCartIcon',
    current: route().current('pedidos.*')
  },
  {
    name: 'Clientes',
    href: route('clientes.index'),
    icon: 'UsersIcon',
    current: route().current('clientes.*')
  },
  {
    name: 'Proveedores',
    href: route('proveedores.index'),
    icon: 'TruckIcon',
    current: route().current('proveedores.*')
  },
  {
    name: 'Reportes',
    href: route('reportes.index'),
    icon: 'DocumentChartBarIcon',
    current: route().current('reportes.*')
  }
]

const breadcrumb = computed(() => {
  // Lógica para generar breadcrumb basado en la ruta actual
  const routeName = route().current()
  // ... lógica de breadcrumb
})
</script>
```

### Componentes de UI Reutilizables

#### Button.vue
```vue
<template>
  <button
    :type="type"
    :disabled="disabled || loading"
    :class="buttonClasses"
    @click="handleClick"
  >
    <!-- Loading Spinner -->
    <svg 
      v-if="loading" 
      class="animate-spin -ml-1 mr-2 h-4 w-4" 
      fill="none" 
      viewBox="0 0 24 24"
    >
      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
    </svg>

    <!-- Icon -->
    <component 
      v-if="icon && !loading" 
      :is="icon" 
      :class="iconClasses"
    />

    <!-- Text -->
    <span v-if="$slots.default">
      <slot />
    </span>
  </button>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  type: {
    type: String,
    default: 'button',
    validator: (value) => ['button', 'submit', 'reset'].includes(value)
  },
  variant: {
    type: String,
    default: 'primary',
    validator: (value) => ['primary', 'secondary', 'danger', 'success', 'warning'].includes(value)
  },
  size: {
    type: String,
    default: 'md',
    validator: (value) => ['xs', 'sm', 'md', 'lg', 'xl'].includes(value)
  },
  disabled: {
    type: Boolean,
    default: false
  },
  loading: {
    type: Boolean,
    default: false
  },
  icon: {
    type: [String, Object],
    default: null
  },
  fullWidth: {
    type: Boolean,
    default: false
  }
})

const emit = defineEmits(['click'])

const baseClasses = 'inline-flex items-center justify-center font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors duration-200'

const variantClasses = {
  primary: 'bg-indigo-600 text-white hover:bg-indigo-700 focus:ring-indigo-500 disabled:bg-indigo-300',
  secondary: 'bg-gray-200 text-gray-900 hover:bg-gray-300 focus:ring-gray-500 disabled:bg-gray-100',
  danger: 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500 disabled:bg-red-300',
  success: 'bg-green-600 text-white hover:bg-green-700 focus:ring-green-500 disabled:bg-green-300',
  warning: 'bg-yellow-600 text-white hover:bg-yellow-700 focus:ring-yellow-500 disabled:bg-yellow-300'
}

const sizeClasses = {
  xs: 'px-2.5 py-1.5 text-xs',
  sm: 'px-3 py-2 text-sm',
  md: 'px-4 py-2 text-sm',
  lg: 'px-4 py-2 text-base',
  xl: 'px-6 py-3 text-base'
}

const buttonClasses = computed(() => [
  baseClasses,
  variantClasses[props.variant],
  sizeClasses[props.size],
  {
    'w-full': props.fullWidth,
    'opacity-50 cursor-not-allowed': props.disabled || props.loading
  }
])

const iconClasses = computed(() => {
  const size = {
    xs: 'h-3 w-3',
    sm: 'h-4 w-4',
    md: 'h-4 w-4',
    lg: 'h-5 w-5',
    xl: 'h-5 w-5'
  }[props.size]

  return [
    size,
    { 'mr-2': !!$slots.default }
  ]
})

const handleClick = (event) => {
  if (!props.disabled && !props.loading) {
    emit('click', event)
  }
}
</script>
```

#### Modal.vue
```vue
<template>
  <teleport to="#modal-root">
    <transition
      enter-active-class="transition duration-300 ease-out"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition duration-200 ease-in"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div 
        v-if="show"
        class="fixed inset-0 z-50 overflow-y-auto"
        @click="handleBackdropClick"
      >
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>

        <!-- Modal Container -->
        <div class="flex min-h-full items-center justify-center p-4">
          <transition
            enter-active-class="transition duration-300 ease-out"
            enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-100"
            leave-active-class="transition duration-200 ease-in"
            leave-from-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-95"
          >
            <div 
              v-if="show"
              :class="modalClasses"
              @click.stop
            >
              <!-- Header -->
              <div v-if="$slots.header || title" class="border-b border-gray-200 px-6 py-4">
                <div class="flex items-center justify-between">
                  <slot name="header">
                    <h3 class="text-lg font-medium text-gray-900">
                      {{ title }}
                    </h3>
                  </slot>
                  
                  <button
                    v-if="closable"
                    @click="close"
                    class="text-gray-400 hover:text-gray-500 focus:outline-none focus:text-gray-500 transition-colors duration-200"
                  >
                    <XMarkIcon class="h-6 w-6" />
                  </button>
                </div>
              </div>

              <!-- Body -->
              <div class="px-6 py-4">
                <slot />
              </div>

              <!-- Footer -->
              <div v-if="$slots.footer" class="border-t border-gray-200 px-6 py-4">
                <slot name="footer" />
              </div>
            </div>
          </transition>
        </div>
      </div>
    </transition>
  </teleport>
</template>

<script setup>
import { computed, watch } from 'vue'
import { XMarkIcon } from '@heroicons/vue/24/outline'

const props = defineProps({
  show: {
    type: Boolean,
    default: false
  },
  title: {
    type: String,
    default: null
  },
  size: {
    type: String,
    default: 'md',
    validator: (value) => ['sm', 'md', 'lg', 'xl', '2xl'].includes(value)
  },
  closable: {
    type: Boolean,
    default: true
  },
  closeOnBackdrop: {
    type: Boolean,
    default: true
  }
})

const emit = defineEmits(['close', 'closed'])

const sizeClasses = {
  sm: 'max-w-md',
  md: 'max-w-lg',
  lg: 'max-w-2xl',
  xl: 'max-w-4xl',
  '2xl': 'max-w-6xl'
}

const modalClasses = computed(() => [
  'relative w-full transform overflow-hidden rounded-lg bg-white shadow-xl transition-all',
  sizeClasses[props.size]
])

const handleBackdropClick = () => {
  if (props.closeOnBackdrop && props.closable) {
    close()
  }
}

const close = () => {
  emit('close')
}

// Prevent body scroll when modal is open
watch(() => props.show, (newValue) => {
  if (newValue) {
    document.body.style.overflow = 'hidden'
  } else {
    document.body.style.overflow = ''
    emit('closed')
  }
})
</script>
```

### Componentes de Negocio

#### ProductCard.vue
```vue
<template>
  <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-200">
    <!-- Product Image -->
    <div class="aspect-w-16 aspect-h-9 bg-gray-200">
      <img 
        v-if="product.imagen"
        :src="product.imagen"
        :alt="product.nombre"
        class="object-cover w-full h-full"
      >
      <div v-else class="flex items-center justify-center h-48">
        <PhotoIcon class="h-12 w-12 text-gray-400" />
      </div>
    </div>

    <!-- Product Info -->
    <div class="p-4">
      <div class="flex items-start justify-between">
        <div class="flex-1">
          <h3 class="text-lg font-medium text-gray-900 mb-1">
            {{ product.nombre }}
          </h3>
          
          <p v-if="product.descripcion" class="text-sm text-gray-600 mb-2 line-clamp-2">
            {{ product.descripcion }}
          </p>
        </div>

        <!-- Status Badge -->
        <StatusBadge 
          :status="product.activo ? 'active' : 'inactive'"
          :text="product.activo ? 'Activo' : 'Inactivo'"
        />
      </div>

      <!-- Price -->
      <div class="flex items-center justify-between mt-4">
        <span class="text-2xl font-bold text-indigo-600">
          {{ formatCurrency(product.precio) }}
        </span>

        <!-- Actions -->
        <div class="flex space-x-2">
          <Button
            size="sm"
            variant="secondary"
            @click="$emit('edit', product)"
          >
            <PencilIcon class="h-4 w-4" />
          </Button>
          
          <Button
            size="sm"
            :variant="product.activo ? 'warning' : 'success'"
            @click="$emit('toggle-status', product)"
          >
            <EyeIcon v-if="!product.activo" class="h-4 w-4" />
            <EyeSlashIcon v-else class="h-4 w-4" />
          </Button>
          
          <Button
            size="sm"
            variant="danger"
            @click="$emit('delete', product)"
          >
            <TrashIcon class="h-4 w-4" />
          </Button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { PhotoIcon, PencilIcon, EyeIcon, EyeSlashIcon, TrashIcon } from '@heroicons/vue/24/outline'
import Button from '@/Components/UI/Button.vue'
import StatusBadge from '@/Components/UI/StatusBadge.vue'
import { formatCurrency } from '@/Utils/formatters'

defineProps({
  product: {
    type: Object,
    required: true
  }
})

defineEmits(['edit', 'toggle-status', 'delete'])
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
```

---

## 🛣️ Sistema de Routing

### Configuración de Rutas con Inertia.js

#### Definición de Rutas (Laravel - routes/web.php)
```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DashboardController,
    ProductoController,
    PedidoController,
    ClienteController,
    ProveedorController,
    ReporteController
};

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Productos
Route::resource('productos', ProductoController::class);
Route::patch('productos/{producto}/toggle', [ProductoController::class, 'toggle'])->name('productos.toggle');

// Pedidos
Route::resource('pedidos', PedidoController::class);
Route::patch('pedidos/{pedido}/estado', [PedidoController::class, 'updateEstado'])->name('pedidos.estado');
Route::get('pedidos/{pedido}/pdf', [PedidoController::class, 'pdf'])->name('pedidos.pdf');

// Clientes
Route::resource('clientes', ClienteController::class)->except(['show']);

// Proveedores
Route::resource('proveedores', ProveedorController::class)->except(['show']);

// Reportes
Route::prefix('reportes')->name('reportes.')->group(function () {
    Route::get('/', [ReporteController::class, 'index'])->name('index');
    Route::get('/ventas', [ReporteController::class, 'ventas'])->name('ventas');
    Route::get('/productos', [ReporteController::class, 'productos'])->name('productos');
    Route::get('/ventas/pdf', [ReporteController::class, 'ventasPdf'])->name('ventas.pdf');
});
```

#### Navegación en Vue.js
```javascript
// Usando router helper (Ziggy)
import { router } from '@inertiajs/vue3'

// Navegación programática
const navegarAProductos = () => {
    router.get(route('productos.index'))
}

const crearProducto = (datos) => {
    router.post(route('productos.store'), datos, {
        onSuccess: () => {
            // Manejar éxito
        },
        onError: (errors) => {
            // Manejar errores
        }
    })
}

// Navegación con parámetros
const editarProducto = (id) => {
    router.get(route('productos.edit', id))
}
```

#### Link Components
```vue
<template>
  <div>
    <!-- Link básico -->
    <Link 
      :href="route('productos.index')"
      class="text-indigo-600 hover:text-indigo-500"
    >
      Ver Productos
    </Link>

    <!-- Link con preservación de estado -->
    <Link 
      :href="route('pedidos.index')"
      :preserve-state="true"
      :preserve-scroll="true"
    >
      Pedidos
    </Link>

    <!-- Link con datos adicionales -->
    <Link 
      :href="route('reportes.ventas')"
      :data="{ fecha: '2024-01' }"
      method="post"
    >
      Generar Reporte
    </Link>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
</script>
```

---

## 🗄️ Gestión de Estado

### Composables para Estado Global

#### useAuth.js
```javascript
import { ref, computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

export function useAuth() {
    const page = usePage()
    
    const user = computed(() => page.props.auth?.user || null)
    const isAuthenticated = computed(() => !!user.value)
    
    const hasRole = (role) => {
        return user.value?.roles?.includes(role) || false
    }
    
    const hasPermission = (permission) => {
        return user.value?.permissions?.includes(permission) || false
    }
    
    return {
        user,
        isAuthenticated,
        hasRole,
        hasPermission
    }
}
```

#### useProducts.js
```javascript
import { ref, reactive, computed } from 'vue'
import { router } from '@inertiajs/vue3'

export function useProducts() {
    const loading = ref(false)
    const products = ref([])
    const filters = reactive({
        search: '',
        activo: null,
        categoria: null
    })
    
    const filteredProducts = computed(() => {
        let filtered = products.value
        
        if (filters.search) {
            filtered = filtered.filter(product => 
                product.nombre.toLowerCase().includes(filters.search.toLowerCase())
            )
        }
        
        if (filters.activo !== null) {
            filtered = filtered.filter(product => product.activo === filters.activo)
        }
        
        return filtered
    })
    
    const activeProducts = computed(() => 
        products.value.filter(product => product.activo)
    )
    
    const createProduct = async (data) => {
        loading.value = true
        
        return new Promise((resolve, reject) => {
            router.post(route('productos.store'), data, {
                onSuccess: (page) => {
                    resolve(page.props.product)
                },
                onError: (errors) => {
                    reject(errors)
                },
                onFinish: () => {
                    loading.value = false
                }
            })
        })
    }
    
    const updateProduct = async (id, data) => {
        loading.value = true
        
        return new Promise((resolve, reject) => {
            router.put(route('productos.update', id), data, {
                onSuccess: (page) => {
                    resolve(page.props.product)
                },
                onError: (errors) => {
                    reject(errors)
                },
                onFinish: () => {
                    loading.value = false
                }
            })
        })
    }
    
    const toggleProductStatus = async (product) => {
        return new Promise((resolve, reject) => {
            router.patch(route('productos.toggle', product.id), {}, {
                onSuccess: () => {
                    // Actualizar estado local
                    const index = products.value.findIndex(p => p.id === product.id)
                    if (index !== -1) {
                        products.value[index].activo = !products.value[index].activo
                    }
                    resolve()
                },
                onError: (errors) => {
                    reject(errors)
                }
            })
        })
    }
    
    const deleteProduct = async (id) => {
        return new Promise((resolve, reject) => {
            router.delete(route('productos.destroy', id), {
                onSuccess: () => {
                    // Remover del estado local
                    products.value = products.value.filter(p => p.id !== id)
                    resolve()
                },
                onError: (errors) => {
                    reject(errors)
                }
            })
        })
    }
    
    return {
        loading,
        products,
        filters,
        filteredProducts,
        activeProducts,
        createProduct,
        updateProduct,
        toggleProductStatus,
        deleteProduct
    }
}
```

#### useModal.js
```javascript
import { ref, reactive } from 'vue'

export function useModal() {
    const modals = reactive(new Map())
    
    const show = (id, props = {}) => {
        modals.set(id, {
            visible: true,
            props
        })
    }
    
    const hide = (id) => {
        if (modals.has(id)) {
            modals.set(id, {
                ...modals.get(id),
                visible: false
            })
        }
    }
    
    const isVisible = (id) => {
        return modals.get(id)?.visible || false
    }
    
    const getProps = (id) => {
        return modals.get(id)?.props || {}
    }
    
    const toggle = (id, props = {}) => {
        if (isVisible(id)) {
            hide(id)
        } else {
            show(id, props)
        }
    }
    
    return {
        show,
        hide,
        isVisible,
        getProps,
        toggle
    }
}
```

---

## 🎨 Interfaz de Usuario

### Sistema de Diseño

#### Paleta de Colores
```css
/* tailwind.config.js */
module.exports = {
    theme: {
        extend: {
            colors: {
                primary: {
                    50: '#eef2ff',
                    100: '#e0e7ff',
                    500: '#6366f1',
                    600: '#4f46e5',
                    700: '#4338ca',
                    900: '#312e81',
                },
                success: {
                    50: '#f0fdf4',
                    500: '#22c55e',
                    600: '#16a34a',
                },
                warning: {
                    50: '#fffbeb',
                    500: '#f59e0b',
                    600: '#d97706',
                },
                error: {
                    50: '#fef2f2',
                    500: '#ef4444',
                    600: '#dc2626',
                }
            }
        }
    }
}
```

#### Tipografía
```css
/* app.css */
@import 'tailwindcss/base';
@import 'tailwindcss/components';
@import 'tailwindcss/utilities';

@layer base {
    html {
        font-family: 'Inter', system-ui, sans-serif;
    }
    
    h1 { @apply text-3xl font-bold text-gray-900; }
    h2 { @apply text-2xl font-semibold text-gray-900; }
    h3 { @apply text-xl font-medium text-gray-900; }
    h4 { @apply text-lg font-medium text-gray-900; }
}

@layer components {
    .btn {
        @apply inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors duration-200;
    }
    
    .btn-primary {
        @apply btn bg-primary-600 text-white hover:bg-primary-700 focus:ring-primary-500;
    }
    
    .card {
        @apply bg-white overflow-hidden shadow-sm rounded-lg;
    }
    
    .form-input {
        @apply block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500;
    }
}
```

### Responsive Design

#### Breakpoints Utilizados
```css
/* Breakpoints Tailwind CSS */
sm: 640px    /* Tablets pequeñas */
md: 768px    /* Tablets */
lg: 1024px   /* Desktop pequeño */
xl: 1280px   /* Desktop */
2xl: 1536px  /* Desktop grande */
```

#### Implementación Responsive
```vue
<template>
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
    <!-- Cards responsivas -->
    <ProductCard 
      v-for="product in products" 
      :key="product.id"
      :product="product"
      class="col-span-1"
    />
  </div>
  
  <!-- Navigation responsive -->
  <nav class="hidden lg:flex lg:space-x-8">
    <!-- Desktop navigation -->
  </nav>
  
  <nav class="lg:hidden">
    <!-- Mobile navigation -->
  </nav>
</template>
```

### Accesibilidad (A11y)

#### Implementación de ARIA
```vue
<template>
  <!-- Skip Navigation -->
  <a 
    href="#main-content" 
    class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 bg-primary-600 text-white px-4 py-2 rounded"
  >
    Saltar al contenido principal
  </a>

  <!-- Formulario accesible -->
  <form @submit.prevent="submit">
    <div class="space-y-4">
      <div>
        <label 
          for="product-name" 
          class="block text-sm font-medium text-gray-700"
        >
          Nombre del Producto
          <span class="text-red-500" aria-label="Campo obligatorio">*</span>
        </label>
        
        <input
          id="product-name"
          v-model="form.nombre"
          type="text"
          required
          :aria-invalid="errors.nombre ? 'true' : 'false'"
          :aria-describedby="errors.nombre ? 'product-name-error' : null"
          class="form-input"
        >
        
        <div 
          v-if="errors.nombre"
          id="product-name-error"
          role="alert"
          class="mt-1 text-sm text-red-600"
        >
          {{ errors.nombre[0] }}
        </div>
      </div>
    </div>
  </form>

  <!-- Modal accesible -->
  <Modal
    :show="showModal"
    role="dialog"
    aria-labelledby="modal-title"
    aria-describedby="modal-description"
    @close="showModal = false"
  >
    <template #header>
      <h3 id="modal-title">Confirmar Eliminación</h3>
    </template>
    
    <p id="modal-description">
      ¿Está seguro de que desea eliminar este producto?
    </p>
  </Modal>
</template>
```

---

## ⚡ Optimizaciones y Performance

### Lazy Loading de Componentes

#### Definir Componentes Async
```javascript
// En router o components
const LazyProductModal = defineAsyncComponent(() => 
    import('@/Components/Modals/ProductModal.vue')
)

// Con loading component
const LazyChart = defineAsyncComponent({
    loader: () => import('@/Components/Charts/SalesChart.vue'),
    loadingComponent: LoadingSpinner,
    errorComponent: ErrorComponent,
    delay: 200,
    timeout: 3000
})
```

#### Code Splitting por Rutas
```javascript
// vite.config.js
export default defineConfig({
    build: {
        rollupOptions: {
            output: {
                manualChunks: {
                    // Vendor chunks
                    vue: ['vue'],
                    inertia: ['@inertiajs/vue3'],
                    
                    // Feature chunks
                    dashboard: ['./resources/js/Pages/Dashboard/Index.vue'],
                    products: [
                        './resources/js/Pages/Productos/Index.vue',
                        './resources/js/Pages/Productos/Create.vue',
                        './resources/js/Pages/Productos/Edit.vue'
                    ],
                    orders: [
                        './resources/js/Pages/Pedidos/Index.vue',
                        './resources/js/Pages/Pedidos/Create.vue'
                    ]
                }
            }
        }
    }
})
```

### Optimización de Imágenes

#### Lazy Loading de Imágenes
```vue
<template>
  <div class="image-container">
    <img
      v-if="imageLoaded"
      :src="imageSrc"
      :alt="imageAlt"
      @load="imageLoaded = true"
      class="transition-opacity duration-300"
      :class="{ 'opacity-100': imageLoaded, 'opacity-0': !imageLoaded }"
    >
    
    <div 
      v-else
      class="w-full h-48 bg-gray-200 animate-pulse flex items-center justify-center"
    >
      <PhotoIcon class="h-12 w-12 text-gray-400" />
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { PhotoIcon } from '@heroicons/vue/24/outline'

const props = defineProps({
  imageSrc: String,
  imageAlt: String
})

const imageLoaded = ref(false)

onMounted(() => {
  // Precargar imagen
  const img = new Image()
  img.onload = () => {
    imageLoaded.value = true
  }
  img.src = props.imageSrc
})
</script>
```

### Caching y Memoización

#### Computed con Cache
```javascript
import { computed, ref } from 'vue'

export function useExpensiveCalculation(data) {
    const cache = new Map()
    const cacheKey = ref('')
    
    const expensiveResult = computed(() => {
        const key = JSON.stringify(data.value)
        
        if (cache.has(key)) {
            return cache.get(key)
        }
        
        // Cálculo costoso
        const result = performExpensiveCalculation(data.value)
        cache.set(key, result)
        
        // Limpiar cache si es muy grande
        if (cache.size > 100) {
            const firstKey = cache.keys().next().value
            cache.delete(firstKey)
        }
        
        return result
    })
    
    return { expensiveResult }
}
```

### Bundle Analysis

#### Scripts de Análisis
```json
{
  "scripts": {
    "build": "vite build",
    "build:analyze": "vite build && npx vite-bundle-analyzer dist",
    "build:report": "vite build --mode=analyze",
    "dev": "vite",
    "dev:network": "vite --host"
  }
}
```

#### Configuración de Análisis
```javascript
// vite.config.js
import { defineConfig } from 'vite'
import { visualizer } from 'rollup-plugin-visualizer'

export default defineConfig({
    plugins: [
        // ... otros plugins
        
        process.env.ANALYZE && visualizer({
            filename: 'dist/stats.html',
            open: true,
            gzipSize: true,
            brotliSize: true,
        })
    ]
})
```

---

## 🔧 Herramientas de Desarrollo

### Hot Module Replacement (HMR)

#### Configuración Vite HMR
```javascript
// vite.config.js
export default defineConfig({
    server: {
        hmr: {
            host: 'localhost',
            protocol: 'ws'
        },
        watch: {
            usePolling: true,
            interval: 1000
        }
    }
})
```

### DevTools

#### Vue DevTools
```javascript
// Configuración para desarrollo
if (import.meta.env.DEV) {
    // Habilitar Vue DevTools
    window.__VUE_DEVTOOLS_GLOBAL_HOOK__ = window.__VUE_DEVTOOLS_GLOBAL_HOOK__ || {}
}
```

#### Debug Helpers
```javascript
// utils/debug.js
export const debug = {
    log: (...args) => {
        if (import.meta.env.DEV) {
            console.log('[DEBUG]', ...args)
        }
    },
    
    performance: (name, fn) => {
        if (import.meta.env.DEV) {
            console.time(name)
            const result = fn()
            console.timeEnd(name)
            return result
        }
        return fn()
    },
    
    component: (name, props) => {
        if (import.meta.env.DEV) {
            console.log(`[COMPONENT] ${name}`, props)
        }
    }
}
```

---

*Documentación Frontend actualizada: 24 de Septiembre, 2025*