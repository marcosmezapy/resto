<?php

namespace App\Livewire\Ventas;

use Livewire\Component;
use App\Models\Venta;
use App\Services\Ventas\historico\VentaService;
use App\Services\Ventas\Historico\VentaPagoService;

class VentaDetalleHistorico extends Component
{
    public $venta;
    public $monto;
    public $metodo_pago = 'efectivo';
    public $referencia;
    
    public function mount($ventaId)
    {
        $this->venta = Venta::with(['cliente','detalles.producto','pagos'])
            ->findOrFail($ventaId);
    }

    public function anular()
    {
        app(VentaService::class)->anular($this->venta->id);

        session()->flash('success','Venta anulada');

        return redirect()->route('ventas.historial.show',$this->venta->id);
    }

    public function registrarPago()
    {
        app(VentaPagoService::class)
            ->registrar(
                $this->venta->id,
                $this->monto,
                $this->metodo_pago,
                $this->referencia
            );

        session()->flash('success','Pago registrado');

        return redirect()->route('ventas.historial.show',$this->venta->id);
    }

    public function render()
    {
        return view('livewire.ventas.historico.venta-detalle');
    }
}