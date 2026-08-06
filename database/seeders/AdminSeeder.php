<?php

namespace Database\Seeders;

use App\Models\AppInfo;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@helpdesk.test'],
            [
                'name' => 'Admin ARKA',
                'password' => Hash::make('password'),
                'role' => 'super_admin',
                'is_active' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'iwan@helpdesk.test'],
            [
                'name' => 'Iwan',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        // Seed default apps
        $apps = [
            ['name' => 'MineOps', 'description' => 'Sistem manajemen tambang'],
            ['name' => 'Sarang ERP', 'description' => 'Sistem ERP Sarang'],
            ['name' => 'ArkFleet', 'description' => 'Sistem manajemen armada'],
            ['name' => 'VASIA POS', 'description' => 'Sistem Point of Sale'],
            ['name' => 'Pratasaba Resort', 'description' => 'Sistem manajemen resort'],
        ];

        foreach ($apps as $app) {
            AppInfo::updateOrCreate(
                ['name' => $app['name']],
                ['description' => $app['description'], 'is_active' => true]
            );
        }
    }
}
