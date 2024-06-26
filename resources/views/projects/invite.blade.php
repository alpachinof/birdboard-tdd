<div class="card flex flex-col mt-3">
    <h3 class="font-normal text-xl py-4 -ml-5 mb-3 border-l-4 border-indigo-700 pl-4">
        Invite a User
    </h3>

    <form method="post" action="{{ $project->path() . '/invitations' }}">
        @csrf
        <div class="mb-3">

            <x-text-input placeholder="Email address" type="email" name="email" class="w-full py-2 px-3" />

        </div>
        <button type="submit" class="button">Invite</button>
    </form>

    @include('components.errors', ['bag' => 'invitations'])
</div>
