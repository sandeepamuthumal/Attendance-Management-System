<?php

namespace Database\Seeders;

use App\Repositories\UserRepository;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function run(): void {
        $this->userRepository->create([
            'user_types_id' => 1,
            'first_name' => 'System',
            'last_name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => 'admin123',
            'status' => 1
        ]);
    }
}
