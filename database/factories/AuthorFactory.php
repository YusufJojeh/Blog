<?php
namespace Database\Factories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class AuthorFactory extends Factory {
    protected $model = Author::class;

    public function definition(): array {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make( 'password' ),
            'bio' => $this->faker->sentence,
            'profile_image' => null,
        ];
    }
}
