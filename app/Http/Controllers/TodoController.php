<?php

namespace App\Http\Controllers;

use App\Listt;
use App\Todo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Notifications\Notifiable;
use App\Notifications\UnDoneToDo;
use Illuminate\Support\Facades\Input;




class TodoController extends Controller
{
    use Notifiable;
    /**
     * View ToDos listing.
     *
     * @return \Illuminate\View\View
     */
    public function index($id)
    {
        $n = Input::get('api_token');
        $user = User::where('api_token', $n)->first();
        $list = Listt::where('user_id',$user->id)->find($id);
        if($list){
            $todoList = Todo::where('list_id', $id)->orderBy('created_at','desc')->get();
            //return response()->json(['todoList'=>$todoList]);
//        $todoList = Todo::findOrFail($id);
            return response()->json(['data'=>['todoList' => $todoList],'result'=>1,'description'=>'todos list','message'=>[]]);
        }
        else{
            return response()->json(['data'=>[],'result'=>0,'description'=>'failed todos list','message'=>['flash_notification.message'=>'Wrong identity','flash_notification.level'=>'danger']]);
        }


        //return view('todo.list',['todoList' => $todoList] );
    }

    public function show($id)
    {
        $n = Input::get('api_token');
        $user = User::where('api_token', $n)->first();
        $todo = Todo::findorfail($id);
        $list = Listt::where('user_id',$user->id)->find($todo->list_id);
        if($list){
            //$todoList = Todo::where('list_id', $id)->orderBy('created_at','desc')->get();
            return response()->json(['data'=>['todo'=>$todo,'list_id'=>$id],'result'=>1,'description'=>'todo show','message'=>[]]);
        }
        else{
            return response()->json(['data'=>[],'result'=>0,'description'=>'failed todo show','message'=>['flash_notification.message'=>'Wrong identity','flash_notification.level'=>'danger']]);
        }
//        $todoList = Todo::where('list_id', $id)->orderBy('created_at','desc')->get();
//        return response()->json([['todoList'=>$todoList],['list_id'=>$id]]);

        ////return $lists[0]->user;

//        return view('todo.list',['todoList' => $todoList,'list_id'=>$id]);

    }
    
