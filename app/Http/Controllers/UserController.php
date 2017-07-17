<?php namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class UserController extends Controller
{
    /**
     * Constructor method
     */
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['edit', 'update']]);
    }

    /**
     * Show User Registration Form
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Register User
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request)
    {
        if($request->get('reminder')==''){
            $reminder = 0;
        }
        else{
            $reminder = 1;
        }
        User::create([
            'name'      => $request->get('name'),
            'email'     => $request->get('email'),
            'password'  => bcrypt($request->get('password')),
            'reminder'  => boolval($reminder),
        ]);
        $condition=['email'=> $request->get('email')];
        $user=User::where($condition)->first();
        $api_code=str_random(60);
        $user=User::find($user->id);
        $user->api_token = $api_code;
        $user->password =  bcrypt($request->get('password'));
        try{
            $user->save();
        }
        catch ( \Illuminate\Database\QueryException $e){
            return response()->json(['data' => [], 'result' => 0, 'description' => 'failed to save user', 'message' => 'Token Not Created']);
        }
        return response()->json(['data' => [], 'result' => 1, 'description' => 'success to save user', 'message' => ['flash_notification.message'=>'User registered successfully','flash_notification.level'=> 'success']]);
        //return response()->json([['flash_notification.message', 'User registered successfully'],['flash_notification.level', 'success']]);
//        return redirect('login')
//            ->with('flash_notification.message', 'User registered successfully')
//            ->with('flash_notification.level', 'success');
    }

    /**
     * Show User Profile
     *
     * @param User $user
     * @return \Illuminate\View\View
     */
    public function edit(User $user)
    {
//        //return response()->json(['user'=>$user]);
//        return view('users.profile', compact('user'));
        $input = Input::all();
        $n = Input::get('api_token');
        $apiuser = User::where('api_token', $n)->first();
        if ($apiuser->id == $user) {
            $this->validate($input, [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'confirmed'
            ]);

            $user->name = $input['name'];
            $user->email = $input['email'];
            if ($input['password'] !== '') {
                $user->password = $input['password'];
            }
            $user->save();
            return response()->json(['data' => [], 'result' => 1, 'description' => 'success to update user', 'message' => ['flash_notification.message'=>'Profile updated successfully','flash_notification.level'=>'success']]);
//            return redirect('/list')
//                ->with('flash_notification.message', 'Profile updated successfully')
//                ->with('flash_notification.level', 'success');
        } else {
            return response()->json(['data' => [], 'result' => 1, 'description' => 'failed to update user', 'message' => ['flash_notification.message'=>'Profile updated failedly','flash_notification.level'=>'danger']]);
        }
    }

    /**
     * Update User Profile
     *
     * @param User $user
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(User $user, Request $request)
    {
        $n = Input::get('api_token');
        $apiuser = User::where('api_token', $n)->first();
        if ($apiuser->id == $user) {
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'confirmed'
            ]);

            $user->name = $request->get('name');
            $user->email = $request->get('email');
            if ($request->get('password') !== '') {
                $user->password = $request->get('password');
            }
            $user->save();
            return response()->json(['data' => [], 'result' => 1, 'description' => 'success to update user', 'message' => ['flash_notification.message'=>'Profile updated successfully','flash_notification.level'=>'success']]);
//            return redirect('/list')
//                ->with('flash_notification.message', 'Profile updated successfully')
//                ->with('flash_notification.level', 'success');
        } else {
            return response()->json(['data' => [], 'result' => 1, 'description' => 'failed to update user', 'message' => ['flash_notification.message'=>'Profile updated failedly','flash_notification.level'=>'danger']]);
        }
    }

}
