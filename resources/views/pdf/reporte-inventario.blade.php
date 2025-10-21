<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Inventario</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #333;
        }
        
        .header {
            text-align: center;
            background: linear-gradient(135deg, #28a745, #1e7e34);
            color: white;
            padding: 20px;
            margin-bottom: 30px;
        }
        
        .header h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }
        
        .header p {
            font-size: 14px;
            opacity: 0.9;
        }
        
        .fecha-generacion {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            border: 2px solid #28a745;
        }
        
        .fecha-generacion h2 {
            color: #28a745;
            margin-bottom: 5px;
        }
        
        .resumen-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .stat-card.success { border-color: #28a745; }
        .stat-card.warning { border-color: #ffc107; }
        .stat-card.danger { border-color: #dc3545; }
        .stat-card.info { border-color: #17a2b8; }
        
        .stat-icon {
            font-size: 24px;
            margin-bottom: 8px;
        }
        
        .stat-value {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .stat-label {
            font-size: 10px;
            color: #666;
            text-transform: uppercase;
        }
        
        .section {
            margin: 30px 0;
        }
        
        .section-title {
            background: #28a745;
            color: white;
            padding: 10px 15px;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 15px;
        }
        
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            border-left: 5px solid;
        }
        
        .alert.warning {
            background: #fff3cd;
            border-color: #ffc107;
            color: #856404;
        }
        
        .alert.danger {
            background: #f8d7da;
            border-color: #dc3545;
            color: #721c24;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .table th {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: left;
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
        }
        
        .table td {
            border: 1px solid #dee2e6;
            padding: 8px;
            font-size: 10px;
        }
        
        .table tr:nth-child(even) {
            background: #f8f9fa;
        }
        
        .stock-status {
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 9px;
            text-transform: uppercase;
        }
        
        .stock-optimo {
            background: #d4edda;
            color: #155724;
        }
        
        .stock-medio {
            background: #fff3cd;
            color: #856404;
        }
        
        .stock-bajo {
            background: #f8d7da;
            color: #721c24;
        }
        
        .stock-agotado {
            background: #dc3545;
            color: white;
        }
        
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .text-left { text-align: left; }
        
        .valor-inventario {
            background: #e3f2fd;
            border: 2px solid #2196f3;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            margin: 20px 0;
        }
        
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 2px solid #dee2e6;
            padding-top: 20px;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        .categoria-header {
            background: #6c757d;
            color: white;
            font-weight: bold;
            font-size: 11px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>📦 REPORTE DE INVENTARIO</h1>
        <p>Quantix - Gestión de Stock</p>
    </div>

    <!-- Fecha de Generación -->
    <div class="fecha-generacion">
        <h2>📅 Fecha de Generación</h2>
        <p><strong>{{ now()->format('d/m/Y H:i:s') }}</strong></p>
    </div>

    <!-- Resumen General -->
    <div class="resumen-grid">
        <div class="stat-card info">
            <div class="stat-icon">🏪</div>
            <div class="stat-value">{{ $inventario['resumen']['total_productos'] }}</div>
            <div class="stat-label">Total Productos</div>
        </div>
        <div class="stat-card success">
            <div class="stat-icon">✅</div>
            <div class="stat-value">{{ $inventario['resumen']['productos_activos'] }}</div>
            <div class="stat-label">Productos Activos</div>
        </div>
        <div class="stat-card warning">
            <div class="stat-icon">⚠️</div>
            <div class="stat-value">{{ $inventario['resumen']['stock_bajo'] }}</div>
            <div class="stat-label">Stock Bajo</div>
        </div>
        <div class="stat-card danger">
            <div class="stat-icon">❌</div>
            <div class="stat-value">{{ $inventario['resumen']['sin_stock'] }}</div>
            <div class="stat-label">Sin Stock</div>
        </div>
    </div>

    <!-- Valor Total del Inventario -->
    <div class="valor-inventario">
        <h3 style="color: #1976d2; margin-bottom: 10px;">💰 Valor Total del Inventario</h3>
        <div style="font-size: 28px; font-weight: bold; color: #1976d2;">
            ${{ number_format($inventario['resumen']['valor_total'], 2) }}
        </div>
        <div style="font-size: 12px; color: #666; margin-top: 5px;">
            Calculado basado en precio de venta × stock disponible
        </div>
    </div>

    <!-- Alertas de Stock -->
    @if($inventario['resumen']['stock_bajo'] > 0 || $inventario['resumen']['sin_stock'] > 0)
    <div class="section">
        @if($inventario['resumen']['sin_stock'] > 0)
        <div class="alert danger">
            <strong>🚨 PRODUCTOS AGOTADOS:</strong> Hay {{ $inventario['resumen']['sin_stock'] }} productos sin stock que requieren reposición inmediata.
        </div>
        @endif
        
        @if($inventario['resumen']['stock_bajo'] > 0)
        <div class="alert warning">
            <strong>⚠️ STOCK BAJO:</strong> Hay {{ $inventario['resumen']['stock_bajo'] }} productos con stock bajo que necesitan reposición pronto.
        </div>
        @endif
    </div>
    @endif

    <!-- Inventario Completo -->
    <div class="section">
        <div class="section-title">📋 Inventario Completo</div>
        <table class="table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Categoría</th>
                    <th class="text-center">Stock Actual</th>
                    <th class="text-right">Precio Unitario</th>
                    <th class="text-right">Valor Total</th>
                    <th class="text-center">Estado</th>
                    <th class="text-center">Activo</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $categoriaActual = null;
                @endphp
                @foreach($inventario['productos'] as $producto)
                    @if($categoriaActual !== $producto->categoria)
                        @php $categoriaActual = $producto->categoria; @endphp
                        <tr class="categoria-header">
                            <td colspan="7">
                                📂 {{ $producto->categoria ?? 'Sin Categoría' }}
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <td><strong>{{ $producto->nombre }}</strong></td>
                        <td>{{ $producto->categoria ?? 'Sin categoría' }}</td>
                        <td class="text-center">{{ $producto->stock }}</td>
                        <td class="text-right">${{ number_format($producto->precio, 2) }}</td>
                        <td class="text-right">${{ number_format($producto->precio * $producto->stock, 2) }}</td>
                        <td class="text-center">
                            @if($producto->stock == 0)
                                <span class="stock-status stock-agotado">Agotado</span>
                            @elseif($producto->stock <= 5)
                                <span class="stock-status stock-bajo">Stock Bajo</span>
                            @elseif($producto->stock <= 10)
                                <span class="stock-status stock-medio">Stock Medio</span>
                            @else
                                <span class="stock-status stock-optimo">Stock Óptimo</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($producto->activo)
                                <span style="color: #28a745; font-weight: bold;">✅ Sí</span>
                            @else
                                <span style="color: #dc3545; font-weight: bold;">❌ No</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
                @if($inventario['productos']->isEmpty())
                <tr>
                    <td colspan="7" class="text-center" style="color: #666; font-style: italic;">
                        No hay productos en el inventario
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Nueva página para análisis -->
    <div class="page-break"></div>

    <!-- Productos que Necesitan Reposición -->
    @if(!$inventario['productos']->where('stock', '<=', 10)->isEmpty())
    <div class="section">
        <div class="section-title">🚨 Productos que Necesitan Reposición</div>
        <table class="table">
            <thead>
                <tr>
                    <th>Prioridad</th>
                    <th>Producto</th>
                    <th>Categoría</th>
                    <th class="text-center">Stock Actual</th>
                    <th class="text-right">Precio Unit.</th>
                    <th class="text-center">Sugerencia</th>
                </tr>
            </thead>
            <tbody>
                @foreach($inventario['productos']->where('stock', '<=', 10)->sortBy('stock') as $producto)
                <tr>
                    <td class="text-center">
                        @if($producto->stock == 0)
                            <span style="color: #dc3545; font-weight: bold;">🔴 URGENTE</span>
                        @elseif($producto->stock <= 3)
                            <span style="color: #fd7e14; font-weight: bold;">🟠 ALTA</span>
                        @else
                            <span style="color: #ffc107; font-weight: bold;">🟡 MEDIA</span>
                        @endif
                    </td>
                    <td><strong>{{ $producto->nombre }}</strong></td>
                    <td>{{ $producto->categoria ?? 'Sin categoría' }}</td>
                    <td class="text-center">{{ $producto->stock }}</td>
                    <td class="text-right">${{ number_format($producto->precio, 2) }}</td>
                    <td class="text-center">
                        @if($producto->stock == 0)
                            Reponer inmediatamente
                        @elseif($producto->stock <= 3)
                            Reponer en 1-2 días
                        @else
                            Reponer esta semana
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!-- Análisis por Categoría -->
    <div class="section">
        <div class="section-title">📊 Análisis por Categoría</div>
        <table class="table">
            <thead>
                <tr>
                    <th>Categoría</th>
                    <th class="text-center">Total Productos</th>
                    <th class="text-center">Stock Total</th>
                    <th class="text-right">Valor Categoría</th>
                    <th class="text-right">Precio Promedio</th>
                </tr>
            </thead>
            <tbody>
                @foreach($inventario['por_categoria'] as $categoria)
                <tr>
                    <td><strong>{{ $categoria->categoria ?? 'Sin Categoría' }}</strong></td>
                    <td class="text-center">{{ $categoria->total_productos }}</td>
                    <td class="text-center">{{ $categoria->stock_total }}</td>
                    <td class="text-right">${{ number_format($categoria->valor_categoria, 2) }}</td>
                    <td class="text-right">${{ number_format($categoria->precio_promedio, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Productos Inactivos -->
    @if(!$inventario['productos']->where('activo', false)->isEmpty())
    <div class="section">
        <div class="section-title">💤 Productos Inactivos</div>
        <table class="table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Categoría</th>
                    <th class="text-center">Stock</th>
                    <th class="text-right">Precio</th>
                    <th class="text-right">Valor Retenido</th>
                </tr>
            </thead>
            <tbody>
                @foreach($inventario['productos']->where('activo', false) as $producto)
                <tr>
                    <td>{{ $producto->nombre }}</td>
                    <td>{{ $producto->categoria ?? 'Sin categoría' }}</td>
                    <td class="text-center">{{ $producto->stock }}</td>
                    <td class="text-right">${{ number_format($producto->precio, 2) }}</td>
                    <td class="text-right">${{ number_format($producto->precio * $producto->stock, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="alert warning">
            <strong>💡 Recomendación:</strong> Considera reactivar productos con buen stock o liquidar el inventario de productos que no planeas vender.
        </div>
    </div>
    @endif

    <!-- Resumen de Acciones Recomendadas -->
    <div class="section">
        <div class="section-title">✅ Acciones Recomendadas</div>
        <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; border-left: 5px solid #28a745;">
            <h4 style="color: #28a745; margin-bottom: 10px;">📋 Lista de Tareas</h4>
            <ul style="margin-left: 20px; line-height: 1.6;">
                @if($inventario['resumen']['sin_stock'] > 0)
                <li><strong>URGENTE:</strong> Reponer {{ $inventario['resumen']['sin_stock'] }} productos agotados</li>
                @endif
                @if($inventario['resumen']['stock_bajo'] > 0)
                <li><strong>IMPORTANTE:</strong> Revisar reposición de {{ $inventario['resumen']['stock_bajo'] }} productos con stock bajo</li>
                @endif
                <li>Contactar proveedores para próximas compras</li>
                <li>Revisar precios de productos con baja rotación</li>
                @if(!$inventario['productos']->where('activo', false)->isEmpty())
                <li>Evaluar reactivación o liquidación de productos inactivos</li>
                @endif
                <li>Actualizar sistema de inventario regularmente</li>
            </ul>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div><strong>Quantix</strong></div>
        <div>Reporte de inventario generado el {{ now()->format('d/m/Y H:i:s') }}</div>
        <div>Sistema de Gestión Inteligente v1.0</div>
    </div>
</body>
</html>