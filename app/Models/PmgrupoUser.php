<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class PmgrupoUser extends Model{
    protected $table = "pmgrupo_user";
    protected $primaryKey = "id";

    protected $fillable = [
        'pmgrupo_id', 'user_id'
    ];

    public function users() {
        
        return $this->belongsTo('App\Models\User', 'id', 'user_id');
    }

    
}
