<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence(rand(5, 7));
        $datetime = $this->faker->dateTimeBetween('-1 month', 'now');

        $description = '';
        for($i=0; $i < 5; $i++) {
            $description .= '<p class="mb-4">' . $this->faker->sentences(rand(5, 10), true) . '</p>';
        }

        return [
            'title' => $title,
            'description' => $description,
            'image' => basename($this->faker->image(storage_path('app/public'))),
            'user_id' => 1,
            'created_at' => $datetime,
            'updated_at' => $datetime
        ];
    }
}
