<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Task') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('tasks.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Title</label>
                            <input type="text" name="title" value="{{ old('title') }}" required
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                            @error('title')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                            <textarea name="description" rows="4"
                                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">{{ old('description') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Priority</label>
                                <select name="priority" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                                <option value="Bassa">Bassa</option>
                                <option value="Media" selected>Media</option>
                                <option value="Alta">Alta</option>
                                </select>
                        </div>
                       <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                             <select name="status" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                            <option value="pending" selected>Pending</option>
                            <option value="completed">Completed</option>
                            </select>
                      </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Category</label>
                            <select name="category_id" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                                <!--<option value="10">No Category</option>-->
                                
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Due Date</label>
                            <input type="date" name="due_date" value="{{ old('due_date') }}"
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded">
                                Create Task
                            </button>
                            <a href="{{ route('tasks.index') }}" class="text-gray-600 hover:text-gray-800">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>