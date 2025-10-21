# 🔗 Documentación API - Sistema Carrito Comida Rápida

## 📋 Índice
1. [Introducción](#-introducción)
2. [Autenticación](#-autenticación)
3. [Estructura de Respuestas](#-estructura-de-respuestas)
4. [Endpoints Principales](#-endpoints-principales)
5. [Manejo de Errores](#-manejo-de-errores)
6. [Ejemplos de Implementación](#-ejemplos-de-implementación)

---

## 🌐 Introducción

### Información General
El sistema utiliza **Inertia.js** como puente entre Laravel (backend) y Vue.js (frontend), proporcionando una arquitectura SPA moderna sin necesidad de APIs REST tradicionales. Sin embargo, también se exponen endpoints específicos para funcionalidades como generación de PDFs y consultas AJAX.

### Base URL
```
Desarrollo: http://localhost:8000
Producción: https://tu-dominio.com
```

### Tecnologías Utilizadas
- **Laravel 12** - Framework PHP para el backend
- **Inertia.js** - Adaptador para SPA sin API
- **Vue.js 3** - Framework JavaScript frontend
- **Sanctum** - Autenticación de APIs (si se requiere)

---

## 🔐 Autenticación

### Sistema de Autenticación Web
El sistema utiliza autenticación basada en sesiones de Laravel para la interfaz web principal.

#### Login
```http
POST /login
Content-Type: application/x-www-form-urlencoded
```

**Parámetros:**
```json
{
    "email": "admin@carrito.com",
    "password": "password123",
    "remember": true
}
```

#### Logout
```http
POST /logout
```

#### Verificar Estado de Autenticación
```http
GET /dashboard
```

### Protección CSRF
Todas las rutas POST/PUT/DELETE requieren token CSRF:

```html
<!-- En Blade templates -->
<meta name="csrf-token" content="{{ csrf_token() }}">
```

```javascript
// En Vue.js con Inertia
import { router } from '@inertiajs/vue3'

router.post('/productos', {
    nombre: 'Producto Nuevo',
    precio: 15.50
}, {
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
})
```

---

## 📊 Estructura de Respuestas

### Respuestas Inertia.js
Las respuestas principales del sistema siguen el patrón de Inertia.js:

```json
{
    "component": "Dashboard/Index",
    "props": {
        "totalProductos": 45,
        "totalPedidos": 123,
        "ventasHoy": 1250.75,
        "productos": [
            {
                "id": 1,
                "nombre": "Hamburguesa Clásica",
                "precio": 15.50,
                "activo": true,
                "created_at": "2024-01-15T10:30:00.000000Z"
            }
        ]
    },
    "url": "/dashboard",
    "version": "1.0"
}
```

### Respuestas AJAX (JSON)
Para endpoints específicos como búsquedas y PDFs:

#### Respuesta Exitosa
```json
{
    "success": true,
    "message": "Operación completada exitosamente",
    "data": {
        "id": 1,
        "nombre": "Producto creado",
        "precio": 25.00
    },
    "meta": {
        "timestamp": "2024-01-15T10:30:00Z",
        "request_id": "req_123456"
    }
}
```

#### Respuesta de Error
```json
{
    "success": false,
    "message": "Error en la validación",
    "errors": {
        "nombre": ["El nombre es obligatorio"],
        "precio": ["El precio debe ser mayor a 0"]
    },
    "error_code": "VALIDATION_ERROR",
    "meta": {
        "timestamp": "2024-01-15T10:30:00Z",
        "request_id": "req_123456"
    }
}
```

---

## 🛠️ Endpoints Principales

### Dashboard y Métricas

#### Obtener Dashboard Principal
```http
GET /dashboard
Accept: text/html, application/xhtml+xml
```

**Respuesta:**
Página Inertia.js con componente `Dashboard/Index` que incluye:
- Total de productos activos
- Total de pedidos del día
- Ventas del día actual
- Gráficos de tendencias
- Productos más vendidos

#### Métricas AJAX
```http
GET /api/dashboard/metricas
Accept: application/json
```

**Respuesta:**
```json
{
    "success": true,
    "data": {
        "totalProductos": 45,
        "productosActivos": 42,
        "totalPedidos": 123,
        "pedidosHoy": 15,
        "ventasHoy": 1250.75,
        "ventasSemana": 8750.25,
        "promedioVentaDiaria": 1250.04
    }
}
```

### Gestión de Productos

#### Listar Productos
```http
GET /productos
Accept: text/html, application/xhtml+xml
```

**Parámetros de Query:**
```
?search=hamburguesa&activo=1&page=2&per_page=10
```

#### Crear Producto
```http
POST /productos
Content-Type: application/x-www-form-urlencoded
```

**Parámetros:**
```json
{
    "nombre": "Hamburguesa Especial",
    "descripcion": "Hamburguesa con queso y tocino",
    "precio": 18.50,
    "activo": true
}
```

#### Obtener Producto Específico
```http
GET /productos/{id}
Accept: text/html, application/xhtml+xml
```

#### Actualizar Producto
```http
PUT /productos/{id}
Content-Type: application/x-www-form-urlencoded
```

```json
{
    "nombre": "Hamburguesa Premium",
    "descripcion": "Nueva descripción",
    "precio": 20.00,
    "activo": true
}
```

#### Eliminar/Desactivar Producto
```http
DELETE /productos/{id}
```

#### Búsqueda AJAX de Productos
```http
GET /api/productos/buscar
Accept: application/json
```

**Parámetros:**
```
?q=hambur&limit=5&activos_solo=true
```

**Respuesta:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "nombre": "Hamburguesa Clásica",
            "precio": 15.50,
            "activo": true
        },
        {
            "id": 2,
            "nombre": "Hamburguesa Premium",
            "precio": 20.00,
            "activo": true
        }
    ]
}
```

### Gestión de Pedidos

#### Listar Pedidos
```http
GET /pedidos
Accept: text/html, application/xhtml+xml
```

**Parámetros de Query:**
```
?estado=pendiente&fecha_desde=2024-01-01&fecha_hasta=2024-01-31&cliente_id=5
```

#### Crear Pedido
```http
POST /pedidos
Content-Type: application/x-www-form-urlencoded
```

**Parámetros:**
```json
{
    "cliente_id": 5,
    "productos": [
        {
            "producto_id": 1,
            "cantidad": 2,
            "precio_unitario": 15.50
        },
        {
            "producto_id": 3,
            "cantidad": 1,
            "precio_unitario": 12.00
        }
    ],
    "descuento": 5.00,
    "observaciones": "Sin cebolla en la hamburguesa"
}
```

#### Obtener Pedido Específico
```http
GET /pedidos/{id}
Accept: text/html, application/xhtml+xml
```

#### Actualizar Estado de Pedido
```http
PATCH /pedidos/{id}/estado
Content-Type: application/x-www-form-urlencoded
```

```json
{
    "estado": "preparando"
}
```

**Estados válidos:** `pendiente`, `preparando`, `listo`, `entregado`, `cancelado`

#### Generar PDF de Pedido
```http
GET /pedidos/{id}/pdf
Accept: application/pdf
```

**Headers de Respuesta:**
```
Content-Type: application/pdf
Content-Disposition: attachment; filename="pedido_123.pdf"
```

### Gestión de Clientes

#### Listar Clientes
```http
GET /clientes
Accept: text/html, application/xhtml+xml
```

#### Crear Cliente
```http
POST /clientes
Content-Type: application/x-www-form-urlencoded
```

```json
{
    "nombre": "Juan Pérez",
    "email": "juan@email.com",
    "telefono": "+1234567890",
    "direccion": "Calle Principal 123"
}
```

#### Búsqueda AJAX de Clientes
```http
GET /api/clientes/buscar
Accept: application/json
```

**Parámetros:**
```
?q=juan&limit=10
```

### Gestión de Proveedores

#### Listar Proveedores
```http
GET /proveedores
Accept: text/html, application/xhtml+xml
```

#### Crear Proveedor
```http
POST /proveedores
Content-Type: application/x-www-form-urlencoded
```

```json
{
    "nombre": "Distribuidora Food Corp",
    "contacto": "María González",
    "email": "contacto@foodcorp.com",
    "telefono": "+1987654321",
    "direccion": "Av. Industrial 456"
}
```

### Reportes y Estadísticas

#### Reporte de Ventas
```http
GET /reportes/ventas
Accept: text/html, application/xhtml+xml
```

**Parámetros de Query:**
```
?fecha_inicio=2024-01-01&fecha_fin=2024-01-31&formato=pdf
```

#### Reporte de Productos Más Vendidos
```http
GET /api/reportes/productos-mas-vendidos
Accept: application/json
```

**Parámetros:**
```
?periodo=mes&limit=10
```

**Respuesta:**
```json
{
    "success": true,
    "data": [
        {
            "producto_id": 1,
            "nombre": "Hamburguesa Clásica",
            "total_vendido": 145,
            "total_ingresos": 2175.00
        },
        {
            "producto_id": 3,
            "nombre": "Papas Fritas",
            "total_vendido": 120,
            "total_ingresos": 1440.00
        }
    ],
    "meta": {
        "periodo": "mes",
        "fecha_inicio": "2024-01-01",
        "fecha_fin": "2024-01-31"
    }
}
```

#### Generar PDF de Reporte
```http
GET /reportes/ventas/pdf
Accept: application/pdf
```

**Parámetros de Query:**
```
?fecha_inicio=2024-01-01&fecha_fin=2024-01-31&incluir_graficos=true
```

---

## ❌ Manejo de Errores

### Códigos de Estado HTTP

```
┌─────────────┬─────────────────────────────────────────────┐
│   Código    │                Significado                  │
├─────────────┼─────────────────────────────────────────────┤
│ 200         │ OK - Operación exitosa                      │
│ 201         │ Created - Recurso creado exitosamente       │
│ 204         │ No Content - Operación exitosa sin datos    │
│ 400         │ Bad Request - Datos de entrada inválidos    │
│ 401         │ Unauthorized - No autenticado               │
│ 403         │ Forbidden - Sin permisos                    │
│ 404         │ Not Found - Recurso no encontrado           │
│ 422         │ Unprocessable Entity - Error de validación  │
│ 500         │ Internal Server Error - Error del servidor  │
└─────────────┴─────────────────────────────────────────────┘
```

### Tipos de Errores

#### Error de Validación (422)
```json
{
    "success": false,
    "message": "Los datos proporcionados no son válidos.",
    "errors": {
        "nombre": [
            "El campo nombre es obligatorio."
        ],
        "precio": [
            "El precio debe ser mayor a 0.",
            "El precio no puede superar 999.99."
        ],
        "email": [
            "El formato del email no es válido."
        ]
    },
    "error_code": "VALIDATION_ERROR"
}
```

#### Error de Autenticación (401)
```json
{
    "success": false,
    "message": "No está autenticado. Debe iniciar sesión.",
    "error_code": "UNAUTHENTICATED",
    "redirect": "/login"
}
```

#### Error de Autorización (403)
```json
{
    "success": false,
    "message": "No tiene permisos para realizar esta acción.",
    "error_code": "FORBIDDEN",
    "required_permission": "crear_productos"
}
```

#### Error de Recurso No Encontrado (404)
```json
{
    "success": false,
    "message": "El producto solicitado no fue encontrado.",
    "error_code": "RESOURCE_NOT_FOUND",
    "resource": "producto",
    "resource_id": 999
}
```

#### Error del Servidor (500)
```json
{
    "success": false,
    "message": "Ocurrió un error interno. Intente nuevamente más tarde.",
    "error_code": "INTERNAL_SERVER_ERROR",
    "reference_id": "err_20240115_103045_abc123"
}
```

### Manejo de Errores en Frontend

#### Con Inertia.js (Vue.js)
```javascript
import { router } from '@inertiajs/vue3'

// Crear producto con manejo de errores
const crearProducto = () => {
    router.post('/productos', form.value, {
        onError: (errors) => {
            // Manejar errores de validación
            console.error('Errores de validación:', errors)
            // Los errores se muestran automáticamente en el formulario
        },
        onSuccess: () => {
            alert('Producto creado exitosamente')
            form.value = {} // Limpiar formulario
        },
        onFinish: () => {
            loading.value = false
        }
    })
}
```

#### Con Fetch API (JavaScript puro)
```javascript
async function crearProducto(datos) {
    try {
        const response = await fetch('/productos', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(datos)
        })

        const result = await response.json()

        if (!response.ok) {
            if (response.status === 422) {
                // Manejar errores de validación
                handleValidationErrors(result.errors)
            } else if (response.status === 401) {
                // Redirigir al login
                window.location.href = '/login'
            } else {
                throw new Error(result.message || 'Error desconocido')
            }
            return
        }

        // Éxito
        console.log('Producto creado:', result.data)
        
    } catch (error) {
        console.error('Error al crear producto:', error.message)
        alert('Error al crear el producto: ' + error.message)
    }
}
```

---

## 💡 Ejemplos de Implementación

### Ejemplo 1: Crear Pedido Completo

#### Frontend (Vue.js con Inertia)
```vue
<template>
  <div class="crear-pedido">
    <h2>Crear Nuevo Pedido</h2>
    
    <form @submit.prevent="crearPedido">
      <!-- Selección de Cliente -->
      <div class="campo">
        <label>Cliente:</label>
        <select v-model="form.cliente_id" required>
          <option value="">Seleccionar cliente...</option>
          <option v-for="cliente in clientes" 
                  :key="cliente.id" 
                  :value="cliente.id">
            {{ cliente.nombre }}
          </option>
        </select>
        <div v-if="$page.props.errors.cliente_id" class="error">
          {{ $page.props.errors.cliente_id[0] }}
        </div>
      </div>

      <!-- Productos -->
      <div class="productos">
        <h3>Productos</h3>
        <div v-for="(item, index) in form.productos" :key="index" class="producto-item">
          <select v-model="item.producto_id" @change="actualizarPrecio(index)">
            <option value="">Seleccionar producto...</option>
            <option v-for="producto in productos" 
                    :key="producto.id" 
                    :value="producto.id">
              {{ producto.nombre }} - ${{ producto.precio }}
            </option>
          </select>
          
          <input v-model.number="item.cantidad" 
                 type="number" 
                 min="1" 
                 placeholder="Cantidad">
          
          <span class="subtotal">
            ${{ (item.cantidad * item.precio_unitario).toFixed(2) }}
          </span>
          
          <button type="button" @click="eliminarProducto(index)">
            Eliminar
          </button>
        </div>
        
        <button type="button" @click="agregarProducto">
          Agregar Producto
        </button>
      </div>

      <!-- Descuento y Observaciones -->
      <div class="campo">
        <label>Descuento:</label>
        <input v-model.number="form.descuento" 
               type="number" 
               step="0.01" 
               min="0">
      </div>

      <div class="campo">
        <label>Observaciones:</label>
        <textarea v-model="form.observaciones" 
                  rows="3" 
                  placeholder="Instrucciones especiales..."></textarea>
      </div>

      <!-- Total -->
      <div class="total">
        <strong>Total: ${{ calcularTotal() }}</strong>
      </div>

      <button type="submit" :disabled="loading">
        {{ loading ? 'Creando...' : 'Crear Pedido' }}
      </button>
    </form>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
  clientes: Array,
  productos: Array
})

