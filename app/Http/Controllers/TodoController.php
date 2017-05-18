<?php

namespace App\Http\Controllers;

use App\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;

class TodoController extends Controller
{
    /**
     * View ToDos listing.
     *
     * @return \Illuminate\View\View
     */
    public function index($id)
    {
        $todoList = Todo::where('list_id', $id)->orderBy('created_at','desc')->paginate(7);

        return view('todo.list',['todoList' => $todoList] );
    }

    public function show($id){

        $todoList = Todo::where('list_id', $id)->orderBy('created_at','desc')->get();

        //return $lists[0]->user;

        return view('todo.list',['todoList' => $todoList,'list_id'=>$id]);
        //return view('to do.list', compact('List'));
    }
    
    /**
     * View Create Form.
     *
     * @return \Illuminate\View\View
     */
    public function create($id)
    {
        return view('todo.create',['list_id' => $id]);
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
        $this->validate($request, ['end_date' => '']);
        $this->validate($request, ['deadline' => '']);
        $this->validate($request, ['rate' => '']);
        $list_id = $request->input('list_id');
        Todo::create([
            'name' => $request->get('name'),
            'context' => $request->get('context'),
            'file' => $request->get('file'),
            'date' => $request->get('end_date'),
            'deadline' => $request->get('deadline'),
            'rate' => $request->get('rate'),
            'list_id' => $request->input('list_id'),
        ]);
        return redirect('todo/'.$list_id)
            ->with('flash_notification.message', 'New todo created successfully')
            ->with('flash_notification.level', 'success');
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
        $todo = Todo::findOrFail($id);
        //$list_id = $todo->listt->id;
        $todo->complete = !$todo->complete;
        $todo->save();

        return Redirect::back()
            ->with('flash_notification.message', 'Todo updated successfully')
            ->with('flash_notification.level', 'success');
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
        $todo = Todo::findOrFail($id);
       // $list_id = $todo->listt->id;
        $todo->delete();

        return
            Redirect::back()
            ->with('flash_notification.message', 'Todo deleted successfully')
            ->with('flash_notification.level', 'success');
    }
    /**
     * View Create Form.
     *
     * @return \Illuminate\View\View
     */
    public function info($id)
    {
        $todo = Todo::findOrFail($id);
        return view('todo.info',['todo_id' => $id,'todo'=>$todo]);
    }
    /**
     * View Create Form.
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $todo = Todo::findOrFail($id);
        return view('todo.edit',['todo_id' => $id,'todo'=>$todo]);
    }
    /**
     *
     */
    public function submit_edit($id,Request $request)
    {
        $todo = Todo::findOrFail($id);
        $input = Input::all();
        if( $request->get('name')){
            $todo->name =  $request->get('name');
        }
        if( $request->get('context')){
            $todo->context =  $request->get('context');
        }
        if( $request->get('file')){
            $todo->file =  $request->get('file');
        }
        if( $request->get('end_date')){
            $todo->date =  $request->get('end_date');
        }
        if( $request->get('deadline')){
            $todo->date =  $request->get('deadline');
        }
        if($request->get('rate')){
            $todo->rate = $request->get('rate');
        }
        $todo->save();
        return view('todo.info',['todo_id' => $id,'todo'=>$todo]);
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
        //return $todoList;
        return view('todo.list', ['todoList' => $todoList,'list_id'=>$listid]);
    }

}
