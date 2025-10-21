<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo de Pago #{{ $pedido->id_pedido }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            background: #fff;
        }
        
        .recibo {
            max-width: 210mm;
            margin: 0 auto;
            padding: 20mm;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 3px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .logo-section {
            flex: 1;
        }
        
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 5px;
        }
        
        .empresa-info {
            font-size: 11px;
            color: #666;
        }
        
        .recibo-info {
            text-align: right;
            flex: 1;
        }
        
        .recibo-numero {
            font-size: 20px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 5px;
        }
        
        .fecha-emision {
            font-size: 11px;
            color: #666;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin: 30px 0;
        }
        
        .info-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #007bff;
        }
        
        .info-title {
            font-weight: bold;
            font-size: 14px;
            color: #007bff;
            margin-bottom: 15px;
            text-transform: uppercase;
        }
        
        .info-item {
            margin: 8px 0;
            display: flex;
            justify-content: space-between;
        }
        
        .info-label {
            font-weight: bold;
            color: #555;
        }
        
        .info-value {
            color: #333;
        }
        
        .detalle-table {
            width: 100%;
            border-collapse: collapse;
            margin: 30px 0;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .detalle-table th {
            background: #007bff;
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 11px;
        }
        
        .detalle-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
        }
        
        .detalle-table tr:hover {
            background: #f8f9fa;
        }
        
        .producto-name {
            font-weight: bold;
            color: #333;
        }
        
        .producto-categoria {
            font-size: 10px;
            color: #666;
            font-style: italic;
        }
        
        .cantidad {
            text-align: center;
            font-weight: bold;
            color: #007bff;
        }
        
        .precio {
            text-align: right;
            font-weight: bold;
        }
        
        .totales {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 30px 0;
            border: 2px solid #007bff;
        }
        
        .total-line {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
            padding: 5px 0;
        }
        
        .total-final {
            border-top: 2px solid #007bff;
            padding-top: 15px;
            margin-top: 15px;
            font-size: 18px;
            font-weight: bold;
            color: #007bff;
        }
        
        .pago-info {
            background: #e8f5e8;
            border: 2px solid #28a745;
            border-radius: 8px;
            padding: 20px;
            margin: 30px 0;
            text-align: center;
        }
        
        .pago-estado {
            font-size: 20px;
            font-weight: bold;
            color: #28a745;
            margin-bottom: 10px;
        }
        
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 11px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        
        .firma {
            margin: 40px 0;
            text-align: center;
        }
        
        .firma-line {
            border-top: 2px solid #333;
            width: 300px;
            margin: 30px auto 10px;
        }
        
        .sello {
            float: right;
            width: 150px;
            height: 150px;
            border: 2px dashed #ccc;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            color: #999;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="recibo">
        <!-- Header -->
        <div class="header">
            <div class="logo-section">
                <div class="logo">QUANTIX</div>
                <div class="empresa-info">
                    <div><strong>CUIT:</strong> 20-12345678-9</div>
                    <div><strong>Dirección:</strong> Av. Principal 123, Ciudad</div>
                    <div><strong>Teléfono:</strong> +54 9 123 456-7890</div>
                    <div><strong>Email:</strong> info@quantix.com</div>
                </div>
            </div>
            <div class="recibo-info">
                <div class="recibo-numero">RECIBO #{{ str_pad($pedido->id_pedido, 6, '0', STR_PAD_LEFT) }}</div>
                <div class="fecha-emision">
                    <strong>Fecha de Emisión:</strong><br>
                    {{ now()->format('d/m/Y H:i:s') }}
                </div>
            </div>
        </div>

        <!-- Información del Pedido y Cliente -->
        <div class="info-grid">
            <div class="info-section">
                <div class="info-title">*** INFORMACION DEL PEDIDO ***</div>
                <div class="info-item">
                    <span class="info-label">Número de Pedido:</span>
                    <span class="info-value">#{{ $pedido->id_pedido }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Fecha del Pedido:</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($pedido->fecha_hora)->format('d/m/Y H:i') }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Estado:</span>
                    <span class="info-value">
                        <strong style="color: #28a745;">[OK] COMPLETADO</strong>
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Método de Pago:</span>
                    <span class="info-value">Efectivo</span>
                </div>
            </div>

            @if($pedido->cliente)
            <div class="info-section">
                <div class="info-title">*** DATOS DEL CLIENTE ***</div>
                <div class="info-item">
                    <span class="info-label">Nombre:</span>
                    <span class="info-value">{{ $pedido->cliente->nombre }}</span>
                </div>
                @if($pedido->cliente->telefono)
                <div class="info-item">
                    <span class="info-label">Teléfono:</span>
                    <span class="info-value">{{ $pedido->cliente->telefono }}</span>
                </div>
                @endif
                @if($pedido->cliente->correo)
                <div class="info-item">
                    <span class="info-label">Email:</span>
                    <span class="info-value">{{ $pedido->cliente->correo }}</span>
                </div>
                @endif
                <div class="info-item">
                    <span class="info-label">Tipo Cliente:</span>
                    <span class="info-value">
                        @if($pedido->cliente->pedidos_count > 10)
                            [VIP] Cliente VIP
                        @elseif($pedido->cliente->pedidos_count > 5)
                            [FREC] Cliente Frecuente
                        @else
                            [NUEVO] Cliente Nuevo
                        @endif
                    </span>
                </div>
            </div>
            @endif
        </div>

        <!-- Detalle de Productos -->
        <table class="detalle-table">
            <thead>
                <tr>
                    <th style="width: 50%;">Producto</th>
                    <th style="width: 15%; text-align: center;">Cantidad</th>
                    <th style="width: 15%; text-align: right;">Precio Unit.</th>
                    <th style="width: 20%; text-align: right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pedido->detallePedidos as $detalle)
                <tr>
                    <td>
                        <div class="producto-name">{{ $detalle->producto->nombre }}</div>
                        @if($detalle->producto->categoria)
                        <div class="producto-categoria">CAT: {{ $detalle->producto->categoria }}</div>
                        @endif
                    </td>
                    <td class="cantidad">{{ $detalle->cantidad }}</td>
                    <td class="precio">${{ number_format($detalle->precio_unitario, 2) }}</td>
                    <td class="precio">${{ number_format($detalle->subtotal, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totales -->
        <div class="totales">
            <div class="total-line">
                <span>Subtotal:</span>
                <span>${{ number_format($pedido->total, 2) }}</span>
            </div>
            <div class="total-line">
                <span>Descuentos:</span>
                <span>$0.00</span>
            </div>
            <div class="total-line">
                <span>IVA (21%):</span>
                <span>${{ number_format($pedido->total * 0.21, 2) }}</span>
            </div>
            <div class="total-line total-final">
                <span>*** TOTAL PAGADO ***</span>
                <span>${{ number_format($pedido->total * 1.21, 2) }}</span>
            </div>
        </div>

        <!-- Estado de Pago -->
        <div class="pago-info">
            <div class="pago-estado">[OK] PAGO COMPLETADO</div>
            <div>Recibido el {{ \Carbon\Carbon::parse($pedido->updated_at)->format('d/m/Y H:i') }}</div>
            <div style="margin-top: 10px; font-weight: bold;">Gracias por su pago puntual</div>
        </div>

        <!-- Sello y Firma -->
        <div style="display: flex; justify-content: space-between; align-items: flex-end;">
            <div class="firma">
                <div class="firma-line"></div>
                <div><strong>Firma y Sello del Establecimiento</strong></div>
            </div>
            <div class="sello">
                <div>
                    SELLO<br>
                    ESTABLECIMIENTO<br>
                    <small>{{ now()->format('d/m/Y') }}</small>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div><strong>¡Gracias por elegirnos!</strong></div>
            <div>Este recibo es valido como comprobante fiscal</div>
            <div>Para consultas: info@quantix.com | +54 9 123 456-7890</div>
            <div style="margin-top: 15px;">
                <strong>Sistema Quantix - Gestion Inteligente de Ventas</strong><br>
                Web: www.quantix.com | Email: info@quantix.com
            </div>
            <div style="margin-top: 20px; font-size: 10px; color: #999;">
                Documento generado automáticamente el {{ now()->format('d/m/Y H:i:s') }}
            </div>
        </div>
    </div>
</body>
</html>