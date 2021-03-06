<?php

namespace App\Http\Controllers;

use App\Listt;
use App\Todo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redis;

class ListController extends Controller
{
    /**
     * View ToDos listing.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $Lists = Listt::where('user_id', Auth::user()->id )->orderBy('created_at','desc')->get();
//        $Lists = Listt::where('user_id', 1)->orderBy('created_at','desc')->get();
        return response()->json(['data'=>['lists' => $Lists],'result'=>1,'description'=>'','message'=>'']);
//        return view('list.list',['Lists' => $Lists]);

        //return view('list.list', compact('Lists'));
    }

    /**
     * View Create Form.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('list.create');
    }

    /**
     * Create new To do.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
//        if(!Auth::user()){
//            return redirect('/login');
//        }

        $this->validate($request, ['name' => 'required']);
        $n = Input::get('api_token');
        $user = User::where('api_token', $n)->first();
        if($user) {
            Listt::create([
                'name' => $request->get('name'),
                'description' => $request->get('description'),
                'icon' => $request->get('icon'),
                'user_id' => $user->id,
//            'user_id' => 5,
            ]);

            return response()->json(['data' => [], 'result' => 1, 'description' => 'successful store', 'message' => ['flash_notification.message' => 'New list created successfully', 'flash_notification.level' => 'success']]);
//        return redirect('/list')
//          ->with('flash_notification.message', 'New to do created successfully')
//            ->with('flash_notification.level', 'success');
        }
        else{
            return response()->json(['data' => [], 'result' => 0, 'description' => 'failed store', 'message' => ['flash_notification.message' => 'New list created failedly', 'flash_notification.level' => 'danger']]);
        }
    }

    /**
     * Toggle Status.
     *
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id)
    {
        $n = Input::get('api_token');
        $user = User::where('api_token', $n)->first();
        $list = Listt::where('user_id',$user->id)->find($id);
        if($list){
            $input = Input::all();
            if(isset($input['Name'])){
                $list->name = $input['Name'];
            }
            if(isset($input['description'])){
                $list->description = $input['description'];
            }
            if(isset($input['icon'])){
                $list->icon = $input['icon'];
            }
            $list->save();
            return response()->json(['data'=>['List' => $list,'list_id' => $id],'result'=>1,'description'=>'successful update','message'=>['flash_notification.message'=>'List updated successfully','flash_notification.level'=>'success']]);
        }
        else{
            return response()->json(['data'=>[],'result'=>0,'description'=>'failed update','message'=>['flash_notification.message'=>'Wrong identity','flash_notification.level'=>'danger']]);
        }

//        $input = Input::all();
//        if($input['Name']){
//            $list->name = $input['Name'];
//        }
//        $list->save();
//        return response()->json([['list_id'=>$id],['list'=>$list],['flash_notification.message'=>'Todo updated successfully'],['flash_notification.level'=>'success']]);
        //return redirect()
          //  ->route('list.index')
            //->with('flash_notification.message', 'To do updated successfully')
            //->with('flash_notification.level', 'success');
    }

    /**
     * Toggle Status.
     *
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    
    public function show($id)
    {
        $n = Input::get('api_token');
        $user = User::where('api_token', $n)->first();
        $list = Listt::where('user_id',$user->id)->find($id);
        if($list){
            $todoList = Todo::where('list_id', $id)->orderBy('created_at','desc')->get();
            return response()->json(['data'=>['List' => $list,'list_id' => $id,'todoList'=>$todoList],'result'=>1,'description'=>'successful show','message'=>[]]);
        }
        else{
            return response()->json(['data'=>[],'result'=>0,'description'=>'failed show','message'=>['flash_notification.message'=>'Wrong identity','flash_notification.level'=>'danger']]);
        }
//        $storage = Redis::Connection();
//        if( $storage->zScore('listViews','list:' . $id) ) {
//            $storage->pipeline(function ($pipe) use ($id)
//            {
//                // want to have lots of increment of views
//                $pipe->zIncrBy('listViews', 1, 'list:' . $id);// name of this list of views as key,increment number,keys
//                $pipe->incr('list:' .$id. ':views');
//            });
//        }
//        else{
//            //increment new value
//            $views = $storage->incr('list:' .$id. ':views'); // return how many time this view , views
//            $storage->zIncrBy('listViews', $views, 'list:' . $id);
//        }
//        $views = $storage->get('list:' .$id. ':views');
//
//        //return "This a list with id : " . $id ." it has " . $views . " views";

//        $List = Listt::findOrFail($id);
//        $todoList = Todo::where('list_id', $id)->orderBy('created_at','desc')->get();
//        return response()->json([['List' => $List],['list_id' => $id],['todoList'=>$todoList]]);
        //$todoList = Todo::where('list_id', $id)->orderBy('created_at','desc')->get();
        //return $List;
        //return $todoList[0]->user;

//        return view('todo.list',['todoList' => $todoList,'list_id' => $id]);
        //return view('todo.list', compact('List'));
    }

    /**
     * Delete To do.
     *
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $n = Input::get('api_token');
        $user = User::where('api_token', $n)->first();
        $list = Listt::where('user_id',$user->id)->find($id);
        if($list){
            $list->delete();
            return response()->json(['data'=>[],'result'=>1,'description'=>'successful delete','message'=>['flash_notification.message'=> 'List deleted successfully','flash_notification.level'=> 'success']]);
        }
        else{
            return response()->json(['data'=>[],'result'=>0,'description'=>'failed delete','message'=>['flash_notification.message'=>'Wrong identity','flash_notification.level'=>'danger']]);
        }
//        $todo = Listt::findOrFail($id);
//        $todo->delete();
//
//        return response()->json([['flash_notification.message'=> 'Todo deleted successfully'],['flash_notification.level'=> 'success']]);
//        return redirect()
//            ->route('list.index')
//            ->with('flash_notification.message', 'Todo deleted successfully')
//            ->with('flash_notification.level', 'success');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $n = Input::get('api_token');
        $user = User::where('api_token', $n)->first();
        $list = Listt::where('user_id',$user->id)->find($id);
        if($list){
            return response()->json(['data'=>['list_id' => $id,'list'=>$list],'result'=>1,'description'=>'successful edit','message'=>['flash_notification.message'=> 'List edit successfully','flash_notification.level'=> 'success']]);
        }
        else{
            return response()->json(['data'=>[],'result'=>0,'description'=>'failed edit','message'=>['flash_notification.message'=>'Wrong identity','flash_notification.level'=>'danger']]);
        }
//        $list = Listt::findOrFail($id);
//        return response()->json([['list_id' => $id],['list'=>$list]]);
        //return view('list.edit',['list_id' => $id,'list'=>$list]);
    }
    /**
     *
     */
    public function edited($id)
    {
        $n = Input::get('api_token');
        $user = User::where('api_token', $n)->first();
        $list = Listt::where('user_id',$user->id)->find($id);
        if($list){
            $input = Input::all();
            if(isset($input['Name'])){
                $list->name = $input['Name'];
            }
            if(isset($input['description'])){
                $list->description = $input['description'];
            }
            if(isset($input['icon'])){
                $list->icon = $input['icon'];
            }
            $list->save();
            return response()->json(['data'=>['list_id'=>$id,'list'=>$list],'result'=>1,'description'=>'successful edited','message'=>['flash_notification.message'=> 'List edited successfully','flash_notification.level'=> 'success']]);
        }
        else{
            return response()->json(['data'=>[],'result'=>0,'description'=>'failed edited','message'=>['flash_notification.message'=>'Wrong identity','flash_notification.level'=>'danger']]);
        }
//        $list = Listt::findOrFail($id);
//        $input = Input::all();
//        if($input['Name']){
//            $list->name = $input['Name'];
//        }
//        $list->save();
//
//        return response()->json([['list_id'=>$id],['list'=>$list]]);
        //return view('list.info',['list_id' => $id,'list'=>$list]);
    }
}
