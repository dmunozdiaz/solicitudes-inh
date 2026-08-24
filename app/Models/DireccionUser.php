<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class DireccionUser extends Model{
    protected $table = "direccion_user";
    protected $primaryKey = "id";

    protected $fillable = [
        'direccion_id', 'user_id'
    ];

    public function users() {
        
        return $this->belongsTo('App\Models\User', 'id', 'user_id');
    }

    
}
