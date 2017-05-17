<?php

namespace App\Http\Controllers;

use App\Listt;
use App\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListController extends Controller
{
    /**
     * View ToDos listing.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $Lists = Listt::where('user_id', Auth::id())->paginate(7);
        return view('list.list',['Lists' => $Lists]);
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
     * Create new Todo.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, ['name' => 'required']);

        Listt::create([
            'name' => $request->get('name'),
            'user_id' => Auth::user()->id,
        ]);

        return redirect('/list')
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
        $list = Listt::findOrFail($id);
        $list->complete = !$list->complete;
        $list->save();

        return redirect()
            ->route('list.index')
            ->with('flash_notification.message', 'Todo updated successfully')
            ->with('flash_notification.level', 'success');
    }

    /**
     * Toggle Status.
     *
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show($id){

        $todoList = Todo::where('list_id', $id)->get();

        //return $lists[0]->user;
        
        return view('todo.list',['todoList' => $todoList]);
        //return view('to do.list', compact('List'));
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
        $todo = Listt::findOrFail($id);
        $todo->delete();

        return redirect()
            ->route('list.index')
            ->with('flash_notification.message', 'Todo deleted successfully')
            ->with('flash_notification.level', 'success');
    }
}
