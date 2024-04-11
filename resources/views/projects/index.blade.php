<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="lg:flex lg:flex-wrap -mx-3">

        @foreach ($projects as $project)
            <div class="lg:w-1/3 px-3 pb-6">
                @include('projects.card')
            </div>
        @endforeach
    </div>

    <x-new-project-modal></x-new-project-modal>



</x-app-layout>
