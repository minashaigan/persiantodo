<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class AuthController extends Controller
{
    /**
     * View Home Page.
     *
     * @return \Illuminate\View\View
     */
    public function home()
    {
        $storage = Redis::Connection();
        $popular = $storage->zRevRange('listViews', 0, 0);

        foreach ($popular as $value){
            $id = str_replace('list:', '', $value);
            return app('App\Http\Controllers\ListController')->show($id);
            //echo "list " . $id . "is popular" . "<br>";
        }
        //name of zIncrBy , index you want to start
        //return view('home');
    }

    /**
     * Show Login Form.
     *
     * @return \Illuminate\View\View
     */
    public function getLogin()
    {
        return view('auth.login');
    }

    /**
     * Do Login.
     *
     * @param LoginRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postLogin(LoginRequest $request)
    {
        if (Auth::attempt([
            'email'    => $request->get('email'),
            'password' => $request->get('password'),
        ], $request->get('remember'))) {
            return redirect()
                ->intended('/list')
                ->with('flash_notification.message', 'Logged in successfully')
                ->with('flash_notification.level', 'success');
        }

        return redirect()
            ->back()
            ->withInput()
            ->with('flash_notification.message', 'Wrong email or password')
            ->with('flash_notification.level', 'danger');
    }

    /**
     * Logout.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::logout();

        return redirect('/')
            ->with('flash_notification.message', 'Logged out successfully')
            ->with('flash_notification.level', 'success');
    }
}
