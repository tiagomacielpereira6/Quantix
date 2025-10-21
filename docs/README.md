# 🍔 Sistema de Gestión - Carrito Comida Rápida

## 📋 Índice de Documentación

Este directorio contiene la documentación completa del sistema de gestión para el carrito de comida rápida.

### 📁 Archivos de Documentación

1. **[README.md](README.md)** - Este archivo (índice principal)
2. **[INSTALACION.md](INSTALACION.md)** - Guía de instalación y configuración
3. **[BASE_DE_DATOS.md](BASE_DE_DATOS.md)** - Estructura y diseño de la base de datos
4. **[ARQUITECTURA.md](ARQUITECTURA.md)** - Arquitectura del sistema y tecnologías
5. **[FUNCIONALIDADES.md](FUNCIONALIDADES.md)** - Descripción detallada de funcionalidades
6. **[API.md](API.md)** - Documentación de rutas y controladores
7. **[FRONTEND.md](FRONTEND.md)** - Componentes Vue.js y interfaz de usuario
8. **[PDF_SYSTEM.md](PDF_SYSTEM.md)** - Sistema de generación de PDFs
9. **[MANUAL_USUARIO.md](MANUAL_USUARIO.md)** - Manual para usuarios finales
10. **[DESARROLLO.md](DESARROLLO.md)** - Guía para desarrolladores

---

## 🚀 Resumen del Proyecto

**Sistema de Gestión para Carrito de Comida Rápida** es una aplicación web completa desarrollada para la gestión integral de un negocio de comida rápida. 

### 🎯 Objetivo
Digitalizar y optimizar todos los procesos del negocio, desde la gestión de productos hasta la generación de reportes, mejorando la eficiencia operativa y la experiencia del cliente.

### 👥 Destinatarios
- **Propietarios** de carritos de comida rápida
- **Empleados** que manejan pedidos y cocina
- **Administradores** que necesitan reportes y análisis

---

## ⚡ Inicio Rápido

### Prerrequisitos
- PHP 8.1+
- Node.js 18+
- MariaDB/MySQL
- Composer

### Instalación Básica
```bash
# Clonar repositorio
git clone [repo-url]
cd Leandro

# Instalar dependencias
composer install
npm install

# Configurar base de datos
cp .env.example .env
php artisan key:generate
php artisan migrate --seed

# Iniciar servidor
php artisan serve
npm run dev
```

📖 **Para instalación detallada, ver [INSTALACION.md](INSTALACION.md)**

---

## 🏗️ Tecnologías Utilizadas

### Backend
- **Laravel 12** - Framework PHP
- **MariaDB** - Base de datos
- **Inertia.js** - Stack moderno SPA

### Frontend  
- **Vue.js 3** - Framework JavaScript
- **Tailwind CSS** - Framework de estilos
- **Vite** - Build tool

### Funcionalidades Especiales
- **DomPDF** - Generación de documentos PDF
- **Carbon** - Manejo de fechas
- **Componentes Reutilizables** - Arquitectura modular

---

## 📊 Módulos Principales

| Módulo | Descripción | Estado |
|--------|-------------|--------|
| 🏠 **Dashboard** | Panel principal con métricas | ✅ Completado |
| 🍔 **Productos** | Gestión de catálogo | ✅ Completado |
| 📦 **Pedidos** | Procesamiento de órdenes | ✅ Completado |
| 👥 **Clientes** | Base de datos de clientes | ✅ Completado |
| 🏢 **Proveedores** | Gestión de proveedores | ✅ Completado |
| 📊 **Reportes** | Análisis y estadísticas | ✅ Completado |
| 📄 **PDFs** | Tickets y comprobantes | ✅ Completado |
| 🛒 **Compras** | Sistema de compras | 🔄 Pendiente |

---

## 🔍 Características Destacadas

### ✨ Interfaz de Usuario
- **Responsive Design** - Funciona en desktop, tablet y móvil
- **Menús Interactivos** - Dropdowns con confirmaciones
- **Feedback Visual** - Estados de carga y notificaciones
- **Navegación Intuitiva** - Flujo de trabajo optimizado

### 📈 Análisis y Reportes
- **Dashboard en Tiempo Real** - Métricas actualizadas
- **Reportes PDF** - Ventas, inventario y clientes
- **Filtros Avanzados** - Por fechas, estados, categorías
- **Exportación** - Documentos listos para imprimir

### 🎫 Sistema de Tickets
- **Tickets de Pedido** - Para clientes
- **Tickets de Cocina** - Para preparación
- **Recibos de Pago** - Comprobantes fiscales
- **Formato Profesional** - Diseño limpio y legible

### 🔒 Gestión de Datos
- **Integridad Referencial** - Relaciones consistentes
- **Soft Deletes** - Productos inactivos vs eliminados
- **Validaciones** - Entrada de datos segura
- **Auditoría** - Registro de cambios importantes

---

## 📞 Soporte y Contacto

Para preguntas sobre la documentación o el sistema:

- **Desarrollador**: Leandro
- **Proyecto**: Trabajo de Graduación
- **Fecha**: Septiembre 2025
- **Tecnología**: Laravel + Vue.js + Inertia.js

---

## 📝 Notas Importantes

> **⚠️ Proyecto Académico**: Este sistema fue desarrollado como proyecto de graduación. Para uso en producción, se recomienda implementar medidas adicionales de seguridad y testing.

> **🔧 En Desarrollo**: El módulo de compras está en desarrollo. Las demás funcionalidades están completamente operativas.

> **📚 Documentación Viva**: Esta documentación se actualiza constantemente. Consulta regularmente para obtener la información más reciente.

---

*Última actualización: 24 de Septiembre, 2025*