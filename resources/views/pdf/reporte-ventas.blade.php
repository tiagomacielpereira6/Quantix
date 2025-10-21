<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Ventas</title>
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
            background: linear-gradient(135deg, #007bff, #0056b3);
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
        
        .periodo {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            border: 2px solid #007bff;
        }
        
        .periodo h2 {
            color: #007bff;
            margin-bottom: 5px;
        }
        
        .estadisticas-grid {
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
        
        .stat-card.primary { border-color: #007bff; }
        .stat-card.success { border-color: #28a745; }
        .stat-card.warning { border-color: #ffc107; }
        .stat-card.danger { border-color: #dc3545; }
        
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
            background: #007bff;
            color: white;
            padding: 10px 15px;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 15px;
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
        
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        
        .chart-placeholder {
            background: #f8f9fa;
            border: 2px dashed #dee2e6;
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            font-style: italic;
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
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>*** REPORTE DE VENTAS ***</h1>
        <p>Quantix - Analisis Comercial</p>
    </div>

    <!-- Período -->
    <div class="periodo">
        <h2>*** PERIODO DEL REPORTE ***</h2>
        <p><strong>Desde:</strong> {{ \Carbon\Carbon::parse($reportes['periodo']['fecha_inicio'])->format('d/m/Y') }} 
           <strong>Hasta:</strong> {{ \Carbon\Carbon::parse($reportes['periodo']['fecha_fin'])->format('d/m/Y') }}</p>
    </div>

    <!-- Estadísticas Generales -->
    <div class="estadisticas-grid">
        <div class="stat-card success">
            <div class="stat-icon">💰</div>
            <div class="stat-value">${{ number_format($reportes['estadisticas_generales']['total_ventas'], 2) }}</div>
            <div class="stat-label">Total Ventas</div>
        </div>
        <div class="stat-card primary">
            <div class="stat-icon">📦</div>
            <div class="stat-value">{{ $reportes['estadisticas_generales']['total_pedidos'] }}</div>
            <div class="stat-label">Total Pedidos</div>
        </div>
        <div class="stat-card warning">
            <div class="stat-icon">🎯</div>
            <div class="stat-value">${{ number_format($reportes['estadisticas_generales']['ticket_promedio'], 2) }}</div>
            <div class="stat-label">Ticket Promedio</div>
        </div>
        <div class="stat-card danger">
            <div class="stat-icon">✅</div>
            <div class="stat-value">{{ number_format(($reportes['estadisticas_generales']['pedidos_completados'] / max($reportes['estadisticas_generales']['total_pedidos'], 1)) * 100, 1) }}%</div>
            <div class="stat-label">Tasa Éxito</div>
        </div>
    </div>

    <!-- Ventas por Día -->
    <div class="section">
        <div class="section-title">📈 Ventas por Día</div>
        <table class="table">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th class="text-center">Pedidos</th>
                    <th class="text-right">Ventas ($)</th>
                    <th class="text-right">Promedio Día</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reportes['ventas_por_dia'] as $venta)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y') }}</td>
                    <td class="text-center">{{ $venta->pedidos }}</td>
                    <td class="text-right">${{ number_format($venta->ventas, 2) }}</td>
                    <td class="text-right">${{ $venta->pedidos > 0 ? number_format($venta->ventas / $venta->pedidos, 2) : '0.00' }}</td>
                </tr>
                @endforeach
                @if($reportes['ventas_por_dia']->isEmpty())
                <tr>
                    <td colspan="4" class="text-center" style="color: #666; font-style: italic;">
                        No hay datos de ventas en el período seleccionado
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Productos Top -->
    <div class="section">
        <div class="section-title">🏆 Productos Más Vendidos</div>
        <table class="table">
            <thead>
                <tr>
                    <th>Posición</th>
                    <th>Producto</th>
                    <th>Categoría</th>
                    <th class="text-center">Cantidad Vendida</th>
                    <th class="text-right">Ingresos</th>
                    <th class="text-right">Precio Unit.</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reportes['productos_top']->take(10) as $index => $producto)
                <tr>
                    <td class="text-center">
                        @if($index == 0) 🥇
                        @elseif($index == 1) 🥈
                        @elseif($index == 2) 🥉
                        @else {{ $index + 1 }}
                        @endif
                    </td>
                    <td><strong>{{ $producto->nombre }}</strong></td>
                    <td>{{ $producto->categoria ?? 'Sin categoría' }}</td>
                    <td class="text-center">{{ $producto->cantidad_vendida }}</td>
                    <td class="text-right">${{ number_format($producto->ingresos_total, 2) }}</td>
                    <td class="text-right">${{ number_format($producto->precio, 2) }}</td>
                </tr>
                @endforeach
                @if($reportes['productos_top']->isEmpty())
                <tr>
                    <td colspan="6" class="text-center" style="color: #666; font-style: italic;">
                        No hay productos vendidos en el período seleccionado
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Nueva página para clientes -->
    <div class="page-break"></div>

    <!-- Clientes Top -->
    <div class="section">
        <div class="section-title">👥 Clientes Más Frecuentes</div>
        <table class="table">
            <thead>
                <tr>
                    <th>Posición</th>
                    <th>Cliente</th>
                    <th>Teléfono</th>
                    <th class="text-center">Total Pedidos</th>
                    <th class="text-right">Total Gastado</th>
                    <th class="text-right">Promedio por Pedido</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reportes['clientes_top']->take(15) as $index => $cliente)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td><strong>{{ $cliente->nombre }}</strong></td>
                    <td>{{ $cliente->telefono ?? 'N/A' }}</td>
                    <td class="text-center">{{ $cliente->total_pedidos }}</td>
                    <td class="text-right">${{ number_format($cliente->total_gastado, 2) }}</td>
                    <td class="text-right">${{ number_format($cliente->promedio_pedido, 2) }}</td>
                </tr>
                @endforeach
                @if($reportes['clientes_top']->isEmpty())
                <tr>
                    <td colspan="6" class="text-center" style="color: #666; font-style: italic;">
                        No hay clientes en el período seleccionado
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Ventas por Categoría -->
    <div class="section">
        <div class="section-title">📊 Ventas por Categoría</div>
        <table class="table">
            <thead>
                <tr>
                    <th>Categoría</th>
                    <th class="text-center">Cantidad Vendida</th>
                    <th class="text-right">Ingresos</th>
                    <th class="text-center">Pedidos</th>
                    <th class="text-right">% del Total</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalIngresos = $reportes['ventas_por_categoria']->sum('ingresos');
                @endphp
                @foreach($reportes['ventas_por_categoria'] as $categoria)
                <tr>
                    <td><strong>{{ $categoria->categoria ?? 'Sin categoría' }}</strong></td>
                    <td class="text-center">{{ $categoria->cantidad_vendida }}</td>
                    <td class="text-right">${{ number_format($categoria->ingresos, 2) }}</td>
                    <td class="text-center">{{ $categoria->pedidos_categoria }}</td>
                    <td class="text-right">{{ $totalIngresos > 0 ? number_format(($categoria->ingresos / $totalIngresos) * 100, 1) : 0 }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Stock Bajo -->
    @if(!$reportes['stock_bajo']->isEmpty())
    <div class="section">
        <div class="section-title">⚠️ Productos con Stock Bajo</div>
        <table class="table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Categoría</th>
                    <th class="text-center">Stock Actual</th>
                    <th class="text-right">Precio</th>
                    <th class="text-center">Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reportes['stock_bajo'] as $producto)
                <tr>
                    <td><strong>{{ $producto->nombre }}</strong></td>
                    <td>{{ $producto->categoria ?? 'Sin categoría' }}</td>
                    <td class="text-center">{{ $producto->stock }}</td>
                    <td class="text-right">${{ number_format($producto->precio, 2) }}</td>
                    <td class="text-center">
                        @if($producto->stock == 0)
                            <span style="color: #dc3545; font-weight: bold;">❌ Agotado</span>
                        @else
                            <span style="color: #ffc107; font-weight: bold;">⚠️ Stock Bajo</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <div><strong>Quantix</strong></div>
        <div>Reporte generado automáticamente el {{ now()->format('d/m/Y H:i:s') }}</div>
        <div>Sistema de Gestión Inteligente v1.0</div>
    </div>
</body>
</html>