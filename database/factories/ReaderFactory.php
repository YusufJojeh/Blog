<?php


namespace Database\Factories;

use App\Models\Reader;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class ReaderFactory extends Factory
{
    protected $model = Reader::class;

    public function definition(): array
    {
        return [
            'name'          => $this->faker->name,
            'email'         => $this->faker->unique()->safeEmail,
            'password'      => Hash::make('password'),
            'profile_image' => null,
        ];
    }
}
