<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use ConsoleTVs\Charts\Registrar as Charts;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Charts $charts)
    {
        $charts->register([
            \App\Charts\SampleChart::class
        ]);

//        Blade::directive('br2nl', function ($string) {
/*            return "<?php echo nl2br ($string); ?>";*/
//        });


    }
}
