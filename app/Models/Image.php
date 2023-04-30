<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
  use HasFactory;

  protected $fillable = ['user_id', 'name', 'mime_type', 'path'];

  protected $hidden = ['created_at', 'updated_at'];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function avatarOwner()
  {
    return $this->hasOne(User::class);
  }
}