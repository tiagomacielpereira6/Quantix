<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;
use PDF;
use Carbon\Carbon;

class TicketController extends Controller
{
    /**
     * Generar ticket de pedido en PDF
     */
    public function generarTicketPedido($id)
    {
        $pedido = Pedido::with(['cliente', 'detallePedidos.producto'])
                       ->findOrFail($id);

        $pdf = PDF::loadView('pdf.ticket-pedido', compact('pedido'));
        
        $nombreArchivo = "ticket-pedido-{$pedido->id_pedido}.pdf";
        
        return $pdf->download($nombreArchivo);
    }

    /**
     * Imprimir ticket (mostrar en nueva ventana)
     */
    public function imprimirTicketPedido($id)
    {
        $pedido = Pedido::with(['cliente', 'detallePedidos.producto'])
                       ->findOrFail($id);

        $pdf = PDF::loadView('pdf.ticket-pedido', compact('pedido'));
        
        return $pdf->stream("ticket-pedido-{$pedido->id_pedido}.pdf");
    }

    /**
     * Generar recibo de pago
     */
    public function generarReciboPago($id)
    {
        $pedido = Pedido::with(['cliente', 'detallePedidos.producto'])
                       ->where('estado', 'completado')
                       ->findOrFail($id);

        $pdf = PDF::loadView('pdf.recibo-pago', compact('pedido'));
        
        $nombreArchivo = "recibo-{$pedido->id_pedido}.pdf";
        
        return $pdf->download($nombreArchivo);
    }

    /**
     * Generar ticket de cocina (solo productos)
     */
    public function generarTicketCocina($id)
    {
        $pedido = Pedido::with(['cliente', 'detallePedidos.producto'])
                       ->where('estado', 'pendiente')
                       ->findOrFail($id);

        $pdf = PDF::loadView('pdf.ticket-cocina', compact('pedido'));
        
        return $pdf->stream("cocina-pedido-{$pedido->id_pedido}.pdf");
    }
}
