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
        $n=rand(-8,-10);
        $n1 = rand(0,-2);
        return $this->state([
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
            'process_status' => 'error',
            'process_log' => '[2020-09-24 10:17:47] production.ERROR: require(/home/forge/hoqustaging.webmapp.it/vendor/laravel/jetstream/src/../routes/.php): failed to open stream: No such file or directory {"exception":"[object] (ErrorException(code: 0): require(/home/forge/hoqustaging.webmapp.it/vendor/laravel/jetstream/src/../routes/.php): failed to open stream: No such file or directory at /home/forge/hoqustaging.webmapp.it/vendor/laravel/framework/src/Illuminate/Support/ServiceProvider.php:144)
                [stacktrace]
                #0 /home/forge/hoqustaging.webmapp.it/vendor/laravel/framework/src/Illuminate/Support/ServiceProvider.php(144): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError()
                #1 /home/forge/hoqustaging.webmapp.it/vendor/laravel/framework/src/Illuminate/Support/ServiceProvider.php(144): require()
                #2 /home/forge/hoqustaging.webmapp.it/vendor/laravel/jetstream/src/JetstreamServiceProvider.php(175): Illuminate\\Support\\ServiceProvider->loadRoutesFrom()
                #3 /home/forge/hoqustaging.webmapp.it/vendor/laravel/framework/src/Illuminate/Routing/Router.php(421): Laravel\\Jetstream\\JetstreamServiceProvider->Laravel\\Jetstream\\{closure}()
                #4 /home/forge/hoqustaging.webmapp.it/vendor/laravel/framework/src/Illuminate/Routing/Router.php(380): Illuminate\\Routing\\Router->loadRoutes()
                #5 /home/forge/hoqustaging.webmapp.it/vendor/laravel/framework/src/Illuminate/Support/Facades/Facade.php(261): Illuminate\\Routing\\Router->group()
                #6 /home/forge/hoqustaging.webmapp.it/vendor/laravel/jetstream/src/JetstreamServiceProvider.php(176): Illuminate\\Support\\Facades\\Facade::__callStatic()
                #7 /home/forge/hoqustaging.webmapp.it/vendor/laravel/jetstream/src/JetstreamServiceProvider.php(73): Laravel\\Jetstream\\JetstreamServiceProvider->configureRoutes()
                #8 [internal function]: Laravel\\Jetstream\\JetstreamServiceProvider->boot()
                #9 /home/forge/hoqustaging.webmapp.it/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(37): call_user_func_array()
                #10 /home/forge/hoqustaging.webmapp.it/vendor/laravel/framework/src/Illuminate/Container/Util.php(40): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()
                #11 /home/forge/hoqustaging.webmapp.it/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(95): Illuminate\\Container\\Util::unwrapIfClosure()
                #12 /home/forge/hoqustaging.webmapp.it/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(39): Illuminate\\Container\\BoundMethod::callBoundMethod()
                #13 /home/forge/hoqustaging.webmapp.it/vendor/laravel/framework/src/Illuminate/Container/Container.php(596): Illuminate\\Container\\BoundMethod::call()
                #14 /home/forge/hoqustaging.webmapp.it/vendor/laravel/framework/src/Illuminate/Foundation/Application.php(869): Illuminate\\Container\\Container->call()
                #15 /home/forge/hoqustaging.webmapp.it/vendor/laravel/framework/src/Illuminate/Foundation/Application.php(850): Illuminate\\Foundation\\Application->bootProvider()
                #16 [internal function]: Illuminate\\Foundation\\Application->Illuminate\\Foundation\\{closure}()
                #17 /home/forge/hoqustaging.webmapp.it/vendor/laravel/framework/src/Illuminate/Foundation/Application.php(851): array_walk()
                #18 /home/forge/hoqustaging.webmapp.it/vendor/laravel/framework/src/Illuminate/Foundation/Bootstrap/BootProviders.php(17): Illuminate\\Foundation\\Application->boot()
                #19 /home/forge/hoqustaging.webmapp.it/vendor/laravel/framework/src/Illuminate/Foundation/Application.php(230): Illuminate\\Foundation\\Bootstrap\\BootProviders->bootstrap()
                #20 /home/forge/hoqustaging.webmapp.it/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(310): Illuminate\\Foundation\\Application->bootstrapWith()
                #21 /home/forge/hoqustaging.webmapp.it/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(127): Illuminate\\Foundation\\Console\\Kernel->bootstrap()
                #22 /home/forge/hoqustaging.webmapp.it/artisan(37): Illuminate\\Foundation\\Console\\Kernel->handle()
                #23 {main}',
            'created_at'=> $this->faker->dateTimeBetween($startDate = $n .' day', $endDate = 'now +1'),
                        'updated_at'=> $this->faker->dateTimeBetween($startDate = $n1 .' day', $endDate = 'now'),

        ]);
    }


}
