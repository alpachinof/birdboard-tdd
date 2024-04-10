<div class="card flex flex-col" style="height: 200px">
    <h3 class="font-normal text-xl py-4 -ml-5 mb-3 border-l-4 border-sky-300 pl-4">
        <a href="{{ $project->path() }}" class="text-black dark:text-white no-underline">{{ $project->title }}</a>
    </h3>

    <div class="text-gray dark:text-gray-300 mb-4 flex-1">{{ substr($project->description, 0, 100) . '...' }}</div>

    @can('manage', $project)
        <footer>
            <form method="post" action="{{ $project->path() }}" class="text-right">
                @method('delete')
                @csrf
                <button type="submit" class="text-xs">Delete</button>
            </form>
        </footer>
    @endcan

</div>
