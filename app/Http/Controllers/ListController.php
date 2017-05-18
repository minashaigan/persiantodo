<?php

namespace App\Http\Controllers;

use App\Listt;
use App\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class ListController extends Controller
{
    /**
     * View ToDos listing.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $Lists = Listt::where('user_id', Auth::id())->orderBy('created_at','desc')->paginate(7);
        //return response()->json($Lists);
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

        $todoList = Todo::where('list_id', $id)->orderBy('created_at','desc')->get();
        
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
    public function edit($id)
    {
        $list = Listt::findOrFail($id);
        return view('list.edit',['list_id' => $id,'list'=>$list]);
    }
    /**
     *
     */
    public function edited($id)
    {
        $list = Listt::findOrFail($id);
        $input = Input::all();
        if($input['Name']){
            $list->name = $input['Name'];
        }

        $list->save();
        return view('list.info',['list_id' => $id,'list'=>$list]);
    }
}
