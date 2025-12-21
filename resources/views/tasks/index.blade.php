<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Tasks') }}
            </h2>
            <a href="{{ route('tasks.create') }}" class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded">
                New Task
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- STATISTICHE -->
            <div class="grid grid-cols-3 gap-4 mb-6">
                <div class="bg-white p-4 rounded-lg shadow">
                    <div class="text-gray-500 text-sm">Total Tasks</div>
                    <div class="text-2xl font-bold">{{ $stats['total'] }}</div>
                </div>
                <div class="bg-yellow-100 p-4 rounded-lg shadow">
                    <div class="text-gray-500 text-sm">Pending</div>
                    <div class="text-2xl font-bold">{{ $stats['pending'] }}</div>
                </div>
                <div class="bg-green-100 p-4 rounded-lg shadow">
                    <div class="text-gray-500 text-sm">Completed</div>
                    <div class="text-2xl font-bold">{{ $stats['completed'] }}</div>
                </div>
            </div>

            <!-- FILTRI -->
            <div class="bg-white p-4 rounded-lg shadow mb-6">
                <form method="GET" action="{{ route('tasks.index') }}" class="grid grid-cols-4 gap-4">
                    
                    <div>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Search tasks..." 
                               class="w-full px-3 py-2 border rounded">
                    </div>

                    <div>
                        <select name="priority" class="w-full px-3 py-2 border rounded">
                            <option value="">All Priorities</option>
                           <option value="Bassa" {{ request('priority') == 'Bassa' ? 'selected' : '' }}>Bassa</option>
                            <option value="Media" {{ request('priority') == 'Media' ? 'selected' : '' }}>Media</option>
                            <option value="Alta" {{ request('priority') == 'Alta' ? 'selected' : '' }}>Alta</option>
                        </select>
                    </div>

                    <div>
                        <select name="status" class="w-full px-3 py-2 border rounded">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>

                    <div>
                        <select name="category_id" class="w-full px-3 py-2 border rounded">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
			<div>
                        <select name="sort_by" class="w-full px-3 py-2 border rounded">
                            <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Sort by Date</option>
                            <option value="due_date" {{ request('sort_by') == 'due_date' ? 'selected' : '' }}>Sort by Due Date</option>
                            <option value="priority" {{ request('sort_by') == 'priority' ? 'selected' : '' }}>Sort by Priority</option>
                            <option value="title" {{ request('sort_by') == 'title' ? 'selected' : '' }}>Sort by Title</option>
                        </select>
                    </div>

                    <div>
                        <select name="sort_order" class="w-full px-3 py-2 border rounded">
                            <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Descending</option>
                            <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Ascending</option>
                        </select>
                    </div>
                    <div class="col-span-4 flex gap-2">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-black px-4 py-2 rounded">
                            Apply Filters
                        </button>
                        <a href="{{ route('tasks.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">
                            Clear
                        </a>
                    </div>
                </form>
            </div>

            <!-- LISTA TASKS -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($tasks->count() > 0)
                        <div class="space-y-4">
                            @foreach($tasks as $task)
                                <div class="border rounded-lg p-4 hover:shadow-md transition">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="text-lg font-semibold">{{ $task->title }}</h3>
                                            <p class="text-gray-600 text-sm mt-1">{{ $task->description }}</p>
                         
			                  <div class="mt-2 flex gap-2">
                                                @php
                                                    $priorityColors = [
                                                        'Alta' => 'bg-red-500 text-white',
                                                        'Media' => 'bg-yellow-500 text-black',
                                                        'Bassa' => 'bg-green-500 text-white'
                                                    ];
                                                    $statusColors = [
                                                        'pending' => 'bg-orange-200 text-orange-800',
                                                        'completed' => 'bg-green-200 text-green-800'
                                                    ];
                                                @endphp
                                                
                                                <span class="px-2 py-1 rounded text-xs font-semibold {{ $priorityColors[$task->priority] ?? 'bg-gray-200' }}">
                                                    {{ $task->priority }}
                                                </span>
                                                
                                                <span class="px-2 py-1 rounded text-xs font-semibold {{ $statusColors[$task->status] ?? 'bg-gray-200' }}">
                                                    {{ $task->status }}
                                                </span>
                                                
                                                @if($task->category)
                                                    <span class="px-2 py-1 bg-blue-200 text-blue-800 rounded text-xs font-semibold">
                                                        {{ $task->category->name }}
                                                    </span>
                                                @endif
                                                
                                                @if($task->due_date)
                                                    @php
                                                        $dueDate = \Carbon\Carbon::parse($task->due_date);
                                                        $isOverdue = $dueDate->isPast() && $task->status != 'completed';
                                                        $isDueSoon = $dueDate->isToday() || $dueDate->isTomorrow();
                                                    @endphp
                                                    <span class="px-2 py-1 rounded text-xs font-semibold 
                                                        {{ $isOverdue ? 'bg-red-600 text-white' : ($isDueSoon ? 'bg-yellow-600 text-white' : 'bg-gray-300 text-gray-800') }}">
                                                        📅 {{ $dueDate->format('d/m/Y') }}
                                                        @if($isOverdue) (SCADUTO) @endif
                                                        @if($isDueSoon && !$isOverdue) (URGENTE) @endif
                                                    </span>
                                                @endif
                                            </div>
                             

				        </div>
                                        <div class="flex gap-2">
                                            <a href="{{ route('tasks.edit', $task) }}" class="text-blue-500 hover:text-blue-700">Edit</a>
                                            <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Delete this task?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4">
                            {{ $tasks->links() }}
                        </div>
                    @else
                        <p class="text-gray-500">No tasks found. Try different filters or create a new task!</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
