<?php namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Notifications\Notifiable;
use App\Notifications\UnDoneToDo;

class Kernel extends HttpKernel
{
    use Notifiable;
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $users=User::all();
            foreach ($users as $user){
                foreach ($user->lists as $list){
                    foreach ($list->todos as $todo) {
                        if($user->reminder ==1) {
                            $end = $todo->deadline;
                            $today = date('Y-m-d H:i:s');
                            if ($today > $end)
                                $user->notify(new UnDoneToDo($todo, $user));
                        }
                    }
                }
            }
        })->hourly();
        #TODO ADD Alert Emails
    }
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        'Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode',
        'Illuminate\Cookie\Middleware\EncryptCookies',
        'Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse',
        'Illuminate\Session\Middleware\StartSession',
        'Illuminate\View\Middleware\ShareErrorsFromSession',
       // 'App\Http\Middleware\VerifyCsrfToken',
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => 'App\Http\Middleware\Authenticate',
        'auth.basic' => 'Illuminate\Auth\Middleware\AuthenticateWithBasicAuth',
        'guest' => 'App\Http\Middleware\RedirectIfAuthenticated',
    ];
}
