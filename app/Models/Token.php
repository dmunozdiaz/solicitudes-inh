<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Token extends Model{
    protected $table = 'token';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';
}
