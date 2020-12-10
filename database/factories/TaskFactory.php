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
        $n=rand(-1,-10);
        $date = $this->faker->dateTimeBetween($startDate = $n.' day', $endDate = 'now');

        return [
            'instance' => 'test.cyclando.com',
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
        $n=rand(-8,-10);
        $n1 = rand(0,-2);
        return $this->state([
            'instance' => 'test.cyclando.com',
            'process_status' => 'processing',
            'created_at'=> $this->faker->dateTimeBetween($startDate = $n .' day', $endDate = 'now'),
            'updated_at'=> $this->faker->dateTimeBetween($startDate = $n1 .' day', $endDate = 'now'),
        ]);
    }

    public function duplicated()
    {
        $n=rand(-8,-10);
        $n1 = rand(0,-2);
        return $this->state([
            'process_status' => 'duplicate',
            'created_at'=> $this->faker->dateTimeBetween($startDate = $n .' day', $endDate = 'now'),
            'updated_at'=> $this->faker->dateTimeBetween($startDate = $n1 .' day', $endDate = 'now'),
        ]);
    }

    public function create_done()
    {
        $n=rand(-8,-22);
        $n1 = rand(0,-3);
        return $this->state([
            'instance' => 'test.cyclando.com',
            'process_status' => 'done',
            'process_log' => '',
            'created_at'=> $this->faker->dateTimeBetween($startDate = $n .' day', $endDate = 'now'),
                        'updated_at'=> $this->faker->dateTimeBetween($startDate = $n1 .' day', $endDate = 'now'),

        ]);
    }
    public function create_error()
    {
        $n=rand(-8,-10);
        $n1 = rand(0,-3);
        return $this->state([
            'instance' => 'test.cyclando.com',
            'process_status' => 'error',
            'process_log' => 'The track 162 is missing the geometry and is unreachable or the poi with id 2725 does not exists',
            'created_at'=> $this->faker->dateTimeBetween($startDate = $n .' day', $endDate = 'now +1'),
                        'updated_at'=> $this->faker->dateTimeBetween($startDate = $n1 .' day', $endDate = 'now'),

        ]);
    }


}