const loading = ref(false)

const form = reactive({
  cliente_id: '',
  productos: [
    { producto_id: '', cantidad: 1, precio_unitario: 0 }
  ],
  descuento: 0,
  observaciones: ''
})

const agregarProducto = () => {
  form.productos.push({ 
    producto_id: '', 
    cantidad: 1, 
    precio_unitario: 0 
  })
}

const eliminarProducto = (index) => {
  if (form.productos.length > 1) {
    form.productos.splice(index, 1)
  }
}

const actualizarPrecio = (index) => {
  const producto = props.productos.find(p => p.id == form.productos[index].producto_id)
  if (producto) {
    form.productos[index].precio_unitario = producto.precio
  }
}

const calcularTotal = () => {
  const subtotal = form.productos.reduce((total, item) => {
    return total + (item.cantidad * item.precio_unitario)
  }, 0)
  return (subtotal - form.descuento).toFixed(2)
}

const crearPedido = () => {
  loading.value = true
  
  router.post('/pedidos', form, {
    onSuccess: () => {
      alert('Pedido creado exitosamente')
      // Resetear formulario o redirigir
    },
    onError: (errors) => {
      console.error('Errores:', errors)
    },
    onFinish: () => {
      loading.value = false
    }
  })
}
</script>
```

#### Backend (Laravel Controller)
```php
<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\DetallePedido;
use App\Models\Cliente;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PedidoController extends Controller
{
    public function create()
    {
        return Inertia::render('Pedidos/Create', [
            'clientes' => Cliente::select('id', 'nombre')->get(),
            'productos' => Producto::where('activo', true)
                ->select('id', 'nombre', 'precio')
                ->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'productos' => 'required|array|min:1',
            'productos.*.producto_id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
            'productos.*.precio_unitario' => 'required|numeric|min:0',
            'descuento' => 'nullable|numeric|min:0',
            'observaciones' => 'nullable|string|max:500'
        ]);

        DB::beginTransaction();
        
        try {
            // Calcular total
            $subtotal = collect($request->productos)->sum(function ($item) {
                return $item['cantidad'] * $item['precio_unitario'];
            });
            
            $total = $subtotal - ($request->descuento ?? 0);

            // Crear pedido
            $pedido = Pedido::create([
                'cliente_id' => $request->cliente_id,
                'total' => $total,
                'descuento' => $request->descuento ?? 0,
                'estado' => 'pendiente',
                'observaciones' => $request->observaciones
            ]);

            // Crear detalles del pedido
            foreach ($request->productos as $productoData) {
                DetallePedido::create([
                    'pedido_id' => $pedido->id,
                    'producto_id' => $productoData['producto_id'],
                    'cantidad' => $productoData['cantidad'],
                    'precio_unitario' => $productoData['precio_unitario']
                ]);
            }

            DB::commit();

            return redirect()->route('pedidos.show', $pedido)
                ->with('success', 'Pedido creado exitosamente');

        } catch (\Exception $e) {
            DB::rollback();
            
            return back()
                ->withInput()
                ->withErrors(['error' => 'Error al crear el pedido: ' . $e->getMessage()]);
        }
    }
}
```

### Ejemplo 2: Búsqueda en Tiempo Real

#### Frontend (Vue.js)
```vue
<template>
  <div class="busqueda-productos">
    <input 
      v-model="busqueda"
      @input="buscarProductos"
      type="text"
      placeholder="Buscar productos..."
      class="input-busqueda"
    >
    
    <div v-if="cargando" class="cargando">
      Buscando...
    </div>
    
    <div v-if="resultados.length > 0" class="resultados">
      <div 
        v-for="producto in resultados" 
        :key="producto.id"
        @click="seleccionarProducto(producto)"
        class="resultado-item"
      >
        <span class="nombre">{{ producto.nombre }}</span>
        <span class="precio">${{ producto.precio }}</span>
      </div>
    </div>
    
    <div v-else-if="busqueda && !cargando" class="sin-resultados">
      No se encontraron productos
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import { debounce } from 'lodash'

