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

            <a href="/projects/create" class="button dark:text-white">New Project</a>
        </div>
    </header>

    <div class="lg:flex -mx-3 dark:text-white">
        <div class="lg:w-3/4 px-3 mb-6">
            <div class="mb-8">
                <h2 class="text-lg text-gray font-normal mb-3">Tasks</h2>

                @foreach ($project->tasks as $task)
                    <div class="card mb-3">{{ $task->body }}</div>
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

                <div class="card">Lorem ipsum</div>
            </div>
        </div>


        <div class="lg:w-1/4 px-3">
            @include('projects.card')
        </div>
    </div>


</x-app-layout>
