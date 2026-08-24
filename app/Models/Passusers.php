<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Passusers extends Model {
    protected $table = "passusers";

    protected $fillable = [
        'password', 'uid'
    ];

    public function users() {
        return $this->belongsTo('App\Model\Users', 'id', 'uid');
    }

}
