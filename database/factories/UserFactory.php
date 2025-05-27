<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'username' => $this->faker->unique()->userName(),
            'password' => bcrypt('123456789'),
            'gender' => 'male',
            'disability' => 'no',
            'national_id' => $this->faker->unique()->numberBetween(10000000000, 99999999999),
            'university_id' => $this->faker->unique()->numberBetween(100000000, 999999999),
            'phone' => $this->faker->unique()->phoneNumber(),
            'university' => 'korean university',
            'faculty' => 'korean university',
            'department' => 'it',
            'specialization' => 'it,software',
            'current_year' => 'fourth',
            'expected_graduation_year' => $this->faker->date(),
            'address' => $this->faker->address(),
            'birth_date' => $this->faker->dateTimeBetween('-25 years', '-18 years')->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
