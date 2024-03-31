<x-app-layout>
    <div class="lg:w-1/2 lg:mx-auto bg-white dark:bg-gray-800 p-6 md:py-12 md:px-16 rounded shadow">
        <h1 class="text-2xl dark:text-white font-normal mb-10 text-center">create new project</h1>


        <form method="post" action="/projects" class="">
            @include('projects._form', [
                'project' => new App\Models\Project(),
                'buttonText' => 'Create Project',
            ])

        </form>
    </div>
</x-app-layout>
