<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
	$query=Task::where('user_id', auth()->id())->with('category');

	//filtro per priority
	if ($request->filled('priority'))  {
	    $query->where('priority', $request->priority);
	}
	
	//filtro per status
	if ($request->filled('status'))   {
	    $query->where('status', $request->status);
	}

	//filtro per categoria
	if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
	}


	//ricerla per titolo
	if ($request->filled('search'))  {
	    $query->where('title','like', '%'. $request->search.'%');
	}

	//Ordinamento dinamico
	$sortBy=$request->get('sort_by', 'created_at');
	$sortOrder=$request->get('sort_order','desc');
	
	$allowedSorts=['created_at', 'due_date', 'priority', 'title'];
	if (!in_array($sortBy, $allowedSorts))  {
	    $sortBy= 'created_at';
	}

	$tasks=$query->orderBy($sortBy, $sortOrder)->paginate(10);

	//Statistiche
	$stats=[
		'total'=>Task::where('user_id', auth()->id())->count(),
		'pending'=> Task::where('user_id', auth()->id())->where('status', 'pending')->count(),
		'completed'=> Task::where('user_id', auth()->id())->where('status', 'completed')->count(),
		];

	$categories =Category::where('user_id', auth()->id())->get();		    
	
	return view('tasks.index', compact('tasks', 'stats', 'categories'));

}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories=Category::where('user_id', auth()->id())->get();
        return view('tasks.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
    'title' => 'required|max:255',
    'description' => 'nullable',
    'priority' => 'required|in:Alta,Media,Bassa',
    'status' => 'required|in:pending,completed',
    'category_id' => 'nullable|exists:categories,id',
    'due_date' => 'nullable|date'
        ]);

        $validated['user_id']=auth()->id();
        Task::create($validated);
        
        return redirect()->route('tasks.index')->with('success','Task created successfully!');
    
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //verifica che task appartiene all'utente loggato
        if ($task->user_id !== auth()->id()) {
            abort(403);
        }   
    
        $categories=Category::where('user_id', auth()->id())->get();
        return view('tasks.edit', compact('task','categories'));



    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        //verifichiamo che task appartiene all'utente loggato
        if ($task->user_id !== auth()->id()){
            abort(403);
        }

        $validated= $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'priority' => 'required|in:Alta,Media,Bassa',
            'status' => 'required|in:pending,completed',
            'category_id' => 'nullable|exists:categories,id',
            'due_date' => 'nullable|date'
        ]);

        $task->update($validated);
        return redirect()->route('tasks.index')->with('success','Task updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy (Task $task) 
    {
        //verifico che task appartiene all'utente loggato
        if ($task->user_id !== auth()->id()) {
            abort(403);
        }

        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully!');

    }
}
