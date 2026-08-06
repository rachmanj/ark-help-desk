<?php

namespace Database\Factories;

use App\Models\AppInfo;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppInfoFactory extends Factory
{
    protected $model = AppInfo::class;

    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'description' => fake()->sentence(),
            'is_active' => true,
        ];
    }
}
