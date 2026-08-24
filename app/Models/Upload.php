<?php

// Upload.php

namespace App\Models;

use App\Models\UserPublic;
use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{

  protected $table = 'upload';
  protected $fillable = [
    'filename'
  ];

    public function user()
    {
      return $this->belongsTo(UserPublic::class);
    }
}