    /**
     * View Create Form.
     *
     * @return \Illuminate\View\View
     */
    public function create($id)
    {
        return response()->json(['data'=>['list_id' => $id]]);
        //return view('todo.create',['list_id' => $id]);
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

        $this->validate($request, ['name' => 'required']);
        $this->validate($request, ['context' => '']);
        $this->validate($request, ['file' => '']);
        $this->validate($request, ['link' => '']);
        $this->validate($request, ['sticker_name' => '']);
        $this->validate($request, ['sticker_color' => '']);
        $this->validate($request, ['deadline' => '']);
        $this->validate($request, ['rate' => '']);
        $this->validate($request, ['list_id' => 'required']);
        $list_id = $request->input('list_id');
        $n = Input::get('api_token');
        $user = User::where('api_token', $n)->first();
        $list = Listt::where('user_id',$user->id)->find($list_id);
        if($list) {
            Todo::create($request->all()
//[
//                'name' => $request->get('name'),
//                'context' => $request->get('context'),
//                'file' => $request->get('file'),
//                'link' => $request->get('link'),
//                'sticker_name' => $request->get('sticker_name'),
//                'sticker_color' => $request->get('sticker_color'),
//                'deadline' => $request->get('deadline'),
//                'rate' => $request->get('rate'),
//                'list_id' => $request->input('list_id'),
//            ]
);

            return response()->json(['data' => ['list_id' => $list_id], 'result' => 1, 'description' => 'success todo store', 'message' => ['flash_notification.message' => 'New todo created successfully', 'flash_notification.level' => 'success']]);
//        return response()->json([['list_id'=>$list_id],['flash_notification.message'=> 'New todo created successfully'],['flash_notification.level'=>'success']]);
//        return redirect('todo/'.$list_id)
//           ->with('flash_notification.message', 'New todo created successfully')
//            ->with('flash_notification.level', 'success');
        }
        else{
            return response()->json(['data'=>[],'result'=>0,'description'=>'failed todo store','message'=>['flash_notification.message'=>'Wrong identity','flash_notification.level'=>'danger']]);
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
        $todo = Todo::findorfail($id);
        $list = Listt::where('user_id',$user->id)->find($todo->list_id);
        if($list) {
//        $todo = Todo::findOrFail($id);
            //$list_id = $todo->listt->id;
            $todo->complete = !$todo->complete;
            $todo->save();
            return response()->json(['data' => [], 'result' => 1, 'description' => 'success in changing complete state of todo', 'message' => ['flash_notification.message' => 'Todo successfully complete or incomplete','flash_notification.level' => 'success']]);
//        return Redirect::back()
//            ->with('flash_notification.message', 'Todo updated successfully')
//            ->with('flash_notification.level', 'success');
        }
        else{
            return response()->json(['data' => [], 'result' => 0, 'description' => 'failed in changing complete state of todo', 'message' => ['flash_notification.message' => 'Todo failedly complete or incomplete','flash_notification.level' => 'danger']]);
        }
    }
    
    /**
     * Delete Todo.
     *
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $n = Input::get('api_token');
        $user = User::where('api_token', $n)->first();
        $todo = Todo::findorfail($id);
        $list = Listt::where('user_id',$user->id)->find($todo->list_id);
        if($list) {
//        $todo = Todo::findOrFail($id);
            // $list_id = $todo->listt->id;
            $todo->delete();
            return response()->json(['data' => [], 'result' => 1, 'description' => 'success in delete a  todo', 'message' => ['flash_notification.message' => 'Todo deleted successfully','flash_notification.level' => 'success']]);
//        return Redirect::back()
//            ->with('flash_notification.message', 'Todo deleted successfully')
//            ->with('flash_notification.level', 'success');
        }
        else{
            return response()->json(['data' => [], 'result' => 0, 'description' => 'failed in delete a  todo', 'message' => ['flash_notification.message' => 'Todo deleted failedly','flash_notification.level' => 'danger']]);
        }
    }
    /**
     * View Create Form.
     *
     * @return \Illuminate\View\View
     */
    public function info($id)
    {
        $n = Input::get('api_token');
        $user = User::where('api_token', $n)->first();
        $todo = Todo::findorfail($id);
        $list = Listt::where('user_id',$user->id)->find($todo->list_id);
        if($list) {
//        $todo = Todo::findOrFail($id);
            return response()->json([['todo_id' => $id], ['todo' => $todo]]);
            //return view('todo.info',['todo_id' => $id,'todo'=>$todo]);
        }
    }
    /**
     * View Create Form.
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $todo = Todo::findOrFail($id);
        return response()->json([['todo_id' => $id],['todo'=>$todo]]);
        //return view('todo.edit',['todo_id' => $id,'todo'=>$todo]);
    }
    /**
     *
     */
    public function submit_edit(Request $request,$id)
    {
        $n = Input::get('api_token');
        $user = User::where('api_token', $n)->first();
        $todo = Todo::findorfail($id);
        $list = Listt::where('user_id',$user->id)->find($todo->list_id);
        if($list) {
//        $todo = Todo::findOrFail($id);
//        $input = Input::all();
            if ($request->get('name')) {
                $todo->name = $request->get('name');
            }
            if ($request->get('context')) {
                $todo->context = $request->get('context');
            }
            if ($request->get('file')) {
                $todo->file = $request->get('file');
            }
            if ($request->get('link')) {
                $todo->file = $request->get('link');
            }
            if ($request->get('sticker_name')) {
                $todo->date = $request->get('sticker_name');
            }
            if ($request->get('sticker_color')) {
                $todo->date = $request->get('sticker_color');
            }
            if ($request->get('deadline')) {
                $todo->date = $request->get('deadline');
            }
            if ($request->get('rate')) {
                $todo->rate = $request->get('rate');
            }
            $todo->save();
            return response()->json(['data' => ['todo_id' => $id,'todo' => $todo], 'result' => 1, 'description' => 'success in edit a  todo', 'message' => ['flash_notification.message' => 'Todo edited successfully','flash_notification.level' => 'success']]);
//            return response()->json([['todo_id' => $id], ['todo' => $todo]]);
            //return view('todo.info',['todo_id' => $id,'todo'=>$todo]);
        }
        else{
            return response()->json(['data' => [], 'result' => 0, 'description' => 'failed in edit a  todo', 'message' => ['flash_notification.message' => 'Todo edited failedly','flash_notification.level' => 'danger']]);
        }
    }

    /**
     * @param $id
     * @param $listid
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function filter($flag,$listid)
    {
        if($flag==0 or $flag==1){
            $todoList = Todo::where('complete',$flag)->where('list_id',$listid)->orderBy('created_at','desc')->get();
        }
        else{
            $todoList = Todo::where('rate',floatval($flag))->where('list_id',$listid)->orderBy('created_at','desc')->get();
        }
        return response()->json([['todoList' => $todoList],['list_id'=>$listid]]);
        //return view('todo.list', ['todoList' => $todoList,'list_id'=>$listid]);
    }

    public function notify($id)
    {
        $todo = Todo::findOrFail($id);
        $list = Listt::findOrFail($todo->listt->id);
        $user = User::findOrFail($list->user_id);
        
            $user->notify(new UnDoneToDo($todo,$user));
        
        
    }
}
