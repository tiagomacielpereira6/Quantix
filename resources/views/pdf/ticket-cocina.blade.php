<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Cocina - Pedido #{{ $pedido->id_pedido }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Courier New', monospace;
            font-size: 14px;
            line-height: 1.3;
            color: #000;
            background: #fff;
        }
        
        .ticket-cocina {
            width: 80mm;
            max-width: 300px;
            margin: 0 auto;
            padding: 10px;
        }
        
        .header {
            text-align: center;
            background: #000;
            color: #fff;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
        
        .titulo {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .subtitulo {
            font-size: 12px;
            opacity: 0.9;
        }
        
        .pedido-header {
            background: #f0f0f0;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            border: 2px solid #333;
        }
        
        .pedido-numero {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 5px;
        }
        
        .pedido-info {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            margin: 3px 0;
        }
        
        .cliente-info {
            background: #e8f4f8;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            border-left: 4px solid #007bff;
        }
        
        .cliente-nombre {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .productos {
            margin: 15px 0;
        }
        
        .producto-item {
            background: #fff;
            border: 2px solid #333;
            border-radius: 8px;
            padding: 12px;
            margin: 10px 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .producto-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 8px;
        }
        
        .producto-nombre {
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }
        
        .producto-cantidad {
            background: #007bff;
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 14px;
        }
        
        .producto-categoria {
            font-size: 11px;
            color: #666;
            font-style: italic;
            margin-bottom: 5px;
        }
        
        .producto-precio {
            font-size: 12px;
            color: #007bff;
            font-weight: bold;
        }
        
        .notas-especiales {
            background: #fff3cd;
            border: 2px solid #ffc107;
            border-radius: 5px;
            padding: 10px;
            margin: 15px 0;
        }
        
        .notas-titulo {
            font-weight: bold;
            color: #856404;
            margin-bottom: 5px;
        }
        
        .tiempo-estimado {
            background: #28a745;
            color: white;
            text-align: center;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
            font-weight: bold;
        }
        
        .tiempo-numero {
            font-size: 24px;
            margin-bottom: 5px;
        }
        
        .prioridad {
            text-align: center;
            margin: 15px 0;
        }
        
        .prioridad-alta {
            background: #dc3545;
            color: white;
            padding: 10px;
            border-radius: 5px;
            font-weight: bold;
            animation: parpadeo 1s infinite;
        }
        
        .prioridad-normal {
            background: #6c757d;
            color: white;
            padding: 8px;
            border-radius: 5px;
        }
        
        @keyframes parpadeo {
            0%, 50% { opacity: 1; }
            51%, 100% { opacity: 0.5; }
        }
        
        .footer {
            border-top: 2px dashed #000;
            padding-top: 10px;
            margin-top: 20px;
            text-align: center;
            font-size: 11px;
        }
        
        .hora-impresion {
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .instrucciones {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 10px;
            margin: 15px 0;
            font-size: 11px;
        }
        
        .checkbox {
            display: inline-block;
            width: 15px;
            height: 15px;
            border: 2px solid #333;
            margin-right: 8px;
            vertical-align: middle;
        }
        
        .checklist {
            margin: 15px 0;
        }
        
        .checklist-item {
            margin: 8px 0;
            display: flex;
            align-items: center;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="ticket-cocina">
    <!-- Header -->
    <div class="header">
        <h1>*** TICKET DE COCINA ***</h1>
        <div class="restaurant-name">Quantix</div>
    </div>        <!-- Información del Pedido -->
        <div class="pedido-header">
            <div class="pedido-numero">PEDIDO #{{ $pedido->id_pedido }}</div>
            <div class="pedido-info">
                <span><strong>Hora:</strong></span>
                <span>{{ \Carbon\Carbon::parse($pedido->fecha_hora)->format('H:i') }}</span>
            </div>
            <div class="pedido-info">
                <span><strong>Mesa/Cliente:</strong></span>
                <span>{{ $pedido->cliente->nombre ?? 'Cliente General' }}</span>
            </div>
        </div>

        <!-- Información del Cliente -->
        @if($pedido->cliente && $pedido->cliente->telefono)
        <div class="cliente-info">
            <div class="cliente-nombre">TEL: {{ $pedido->cliente->telefono }}</div>
            <div style="font-size: 12px;">Para contacto si hay consultas</div>
        </div>
        @endif

        <!-- Prioridad -->
        @php
            $totalItems = $pedido->detallePedidos->sum('cantidad');
            $prioridadAlta = $totalItems > 5 || \Carbon\Carbon::parse($pedido->fecha_hora)->diffInMinutes(now()) > 30;
        @endphp
        
        <div class="prioridad">
            @if($prioridadAlta)
            <div class="prioridad-alta">
                *** PRIORIDAD ALTA ***<br>
                <small>Pedido urgente o con muchos items</small>
            </div>
            @else
            <div class="prioridad-normal">
                Prioridad Normal
            </div>
            @endif
        </div>

        <!-- Productos a Preparar -->
        <div class="productos">
            @foreach($pedido->detallePedidos as $detalle)
            <div class="producto-item">
                <div class="producto-header">
                    <div class="producto-nombre">{{ $detalle->producto->nombre }}</div>
                    <div class="producto-cantidad">{{ $detalle->cantidad }}x</div>
                </div>
                
                @if($detalle->producto->categoria)
                <div class="producto-categoria">CAT: {{ $detalle->producto->categoria }}</div>
                @endif
                
                <div class="producto-precio">PRECIO: ${{ number_format($detalle->subtotal, 2) }}</div>
                
                <!-- Checkbox para marcar como listo -->
                <div style="margin-top: 10px; border-top: 1px dashed #ccc; padding-top: 8px;">
                    <label style="display: flex; align-items: center; font-size: 11px;">
                        <span class="checkbox"></span>
                        <strong>[OK] LISTO PARA SERVIR</strong>
                    </label>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Notas Especiales -->
        <div class="notas-especiales">
            <div class="notas-titulo">*** NOTAS IMPORTANTES ***</div>
            <div>• Verificar temperatura de productos calientes</div>
            <div>• Revisar presentación antes de entregar</div>
            <div>• Confirmar que estén todos los items</div>
        </div>

        <!-- Tiempo Estimado -->
        <div class="tiempo-estimado">
            <div class="tiempo-numero">TIEMPO: 15-20 MIN</div>
            <div>Tiempo estimado de preparacion</div>
        </div>

        <!-- Checklist de Preparación -->
        <div class="checklist">
            <div style="font-weight: bold; margin-bottom: 10px; text-align: center;">
                *** CHECKLIST DE PREPARACION ***
            </div>
            <div class="checklist-item">
                <span class="checkbox"></span>
                <span>Todos los ingredientes listos</span>
            </div>
            <div class="checklist-item">
                <span class="checkbox"></span>
                <span>Productos cocidos correctamente</span>
            </div>
            <div class="checklist-item">
                <span class="checkbox"></span>
                <span>Temperatura adecuada</span>
            </div>
            <div class="checklist-item">
                <span class="checkbox"></span>
                <span>Presentación correcta</span>
            </div>
            <div class="checklist-item">
                <span class="checkbox"></span>
                <span>Pedido completo</span>
            </div>
        </div>

        <!-- Instrucciones -->
        <div class="instrucciones">
            <div style="font-weight: bold; margin-bottom: 5px;">*** INSTRUCCIONES ***</div>
            <div>1. Marcar cada item cuando esté listo</div>
            <div>2. Avisar cuando todo esté preparado</div>
            <div>3. Mantener temperatura hasta entrega</div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="hora-impresion">
                IMPRESO: {{ now()->format('d/m/Y H:i:s') }}
            </div>
            <div>Cocinero: ________________</div>
            <div style="margin-top: 10px; font-size: 10px;">
                Sistema Quantix - Gestion Inteligente
            </div>
        </div>
    </div>
</body>
</html>