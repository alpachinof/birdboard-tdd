<div class="card" style="height: 200px">
    <h3 class="font-normal text-xl py-4 -ml-5 mb-3 border-l-4 border-sky-300 pl-4">
        <a href="{{ $project->path() }}" class="text-black dark:text-white no-underline">{{ $project->title }}</a>
    </h3>

    <div class="text-gray dark:text-gray-300">{{ substr($project->description, 0, 100) . '...' }}</div>
</div>
