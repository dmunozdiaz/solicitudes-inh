<?php

namespace App\Transformers;

use \Illuminate\Support\Collection;
use App\Models\Maestro\DatosPersonal;
use League\Fractal\TransformerAbstract;

class DatosPersonalTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];
    
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];
    
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform( $personal)
    {
       // $personal 
     //  dd($personal->nombre_completo);
        return [
                'rut-format' => number_format($personal->dpe_id_rut,0,',','.').'-'.$personal->dpe_digitove,
                'rut' => $personal->dpe_id_rut,
                'nombre-completo' => $personal->nombre_completo,
            
                'calidad-juricida' => $personal->descripcion_calidad_juridica,
                'sexo' => $personal->descripcion_sexo,
    
            ];
    }
}
