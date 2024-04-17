<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-end w-full">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2>

            <div x-data class="flex items-center">

                <a x-on:click.prevent="$dispatch('open-modal', 'new-project-modal')" href=""
                    class="button ml-4 dark:text-white">New
                    Project</a>

                <x-new-project-modal></x-new-project-modal>

            </div>
        </div>
    </x-slot>

    <div class="lg:flex lg:flex-wrap -mx-3 max-w-7xl mx-auto">

        @foreach ($projects as $project)
            <div class="lg:w-1/3 px-3 pb-6">
                @include('projects.card')
            </div>
        @endforeach
    </div>





</x-app-layout>
