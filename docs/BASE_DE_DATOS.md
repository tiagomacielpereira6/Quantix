# 🗄️ Base de Datos - Sistema Carrito Comida Rápida

## 📋 Índice
1. [Diseño General](#-diseño-general)
2. [Estructura de Tablas](#-estructura-de-tablas)
3. [Relaciones](#-relaciones)
4. [Migraciones](#-migraciones)
5. [Seeders](#-seeders)
6. [Consultas Importantes](#-consultas-importantes)

---

## 🎯 Diseño General

La base de datos está diseñada siguiendo los principios de normalización y optimizada para un sistema de gestión de comida rápida. Utiliza **MariaDB/MySQL** como motor de base de datos.

### Características Principales
- ✅ **Integridad Referencial** - Todas las relaciones con foreign keys
- ✅ **Soft Deletes** - Los productos se inactivan, no se eliminan
- ✅ **Timestamps** - Auditoría automática de creación/actualización
- ✅ **Índices Optimizados** - Para consultas frecuentes
- ✅ **Campos Calculados** - Para reportes y estadísticas

---

## 📊 Estructura de Tablas

### 1. 🍔 **productos**
Catálogo de productos disponibles para la venta.

```sql
CREATE TABLE productos (
    id_producto INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    precio DECIMAL(8,2) NOT NULL,
    categoria VARCHAR(50),
    stock INT DEFAULT 0,
    activo BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

**Campos:**
- `id_producto` - Identificador único
- `nombre` - Nombre del producto (ej: "Hamburguesa Clásica")
- `precio` - Precio unitario de venta
- `categoria` - Categoría (Comidas, Bebidas, Postres, Snacks)
- `stock` - Cantidad disponible en inventario
- `activo` - Estado del producto (activo/inactivo)

**Índices:**
- PRIMARY KEY: `id_producto`
- INDEX: `categoria` (para filtros)
- INDEX: `activo` (para productos disponibles)

---

### 2. 👥 **clientes**
Base de datos de clientes del negocio.

```sql
CREATE TABLE clientes (
    id_cliente INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    telefono VARCHAR(20),
    correo VARCHAR(100),
    direccion TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

**Campos:**
- `id_cliente` - Identificador único
- `nombre` - Nombre completo del cliente
- `telefono` - Número de contacto (opcional)
- `correo` - Email (opcional)  
- `direccion` - Dirección de entrega (opcional)

**Índices:**
- PRIMARY KEY: `id_cliente`
- INDEX: `telefono` (para búsquedas rápidas)

---

### 3. 🏢 **proveedores**
Información de proveedores para el sistema de compras.

```sql
CREATE TABLE proveedores (
    id_proveedor INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    contacto VARCHAR(100),
    telefono VARCHAR(20),
    correo VARCHAR(100),
    direccion TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

**Campos:**
- `id_proveedor` - Identificador único
- `nombre` - Nombre de la empresa proveedora
- `contacto` - Persona de contacto
- `telefono` - Teléfono comercial
- `correo` - Email comercial
- `direccion` - Dirección de la empresa

---

### 4. 📦 **pedidos**
Registro de todas las órdenes de clientes.

```sql
CREATE TABLE pedidos (
    id_pedido INT PRIMARY KEY AUTO_INCREMENT,
    id_cliente INT,
    fecha_hora DATETIME NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    estado ENUM('pendiente', 'completado', 'cancelado') DEFAULT 'pendiente',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente)
);
```

**Campos:**
- `id_pedido` - Identificador único del pedido
- `id_cliente` - Cliente que realizó el pedido (FK, opcional)
- `fecha_hora` - Momento exacto del pedido
- `total` - Monto total del pedido
- `estado` - Estado actual (pendiente/completado/cancelado)

**Estados Posibles:**
- `pendiente` - Recién creado, en preparación
- `completado` - Entregado y pagado
- `cancelado` - Cancelado por cualquier motivo

**Índices:**
- PRIMARY KEY: `id_pedido`
- FOREIGN KEY: `id_cliente` → `clientes(id_cliente)`
- INDEX: `estado` (para filtros)
- INDEX: `fecha_hora` (para reportes por fecha)

---

### 5. 🛒 **detalle_pedidos**
Detalle de productos incluidos en cada pedido.

```sql
CREATE TABLE detalle_pedidos (
    id_detalle INT PRIMARY KEY AUTO_INCREMENT,
    id_pedido INT NOT NULL,
    id_producto INT NOT NULL,
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(8,2) NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_pedido) REFERENCES pedidos(id_pedido) ON DELETE CASCADE,
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto)
);
```

**Campos:**
- `id_detalle` - Identificador único del detalle
- `id_pedido` - Pedido al que pertenece (FK)
- `id_producto` - Producto pedido (FK)
- `cantidad` - Cantidad solicitada
- `precio_unitario` - Precio del producto al momento del pedido
- `subtotal` - cantidad × precio_unitario

**Índices:**
- PRIMARY KEY: `id_detalle`
- FOREIGN KEY: `id_pedido` → `pedidos(id_pedido)` CASCADE
- FOREIGN KEY: `id_producto` → `productos(id_producto)`
- INDEX: Composite (`id_pedido`, `id_producto`)

---

## 🔗 Relaciones

### Diagrama de Relaciones

```
clientes (1:N) pedidos (1:N) detalle_pedidos (N:1) productos
    ↓              ↓                ↓                    ↓
id_cliente → id_cliente      id_pedido → id_pedido      id_producto → id_producto
                                          ↓
                             Almacena precio y cantidad
                             en el momento del pedido
```

### Tipos de Relaciones

1. **clientes → pedidos** (1:N)
   - Un cliente puede tener múltiples pedidos
   - Un pedido pertenece a un cliente (opcional)

2. **pedidos → detalle_pedidos** (1:N)
   - Un pedido puede tener múltiples productos
   - Cada detalle pertenece a un solo pedido

3. **productos → detalle_pedidos** (1:N)
   - Un producto puede estar en múltiples pedidos
   - Cada línea de detalle corresponde a un producto

4. **proveedores** (Independiente)
   - Preparado para futuro módulo de compras
   - No tiene relaciones activas actualmente

---

## 🚀 Migraciones

Las migraciones están organizadas cronológicamente:

### Orden de Ejecución
```bash
# 1. Tablas principales
2024_01_01_000001_create_productos_table.php
2024_01_01_000002_create_clientes_table.php  
2024_01_01_000003_create_proveedores_table.php

# 2. Tablas con relaciones
2024_01_01_000004_create_pedidos_table.php
2024_01_01_000005_create_detalle_pedidos_table.php

# 3. Modificaciones
2024_09_24_000006_add_activo_to_productos_table.php
```

### Ejecutar Migraciones
```bash
# Ejecutar todas las migraciones
php artisan migrate

# Ejecutar con datos de prueba
php artisan migrate --seed

# Rollback (deshacer)
php artisan migrate:rollback

# Status de migraciones
php artisan migrate:status
```

---

## 🌱 Seeders

### DatabaseSeeder
Ejecuta todos los seeders en orden:

```php
public function run()
{
    $this->call([
        ProductoSeeder::class,    // 20 productos de ejemplo
        ClienteSeeder::class,     // 15 clientes de prueba
        ProveedorSeeder::class,   // 8 proveedores
        PedidoSeeder::class,      // 25 pedidos con detalles
    ]);
}
```

### Datos de Ejemplo

**Productos**:
- Hamburguesas (5 tipos)
- Bebidas (6 opciones)
- Postres (4 variantes)
- Snacks (5 opciones)

**Clientes**:
- Nombres realistas
- Teléfonos y emails opcionales
- Direcciones variadas

**Pedidos**:
- Estados distribuidos (70% completados, 20% pendientes, 10% cancelados)
- Fechas del último mes
- Totales realistas

### Ejecutar Seeders
```bash
# Ejecutar todos
php artisan db:seed

# Ejecutar uno específico
php artisan db:seed --class=ProductoSeeder

# Refrescar DB con seeders
php artisan migrate:fresh --seed
```

---

## 🔍 Consultas Importantes

### Consultas para Dashboard

#### Ventas de Hoy
```sql
SELECT COUNT(*) as pedidos_hoy, SUM(total) as ventas_hoy
FROM pedidos 
WHERE DATE(fecha_hora) = CURDATE() 
AND estado = 'completado';
```

#### Productos con Stock Bajo
```sql
SELECT * FROM productos 
WHERE stock <= 10 AND activo = 1
ORDER BY stock ASC;
```

#### Top Productos Más Vendidos
```sql
SELECT p.nombre, p.categoria, SUM(dp.cantidad) as cantidad_vendida,
       SUM(dp.subtotal) as ingresos_total
FROM productos p
JOIN detalle_pedidos dp ON p.id_producto = dp.id_producto
JOIN pedidos ped ON dp.id_pedido = ped.id_pedido
WHERE ped.estado = 'completado'
GROUP BY p.id_producto
ORDER BY cantidad_vendida DESC
LIMIT 10;
```

### Consultas para Reportes

#### Ventas por Día
```sql
SELECT DATE(fecha_hora) as fecha,
       COUNT(*) as pedidos,
       SUM(total) as ventas
FROM pedidos 
WHERE estado = 'completado'
AND fecha_hora BETWEEN ? AND ?
GROUP BY DATE(fecha_hora)
ORDER BY fecha DESC;
```

#### Clientes Más Frecuentes
```sql
SELECT c.nombre, c.telefono,
       COUNT(p.id_pedido) as total_pedidos,
       SUM(p.total) as total_gastado,
       AVG(p.total) as promedio_pedido,
       MAX(p.fecha_hora) as ultimo_pedido
FROM clientes c
JOIN pedidos p ON c.id_cliente = p.id_cliente
WHERE p.estado = 'completado'
GROUP BY c.id_cliente
ORDER BY total_gastado DESC;
```

### Consultas de Inventario

#### Valor Total del Inventario
```sql
SELECT SUM(precio * stock) as valor_total_inventario
FROM productos 
WHERE activo = 1;
```

#### Productos por Categoría
```sql
SELECT categoria,
       COUNT(*) as total_productos,
       SUM(stock) as stock_total,
       SUM(precio * stock) as valor_categoria,
       AVG(precio) as precio_promedio
FROM productos 
WHERE activo = 1
GROUP BY categoria;
```

---

## ⚡ Optimizaciones

### Índices Recomendados
```sql
-- Para búsquedas frecuentes
CREATE INDEX idx_productos_categoria ON productos(categoria);
CREATE INDEX idx_productos_activo ON productos(activo);
CREATE INDEX idx_pedidos_estado ON pedidos(estado);
CREATE INDEX idx_pedidos_fecha ON pedidos(fecha_hora);
CREATE INDEX idx_clientes_telefono ON clientes(telefono);

-- Para reportes
CREATE INDEX idx_pedidos_fecha_estado ON pedidos(fecha_hora, estado);
CREATE INDEX idx_detalle_composite ON detalle_pedidos(id_pedido, id_producto);
```

### Mantenimiento
```sql
-- Análizar tablas
ANALYZE TABLE productos, clientes, pedidos, detalle_pedidos;

-- Optimizar tablas
OPTIMIZE TABLE productos, clientes, pedidos, detalle_pedidos;

-- Verificar integridad
CHECK TABLE productos, clientes, pedidos, detalle_pedidos;
```

---

## 🔒 Consideraciones de Seguridad

### Validaciones a Nivel de Base
- **NOT NULL** en campos obligatorios
- **FOREIGN KEY CONSTRAINTS** para integridad referencial
- **ENUM** para estados limitados
- **DECIMAL** para precios (no FLOAT para evitar problemas de precisión)

### Backup y Recuperación
```bash
# Backup completo
mysqldump -u usuario -p carrito_comida > backup_$(date +%Y%m%d).sql

# Restaurar backup
mysql -u usuario -p carrito_comida < backup_20241024.sql

# Backup solo estructura
mysqldump -u usuario -p --no-data carrito_comida > estructura.sql
```

---

## 📈 Estadísticas de Uso

### Tamaños Estimados (con datos de ejemplo)
- **productos**: ~2KB (20 registros)
- **clientes**: ~1.5KB (15 registros)
- **proveedores**: ~800B (8 registros)
- **pedidos**: ~1KB (25 registros)
- **detalle_pedidos**: ~2KB (50+ registros)

### Crecimiento Esperado
- **Productos**: Crecimiento lento (~50-100 productos max)
- **Clientes**: Crecimiento constante (~10-20 nuevos/mes)
- **Pedidos**: Alto volumen (~50-200 pedidos/día)
- **Detalle_pedidos**: Muy alto volumen (~150-600 líneas/día)

---

*Documentación actualizada: 24 de Septiembre, 2025*