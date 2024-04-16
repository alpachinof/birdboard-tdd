<x-app-layout>
    <header class="flex items-center mb-3 py-4">
        <div class="flex justify-between items-end w-full">
            <p class="text-gray text-sm font-normal dark:text-white">
                <a href="/projects" class="text-gray text-sm font-normal no_underline dark:text-white">
                    My projects
                </a>
                / {{ $project->title }}
            </p>

            <div class="flex items-center">
                @foreach ($project->members as $member)
                    <img src="{{ asset('avatar.png') }}" alt="" class="rounded-full w-8 mr-2">
                @endforeach
                <img src="{{ asset('avatar.png') }}" alt="" class="rounded-full w-8 mr-2">

                <a href="{{ $project->path() . '/edit' }}" class="button ml-4 dark:text-white">Edit Project</a>

            </div>
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

                            <div class="flex items-center">
                                <x-text-input name="body"
                                    class="w-full {{ $task->completed ? 'text-gray-400' : '' }}"
                                    value="{{ $task->body }}" />

                                <input
                                    class="ml-4 w-6 h-6 focus:ring-indigo-500 text-indigo-600 border-gray-300 rounded dark:bg-gray-900 dark:border-gray-600"
                                    name="completed" type="checkbox" onchange="this.form.submit()"
                                    {{ $task->completed ? 'checked' : '' }}>
                            </div>
                        </form>

                    </div>
                @endforeach

                <div class="card mb-3">
                    <form action="{{ $project->path() . '/tasks' }}" method="post">
                        @csrf
                        <x-text-input placeholder="add tasks" name="body" class="w-full" />
                    </form>
                </div>
            </div>

            <div class="">
                <h2 class="text-lg text-gray font-normal mb-3">General Notes</h2>

                <form method="post" action="{{ $project->path() }}">
                    @method('patch')
                    @csrf
                    <textarea name="notes" class="card w-full mb-4 " style="min-height: 200px">{{ $project->notes }}</textarea>
                    <button type="submit" class="button">save</button>
                </form>
            </div>
        </div>


        <div class="lg:w-1/4 px-3">
            @include('projects.card')

            @include('projects.activity.card')

            @can('manage', $project)
                @include('projects.invite')
            @endcan

        </div>
    </div>


</x-app-layout>
