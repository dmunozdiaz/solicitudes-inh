<?php

namespace App\Exports;


use Throwable;
use App\Models\ReporteEspecial;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReporteespecialExport implements FromView, ShouldQueue
{
    use Exportable;

    private $reporte;

    public function __construct(ReporteEspecial $reporte) 
    {
        $this->reporte = $reporte;
    }

    public function view(): View
    {
        
       $data = $this->reporte->getReporte($this->reporte->user_id,$this->reporte->area,$this->reporte->solicitud,$this->reporte->anio,$this->reporte->estado);

        $this->reporte->estadoreporte = 3;
        $this->reporte->save();
        return view('exports.reporteespecial', [
            'datos' =>  $data
        ]);
    }

    public function failed(Throwable $exception): void
    {
       
        $this->reporte->estadoreporte = 2;
        $this->reporte->save();
    }   
}