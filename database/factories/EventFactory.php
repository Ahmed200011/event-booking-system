<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'event_name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(5),
            'category' => $this->faker->word(),
            'date' => $this->faker->dateTimeBetween('+1 week', '+1 month'),
            'location' => $this->faker->address(),
            'price' => $this->faker->randomFloat(2, 10, 100),
            'image' => $this->faker->imageUrl(640, 480, 'events', true),
            'status' => $this->faker->randomElement(['0', '1']), // '0' for inactive, '1' for active
            // 'created_at' => now(),
            // 'updated_at' => now(),
            //
        ];
    }
}
