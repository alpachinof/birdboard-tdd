<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="flex m-8">

        @foreach ($projects as $project)
            <div class="bg-white dark:bg-gray-800  mr-4 p-5 rounded shadow w-1/3 h-[200px]">
                <h3 class="dark:text-white font-normal text-xl mb-6">{{ $project->title }}</h3>

                <div class="dark:text-gray-400">{{ $project->description }}</div>
            </div>
        @endforeach
    </div>



</x-app-layout>
