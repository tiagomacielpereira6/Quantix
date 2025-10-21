<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Clientes</title>
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
            background: linear-gradient(135deg, #6f42c1, #5a2d8c);
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
            border: 2px solid #6f42c1;
        }
        
        .fecha-generacion h2 {
            color: #6f42c1;
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
        
        .stat-card.primary { border-color: #6f42c1; }
        .stat-card.success { border-color: #28a745; }
        .stat-card.info { border-color: #17a2b8; }
        .stat-card.warning { border-color: #ffc107; }
        
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
            background: #6f42c1;
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
        
        .cliente-vip {
            background: linear-gradient(45deg, #ffd700, #ffed4e) !important;
            font-weight: bold;
        }
        
        .cliente-frecuente {
            background: linear-gradient(45deg, #c3e6cb, #d4edda) !important;
        }
        
        .cliente-nuevo {
            background: linear-gradient(45deg, #cce5ff, #e3f2fd) !important;
        }
        
        .badge {
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .badge-vip {
            background: #ffd700;
            color: #856404;
        }
        
        .badge-frecuente {
            background: #28a745;
            color: white;
        }
        
        .badge-regular {
            background: #17a2b8;
            color: white;
        }
        
        .badge-nuevo {
            background: #6c757d;
            color: white;
        }
        
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .text-left { text-align: left; }
        
        .resumen-financiero {
            background: #e8f4fd;
            border: 2px solid #2196f3;
            padding: 15px;
            border-radius: 8px;
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
        
        .contacto-info {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 4px;
            font-size: 9px;
            color: #666;
        }
        
        .grafico-barras {
            background: #f8f9fa;
            border: 2px dashed #dee2e6;
            height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            font-style: italic;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>👥 REPORTE DE CLIENTES</h1>
        <p>Quantix - Análisis de Clientela</p>
    </div>

    <!-- Fecha de Generación -->
    <div class="fecha-generacion">
        <h2>📅 Fecha de Generación</h2>
        <p><strong>{{ now()->format('d/m/Y H:i:s') }}</strong></p>
    </div>

    <!-- Estadísticas Generales -->
    <div class="estadisticas-grid">
        <div class="stat-card primary">
            <div class="stat-icon">👨‍👩‍👧‍👦</div>
            <div class="stat-value">{{ $clientes['resumen']['total_clientes'] }}</div>
            <div class="stat-label">Total Clientes</div>
        </div>
        <div class="stat-card success">
            <div class="stat-icon">🛒</div>
            <div class="stat-value">{{ $clientes['resumen']['clientes_activos'] }}</div>
            <div class="stat-label">Clientes Activos</div>
        </div>
        <div class="stat-card info">
            <div class="stat-icon">📈</div>
            <div class="stat-value">{{ $clientes['resumen']['clientes_nuevos_mes'] }}</div>
            <div class="stat-label">Nuevos Este Mes</div>
        </div>
        <div class="stat-card warning">
            <div class="stat-icon">💰</div>
            <div class="stat-value">${{ number_format($clientes['resumen']['gasto_promedio'], 2) }}</div>
            <div class="stat-label">Gasto Promedio</div>
        </div>
    </div>

    <!-- Resumen Financiero -->
    <div class="resumen-financiero">
        <h3 style="color: #1976d2; margin-bottom: 15px; text-align: center;">💳 Resumen Financiero de Clientes</h3>
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; text-align: center;">
            <div>
                <div style="font-size: 18px; font-weight: bold; color: #1976d2;">
                    ${{ number_format($clientes['resumen']['ingresos_totales'], 2) }}
                </div>
                <div style="font-size: 12px; color: #666;">Ingresos Totales</div>
            </div>
            <div>
                <div style="font-size: 18px; font-weight: bold; color: #1976d2;">
                    {{ $clientes['resumen']['pedidos_totales'] }}
                </div>
                <div style="font-size: 12px; color: #666;">Pedidos Totales</div>
            </div>
            <div>
                <div style="font-size: 18px; font-weight: bold; color: #1976d2;">
                    {{ number_format($clientes['resumen']['ticket_promedio'], 2) }}
                </div>
                <div style="font-size: 12px; color: #666;">Ticket Promedio</div>
            </div>
        </div>
    </div>

    <!-- Clientes VIP -->
    @if(!$clientes['clientes_vip']->isEmpty())
    <div class="section">
        <div class="section-title">👑 Clientes VIP (Top 10%)</div>
        <table class="table">
            <thead>
                <tr>
                    <th>Posición</th>
                    <th>Cliente</th>
                    <th>Teléfono</th>
                    <th class="text-center">Total Pedidos</th>
                    <th class="text-right">Total Gastado</th>
                    <th class="text-right">Promedio/Pedido</th>
                    <th class="text-center">Último Pedido</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clientes['clientes_vip'] as $index => $cliente)
                <tr class="cliente-vip">
                    <td class="text-center">
                        @if($index == 0) 👑
                        @elseif($index == 1) 🥇
                        @elseif($index == 2) 🥈
                        @else {{ $index + 1 }}
                        @endif
                    </td>
                    <td>
                        <strong>{{ $cliente->nombre }}</strong>
                        <span class="badge badge-vip">VIP</span>
                    </td>
                    <td>{{ $cliente->telefono ?? 'N/A' }}</td>
                    <td class="text-center">{{ $cliente->total_pedidos }}</td>
                    <td class="text-right">${{ number_format($cliente->total_gastado, 2) }}</td>
                    <td class="text-right">${{ number_format($cliente->promedio_pedido, 2) }}</td>
                    <td class="text-center">
                        {{ $cliente->ultimo_pedido ? \Carbon\Carbon::parse($cliente->ultimo_pedido)->format('d/m/Y') : 'N/A' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!-- Todos los Clientes -->
    <div class="section">
        <div class="section-title">📋 Registro Completo de Clientes</div>
        <table class="table">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Teléfono</th>
                    <th>Dirección</th>
                    <th class="text-center">Pedidos</th>
                    <th class="text-right">Total Gastado</th>
                    <th class="text-center">Categoría</th>
                    <th class="text-center">Último Pedido</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clientes['todos_clientes'] as $cliente)
                <tr class="@if($cliente->total_pedidos >= 10) cliente-frecuente @elseif($cliente->total_pedidos >= 5) cliente-regular @else cliente-nuevo @endif">
                    <td><strong>{{ $cliente->nombre }}</strong></td>
                    <td>{{ $cliente->telefono ?? 'N/A' }}</td>
                    <td>{{ $cliente->direccion ?? 'No especificada' }}</td>
                    <td class="text-center">{{ $cliente->total_pedidos ?? 0 }}</td>
                    <td class="text-right">${{ number_format($cliente->total_gastado ?? 0, 2) }}</td>
                    <td class="text-center">
                        @if(($cliente->total_gastado ?? 0) >= 1000)
                            <span class="badge badge-vip">VIP</span>
                        @elseif(($cliente->total_pedidos ?? 0) >= 10)
                            <span class="badge badge-frecuente">Frecuente</span>
                        @elseif(($cliente->total_pedidos ?? 0) >= 5)
                            <span class="badge badge-regular">Regular</span>
                        @else
                            <span class="badge badge-nuevo">Nuevo</span>
                        @endif
                    </td>
                    <td class="text-center">
                        {{ $cliente->ultimo_pedido ? \Carbon\Carbon::parse($cliente->ultimo_pedido)->format('d/m/Y') : 'Nunca' }}
                    </td>
                </tr>
                @endforeach
                @if($clientes['todos_clientes']->isEmpty())
                <tr>
                    <td colspan="7" class="text-center" style="color: #666; font-style: italic;">
                        No hay clientes registrados en el sistema
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Nueva página para análisis -->
    <div class="page-break"></div>

    <!-- Clientes Frecuentes -->
    @if(!$clientes['clientes_frecuentes']->isEmpty())
    <div class="section">
        <div class="section-title">⭐ Clientes Frecuentes (5+ Pedidos)</div>
        <table class="table">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Contacto</th>
                    <th class="text-center">Total Pedidos</th>
                    <th class="text-right">Total Gastado</th>
                    <th class="text-center">Frecuencia</th>
                    <th class="text-center">Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clientes['clientes_frecuentes'] as $cliente)
                <tr class="cliente-frecuente">
                    <td><strong>{{ $cliente->nombre }}</strong></td>
                    <td>
                        <div class="contacto-info">
                            📞 {{ $cliente->telefono ?? 'N/A' }}<br>
                            📍 {{ Str::limit($cliente->direccion ?? 'No especificada', 30) }}
                        </div>
                    </td>
                    <td class="text-center">{{ $cliente->total_pedidos }}</td>
                    <td class="text-right">${{ number_format($cliente->total_gastado, 2) }}</td>
                    <td class="text-center">
                        @if($cliente->total_pedidos >= 20)
                            <span style="color: #d4af37; font-weight: bold;">🔥 Muy Alta</span>
                        @elseif($cliente->total_pedidos >= 10)
                            <span style="color: #28a745; font-weight: bold;">📈 Alta</span>
                        @else
                            <span style="color: #17a2b8; font-weight: bold;">📊 Media</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @php
                            $diasSinPedido = $cliente->ultimo_pedido ? \Carbon\Carbon::parse($cliente->ultimo_pedido)->diffInDays(now()) : 999;
                        @endphp
                        @if($diasSinPedido <= 7)
                            <span style="color: #28a745; font-weight: bold;">✅ Activo</span>
                        @elseif($diasSinPedido <= 30)
                            <span style="color: #ffc107; font-weight: bold;">⚠️ Moderado</span>
                        @else
                            <span style="color: #dc3545; font-weight: bold;">❌ Inactivo</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!-- Clientes Inactivos -->
    @if(!$clientes['clientes_inactivos']->isEmpty())
    <div class="section">
        <div class="section-title">😴 Clientes Inactivos (30+ días sin pedidos)</div>
        <table class="table">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Teléfono</th>
                    <th class="text-center">Total Pedidos</th>
                    <th class="text-right">Total Gastado</th>
                    <th class="text-center">Último Pedido</th>
                    <th class="text-center">Días Inactivo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clientes['clientes_inactivos'] as $cliente)
                <tr style="background: #fff2f2;">
                    <td><strong>{{ $cliente->nombre }}</strong></td>
                    <td>{{ $cliente->telefono ?? 'N/A' }}</td>
                    <td class="text-center">{{ $cliente->total_pedidos ?? 0 }}</td>
                    <td class="text-right">${{ number_format($cliente->total_gastado ?? 0, 2) }}</td>
                    <td class="text-center">
                        {{ $cliente->ultimo_pedido ? \Carbon\Carbon::parse($cliente->ultimo_pedido)->format('d/m/Y') : 'Nunca' }}
                    </td>
                    <td class="text-center">
                        @if($cliente->ultimo_pedido)
                            {{ \Carbon\Carbon::parse($cliente->ultimo_pedido)->diffInDays(now()) }} días
                        @else
                            Sin pedidos
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="background: #fff3cd; padding: 15px; border-radius: 8px; border-left: 5px solid #ffc107; margin-top: 15px;">
            <strong>💡 Estrategia de Reactivación:</strong> Considera contactar estos clientes con ofertas especiales o descuentos para recuperar su interés.
        </div>
    </div>
    @endif

    <!-- Análisis de Segmentación -->
    <div class="section">
        <div class="section-title">🎯 Segmentación de Clientes</div>
        <table class="table">
            <thead>
                <tr>
                    <th>Categoría</th>
                    <th class="text-center">Cantidad</th>
                    <th class="text-center">% del Total</th>
                    <th class="text-right">Ingresos Generados</th>
                    <th class="text-right">Promedio por Cliente</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalClientes = $clientes['segmentacion']->sum('cantidad');
                    $totalIngresos = $clientes['segmentacion']->sum('ingresos');
                @endphp
                @foreach($clientes['segmentacion'] as $segmento)
                <tr>
                    <td>
                        <strong>{{ $segmento->categoria }}</strong>
                        @if($segmento->categoria == 'VIP')
                            👑
                        @elseif($segmento->categoria == 'Frecuente')
                            ⭐
                        @elseif($segmento->categoria == 'Regular')
                            👥
                        @else
                            🆕
                        @endif
                    </td>
                    <td class="text-center">{{ $segmento->cantidad }}</td>
                    <td class="text-center">
                        {{ $totalClientes > 0 ? number_format(($segmento->cantidad / $totalClientes) * 100, 1) : 0 }}%
                    </td>
                    <td class="text-right">${{ number_format($segmento->ingresos, 2) }}</td>
                    <td class="text-right">
                        ${{ $segmento->cantidad > 0 ? number_format($segmento->ingresos / $segmento->cantidad, 2) : '0.00' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Recomendaciones -->
    <div class="section">
        <div class="section-title">💡 Recomendaciones Estratégicas</div>
        <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; border-left: 5px solid #6f42c1;">
            <h4 style="color: #6f42c1; margin-bottom: 15px;">📋 Plan de Acción</h4>
            
            <div style="margin-bottom: 15px;">
                <strong>🎯 Para Clientes VIP:</strong>
                <ul style="margin-left: 20px; margin-top: 5px;">
                    <li>Implementar programa de fidelidad exclusivo</li>
                    <li>Ofrecer descuentos especiales y acceso temprano a nuevos productos</li>
                    <li>Contacto personalizado para fechas especiales</li>
                </ul>
            </div>
            
            <div style="margin-bottom: 15px;">
                <strong>⭐ Para Clientes Frecuentes:</strong>
                <ul style="margin-left: 20px; margin-top: 5px;">
                    <li>Crear programa de puntos por compras</li>
                    <li>Enviar promociones semanales</li>
                    <li>Recopilar feedback para mejorar el servicio</li>
                </ul>
            </div>
            
            <div style="margin-bottom: 15px;">
                <strong>👥 Para Clientes Regulares:</strong>
                <ul style="margin-left: 20px; margin-top: 5px;">
                    <li>Incentivar mayor frecuencia de compra</li>
                    <li>Ofrecer combos y promociones atractivas</li>
                    <li>Mejorar experiencia de servicio</li>
                </ul>
            </div>
            
            <div>
                <strong>😴 Para Clientes Inactivos:</strong>
                <ul style="margin-left: 20px; margin-top: 5px;">
                    <li>Campaña de reactivación con descuentos especiales</li>
                    <li>Encuesta para entender razones de inactividad</li>
                    <li>Ofrecer productos nuevos o mejorados</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div><strong>Quantix</strong></div>
        <div>Reporte de clientes generado el {{ now()->format('d/m/Y H:i:s') }}</div>
        <div>Sistema de Gestión Inteligente v1.0</div>
    </div>
</body>
</html>