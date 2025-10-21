<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Pedido #{{ $pedido->id_pedido }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            line-height: 1.4;
            color: #000;
            background: #fff;
        }
        
        .ticket {
            width: 80mm;
            max-width: 300px;
            margin: 0 auto;
            padding: 10px;
        }
        
        .header {
            text-align: center;
            border-bottom: 2px dashed #000;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }
        
        .logo {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .info {
            font-size: 10px;
            margin-bottom: 2px;
        }
        
        .section {
            margin: 10px 0;
            padding: 5px 0;
        }
        
        .section-title {
            font-weight: bold;
            text-transform: uppercase;
            border-bottom: 1px solid #000;
            padding-bottom: 2px;
            margin-bottom: 5px;
        }
        
        .pedido-info {
            display: flex;
            justify-content: space-between;
            margin: 5px 0;
        }
        
        .item {
            margin: 3px 0;
            display: flex;
            justify-content: space-between;
        }
        
        .item-name {
            flex: 1;
            margin-right: 10px;
        }
        
        .item-qty {
            margin-right: 5px;
            min-width: 20px;
            text-align: center;
        }
        
        .item-price {
            min-width: 50px;
            text-align: right;
        }
        
        .total-section {
            border-top: 2px solid #000;
            padding-top: 5px;
            margin-top: 10px;
        }
        
        .total-line {
            display: flex;
            justify-content: space-between;
            margin: 2px 0;
        }
        
        .total-final {
            font-weight: bold;
            font-size: 14px;
            border-top: 1px solid #000;
            padding-top: 3px;
            margin-top: 5px;
        }
        
        .footer {
            text-align: center;
            border-top: 2px dashed #000;
            padding-top: 10px;
            margin-top: 15px;
            font-size: 10px;
        }
        
        .estado {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .estado-pendiente {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }
        
        .estado-completado {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .qr-code {
            text-align: center;
            margin: 10px 0;
        }
        
        .datetime {
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="ticket">
        <!-- Header -->
            <!-- Header -->
    <div class="header">
        <div class="logo">[LOGO]</div>
        <h1>QUANTIX</h1>
        <p>Sistema de Gestion de Ventas</p>
        <div class="contact-info">
            <div>TEL: +54 9 123 456-7890</div>
            <div>DIR: Av. Principal 123, Ciudad</div>
        </div>
    </div>

        <!-- Información del Pedido -->
        <div class="section">
            <div class="section-title">*** INFORMACION DEL PEDIDO ***</div>
            <div class="pedido-info">
                <span><strong>Pedido:</strong></span>
                <span>#{{ $pedido->id_pedido }}</span>
            </div>
            <div class="pedido-info">
                <span><strong>Fecha:</strong></span>
                <span class="datetime">{{ \Carbon\Carbon::parse($pedido->fecha_hora)->format('d/m/Y H:i') }}</span>
            </div>
            <div class="pedido-info">
                <span><strong>Estado:</strong></span>
                <span class="estado estado-{{ $pedido->estado }}">
                    @if($pedido->estado === 'pendiente')
                        [PEND] Pendiente
                    @elseif($pedido->estado === 'completado')
                        [OK] Completado
                    @else
                        [CANC] Cancelado
                    @endif
                </span>
            </div>
        </div>

        <!-- Información del Cliente -->
        @if($pedido->cliente)
        <div class="section">
            <div class="section-title">*** CLIENTE ***</div>
            <div class="pedido-info">
                <span><strong>Nombre:</strong></span>
                <span>{{ $pedido->cliente->nombre }}</span>
            </div>
            @if($pedido->cliente->telefono)
            <div class="pedido-info">
                <span><strong>Teléfono:</strong></span>
                <span>{{ $pedido->cliente->telefono }}</span>
            </div>
            @endif
        </div>
        @endif

        <!-- Detalle de Productos -->
        <div class="section">
            <div class="section-title">*** DETALLE DEL PEDIDO ***</div>
            @foreach($pedido->detallePedidos as $detalle)
            <div class="item">
                <div class="item-name">{{ $detalle->producto->nombre }}</div>
                <div class="item-qty">{{ $detalle->cantidad }}x</div>
                <div class="item-price">${{ number_format($detalle->subtotal, 2) }}</div>
            </div>
            @if($detalle->producto->categoria)
            <div style="font-size: 10px; color: #666; margin-left: 10px;">
                CAT: {{ $detalle->producto->categoria }}
            </div>
            @endif
            @endforeach
        </div>

        <!-- Total -->
        <div class="total-section">
            <div class="total-line">
                <span>Subtotal:</span>
                <span>${{ number_format($pedido->total, 2) }}</span>
            </div>
            <div class="total-line">
                <span>Descuentos:</span>
                <span>$0.00</span>
            </div>
            <div class="total-line total-final">
                <span>*** TOTAL:</span>
                <span>${{ number_format($pedido->total, 2) }}</span>
            </div>
        </div>

        <!-- Información Adicional -->
        @if($pedido->estado === 'pendiente')
        <div class="section">
            <div class="section-title">*** TIEMPO ESTIMADO ***</div>
            <div style="text-align: center; font-size: 14px; font-weight: bold;">
                15-20 minutos
            </div>
        </div>
        @endif

        <!-- QR Code Section -->
        <div class="qr-code">
            <div style="border: 2px solid #000; display: inline-block; padding: 10px;">
                <div style="font-size: 8px;">Escanea para seguir tu pedido</div>
                <div style="font-family: monospace; font-size: 6px; margin-top: 5px;">
                    ████████████████████<br>
                    ██  ████    ██  ████<br>
                    ██      ████      ██<br>
                    ████████████████████<br>
                </div>
                <div style="font-size: 8px; margin-top: 5px;">Pedido #{{ $pedido->id_pedido }}</div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div><strong>¡Gracias por tu compra!</strong></div>
            <div>Sistema Quantix - Gestion Inteligente</div>
            <div>Web: www.quantix.com</div>
            <div>Email: info@quantix.com</div>
            <div style="margin-top: 10px; font-size: 8px;">
                Ticket generado el {{ now()->format('d/m/Y H:i:s') }}
            </div>
        </div>
    </div>
</body>
</html>