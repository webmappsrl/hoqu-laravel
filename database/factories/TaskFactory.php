<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;


class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // $mutable = Carbon::now();
        $date = $this->faker->dateTimeBetween($startDate = '-1 day', $endDate = 'now');

        return [
            'id_server'=>$this->faker->numberBetween(1,10),
            'instance' => $this->faker->sentence(1),
            'job' => $this->faker->sentence(1),
            'parameters' => json_encode(["mtpupdate" => $this->faker->numberBetween(1,100)]),
            'process_status' => 'new',
            'process_log'=>'',
            'created_at'=> $date,
            'updated_at'=>$date
        ];
    }

    public function suspended()
    {
        return $this->state([
            'process_status' => 'processing',
            'created_at'=> $this->faker->dateTimeBetween($startDate = '-2 day', $endDate = 'now'),
            'updated_at'=> $this->faker->dateTimeBetween($startDate = '-1 day', $endDate = 'now'),
        ]);
    }


}
