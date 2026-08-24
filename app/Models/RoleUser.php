<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model{
    protected $table = "role_user";
    protected $primaryKey = "id";

    protected $fillable = [
        'role_id', 'user_id'
    ];

    public function users() {
        return $this->belongsTo('App\Model\Users', 'id', 'user_id');
    }
    
}
