<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FormField>
 */
class FormFieldFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = $this->faker->randomElement(['text', 'email', 'number', 'select']);
        $options = null;
        if ($type === 'select') {
            $options = json_encode(['Option 1', 'Option 2', 'Option 3']);
        }

        return [
            'label' => $this->faker->word,
            'name' => $this->faker->word,
            'type' => $type,
            'options' => $options,
        ];
    }
}
