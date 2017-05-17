<?php

namespace App\Http\Controllers;

use App\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    /**
     * View ToDos listing.
     *
     * @return \Illuminate\View\View
     */
    public function index($id)
    {
        $todoList = Todo::where('list_id', $id)->paginate(7);

        return view('todo.list',['todoList' => $todoList] );
    }

    public function show($id){

        $todoList = Todo::where('list_id', $id)->get();

        //return $lists[0]->user;

        return view('todo.list',['todoList' => $todoList]);
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
        $list_id = $request->input('list_id');
        Todo::create([
            'name' => $request->get('name'),
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
        $list_id = $todo->listt->id;
        $todo->complete = !$todo->complete;
        $todo->save();

        return redirect('todo/'.$list_id)
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
        $list_id = $todo->listt->id;
        $todo->delete();

        return
            redirect('todo/'.$list_id)
            ->with('flash_notification.message', 'Todo deleted successfully')
            ->with('flash_notification.level', 'success');
    }
}
