<?php

namespace Database\Factories;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition()
  {
    $is_completed = (bool) random_int(0, 5);
    $end_date = null;
    if ($is_completed) {
      $end_date = Carbon::now()->subWeeks(random_int(1, 20));
    }

    return [
      'user_id' => User::inRandomOrder()->first(),
      'title' => $this->faker->sentence(random_int(2, 6)),
      'is_completed' => $is_completed,
      'end_date' => $end_date,
    ];
  }
}