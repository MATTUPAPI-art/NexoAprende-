<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
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
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'role' => 'tutor',
        ];
    }

    /**
     * Crear explícitamente un usuario tutor.
     */
    public function tutor(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'tutor',
        ]);
    }

    /**
     * Crear explícitamente un usuario profesional.
     */
    public function professional(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'professional',
        ]);
    }

    /**
     * Indicar que el correo no está verificado.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
