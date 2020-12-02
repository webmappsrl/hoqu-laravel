<?php

namespace Database\Factories;

use App\Models\DuplicateTask;
use App\Models\Task;

use Illuminate\Database\Eloquent\Factories\Factory;

class DuplicateTaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = duplicateTask::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $n=rand(-1,-10);
        $date = $this->faker->dateTimeBetween($startDate = $n.' day', $endDate = 'now');
        return [
                'task_id' => Task::factory()->create(),
                'created_at'=> $date,
                'updated_at'=>$date
        ];
    }
}
