<x-app-layout>
    {{-- <x-slot name="header">
        <div class="flex justify-between items-end w-full">
            <p class="text-gray text-sm font-normal dark:text-white">
                <a href="/dashboard" class="text-gray text-sm font-normal no_underline dark:text-white">
                    My projects
                </a>
                / {{ $project->title }}
            </p>

            <a href="/projects/create" class="button dark:text-white">New Project</a>
        </div>
    </x-slot> --}}

    <header class="flex items-center mb-3 py-4">
        <div class="flex justify-between items-end w-full">
            <p class="text-gray text-sm font-normal dark:text-white">
                <a href="/projects" class="text-gray text-sm font-normal no_underline dark:text-white">
                    My projects
                </a>
                / {{ $project->title }}
            </p>

            <a href="{{ $project->path() . '/edit' }}" class="button dark:text-white">Edit Project</a>
        </div>
    </header>

    <div class="lg:flex -mx-3 dark:text-white">
        <div class="lg:w-3/4 px-3 mb-6">
            <div class="mb-8">
                <h2 class="text-lg text-gray font-normal mb-3">Tasks</h2>

                @foreach ($project->tasks as $task)
                    <div class="card mb-3">
                        <form method="post" action="{{ $task->path() }}">
                            @method('patch')
                            @csrf

                            <div class="flex">
                                <input class="w-full {{ $task->completed ? 'text-gray-400' : '' }}" name="body"
                                    value="{{ $task->body }}">
                                <input name="completed" type="checkbox" onchange="this.form.submit()"
                                    {{ $task->completed ? 'checked' : '' }}>
                            </div>
                        </form>

                    </div>
                @endforeach

                <div class="card mb-3">
                    <form action="{{ $project->path() . '/tasks' }}" method="post">
                        @csrf
                        <input placeholder="add tasks" class="w-full" name="body">
                    </form>
                </div>
            </div>

            <div class="">
                <h2 class="text-lg text-gray font-normal mb-3">General Notes</h2>

                <form method="post" action="{{ $project->path() }}">
                    @method('patch')
                    @csrf
                    <textarea name="notes" class="card w-full mb-4" style="min-height: 200px">{{ $project->notes }}</textarea>
                    <button type="submit" class="button">save</button>
                </form>
            </div>
        </div>


        <div class="lg:w-1/4 px-3">
            @include('projects.card')
        </div>
    </div>


</x-app-layout>
