<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Category;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        return view('todo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::where('id', $id)->first();
        $task->delete();
        
        return response()->json([
            'status' => 200,
            'data' => $task
        ]);        
    }

    /**
     * Get all the Tasks with their Categories
     * @return Task
     */
    public function getTasks(){
        return Task::with('categories')->get();
    }

    /**
     * Get all the Categories
     * @return Category
     */
    public function getCategories(){
        return Category::get();
    }

    /**
     * Save the task with their categories
     * @return Category
     */
    public function store(Request $request){

        $task = new Task();
        $task->name = $request->name;
        $task->save();

        // Store categories on pivot table
        $task->categories()->sync($request->categories);
        $task = Task::where('id', $task->id)->with('categories')->first();
        
        return response()->json([
            'status' => 200,
            'data' => $task
        ]);
    }
}
