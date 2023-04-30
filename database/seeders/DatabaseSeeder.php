<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Task;
use App\Models\User;
use Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    // \App\Models\User::factory(10)->create();

    $admin = User::factory()->create([
      'email' => 'admin@mail.ru',
      'name' => 'admin',
      'password' => Hash::make('123456'),
    ]);

    Task::factory(100)->create(['user_id' => $admin->id]);
  }
}