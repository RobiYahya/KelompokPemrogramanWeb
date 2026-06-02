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
     * Disesuaikan dengan skema tabel users kustom:
     * kolom: nama, email, id_pegawai, role, password
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama'       => fake()->name(),
            'email'      => fake()->unique()->safeEmail(),
            'id_pegawai' => strtoupper(fake()->unique()->bothify('EMP-####')),
            'role'       => fake()->randomElement(['admin', 'manager']),
            'password'   => static::$password ??= Hash::make('password'),
        ];
    }

    /**
     * Factory untuk role admin.
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
        ]);
    }

    /**
     * Factory untuk role manager.
     */
    public function manager(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'manager',
        ]);
    }
}
