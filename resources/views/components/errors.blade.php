@if ($errors->{$bag ?? 'default'}->any())
    <ul class="field mt-6 list-reset">
        @foreach ($errors->{$bag ?? 'default'}->all() as $error)
            <li class="text-sm text-red-400">{{ $error }}</li>
        @endforeach
    </ul>
@endif
