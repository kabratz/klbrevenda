<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Karoline Luersen Bratz',
            'email' => 'karolinebratz@outlook.com',
            'password' => Hash::make('teste123'), 
        ]);
    }
}
