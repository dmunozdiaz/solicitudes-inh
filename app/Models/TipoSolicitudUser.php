<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class TipoSolicitudUser extends Model{
    protected $table = "tiposolicitud_user";
    protected $primaryKey = "id";

    protected $fillable = [
        'tiposolicitud_id', 'user_id'
    ];

    public function users() {
        return $this->belongsTo('App\Model\Users', 'id', 'user_id');
    }
    
}
