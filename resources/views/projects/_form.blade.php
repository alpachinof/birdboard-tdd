@csrf
<div class="field mb-6">
    <label for="title" class="label text-sm mb-2 block dark:text-gray-100">title</label>

    <div class="control">
        <input type="text"
            class="input bg-transparent border border-gray-300 dark:text-gray-300 dark:border-gray-600 rounded p-2 text-xs w-full"
            name="title" value="{{ $project->title }}">

    </div>
</div>

<div class="field mb-6">
    <label for="description" class="label text-sm mb-2 block dark:text-gray-100">description</label>

    <div class="control">
        <textarea rows="10"
            class="textarea bg-transparent border border-gray-300 dark:text-gray-200 dark:border-gray-600 rounded p-2 text-xs w-full"
            name="description">{{ $project->description }}</textarea>

    </div>
</div>

<div class="field">
    <div class="control">
        <button type="submit" class="button is-link mr-2 dark:text-gray-300">{{ $buttonText }}</button>
        <a class="dark:text-gray-400" href="{{ $project->path() }}">cancel</a>
    </div>
</div>

@if ($errors->any())
    <div class="field mt-6">
        @foreach ($errors->all() as $error)
            <li class="text-sm text-red-400">{{ $error }}</li>
        @endforeach
    </div>
@endif
