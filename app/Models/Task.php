<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Log;

class Task extends Model
{
  use HasFactory;

  protected $fillable = ['user_id', 'title', 'is_completed', 'end_date'];

  protected $hidden = ['created_at', 'updated_at'];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  /**
   * Mark task completion with end time
   *
   * @param [boolean] $value
   * @return void
   */
  public function setIsCompletedAttribute($value) {
    // Log::info("setIsCompletedAttribute", [$value, $this->attributes]);
    $value = (bool) $value;
    $oldValue = null;
    if (isset($this->attributes['is_completed'])) $oldValue = $this->attributes['is_completed'];
    if ($oldValue !== $value) {
      $this->attributes['is_completed'] = $value;
      if ($value) {
        $this->attributes['end_date'] = Carbon::now()->format('Y-m-d H:i:s');
      } else {
        $this->attributes['end_date'] = null;
      }
    }
  }
}