const emit = defineEmits(['producto-seleccionado'])

const busqueda = ref('')
const resultados = ref([])
const cargando = ref(false)

const buscarProductos = debounce(async () => {
  if (busqueda.value.length < 2) {
    resultados.value = []
    return
  }

  cargando.value = true
  
  try {
    const response = await fetch(`/api/productos/buscar?q=${encodeURIComponent(busqueda.value)}&limit=5`)
    const data = await response.json()
    
    if (data.success) {
      resultados.value = data.data
    }
  } catch (error) {
    console.error('Error en búsqueda:', error)
  } finally {
    cargando.value = false
  }
}, 300)

const seleccionarProducto = (producto) => {
  emit('producto-seleccionado', producto)
  busqueda.value = ''
  resultados.value = []
}
</script>
```

#### Backend (API Endpoint)
```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoBusquedaController extends Controller
{
    public function buscar(Request $request)
    {
        $request->validate([
            'q' => 'required|string|min:2|max:50',
            'limit' => 'integer|min:1|max:20',
            'activos_solo' => 'boolean'
        ]);

        $query = Producto::where('nombre', 'LIKE', '%' . $request->q . '%');

        if ($request->boolean('activos_solo', true)) {
            $query->where('activo', true);
        }

        $productos = $query
            ->select('id', 'nombre', 'precio', 'activo')
            ->limit($request->integer('limit', 10))
            ->get();

        return response()->json([
            'success' => true,
            'data' => $productos,
            'meta' => [
                'query' => $request->q,
                'total' => $productos->count(),
                'timestamp' => now()->toISOString()
            ]
        ]);
    }
}
```

---

## 🔧 Configuración Avanzada

### Middleware Personalizado

#### CORS para APIs
```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cors
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');

        return $response;
    }
}
```

### Rate Limiting
```php
// En RouteServiceProvider.php
protected function configureRateLimiting()
{
    RateLimiter::for('api', function (Request $request) {
        return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
    });
    
    RateLimiter::for('busqueda', function (Request $request) {
        return Limit::perMinute(30)->by($request->ip());
    });
}
```

### Logging Personalizado
```php
// En config/logging.php
'channels' => [
    'api' => [
        'driver' => 'daily',
        'path' => storage_path('logs/api.log'),
        'level' => 'info',
        'days' => 14,
    ],
],
```

---

*Documentación API actualizada: 24 de Septiembre, 2025*