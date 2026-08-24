<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipSolicitudes extends Model{
    protected $table = 'tipsolicitudes';

    use SoftDeletes;

    public function getDirecciones(){
        return TipSolicitudes::select('direccion')->groupBy('direccion')->orderBy('direccion')->get();
    }

    public function getAreas(){
        return TipSolicitudes::select('area')->groupBy('area')->orderBy('area')->get();
    }
}

