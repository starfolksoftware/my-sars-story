<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Auth\User;

class UsersTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $user = new User();
    $user->name = 'Selase Kove';
    $user->email = 'selase@tigereyefoundation.org';
    $user->password = Hash::make('password');
    $user->save();

    $user->assignRole('Admin');
  }
}
