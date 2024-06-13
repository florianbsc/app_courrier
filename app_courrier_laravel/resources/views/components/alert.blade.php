@props(['type', 'message'])

@if ($message)
    <div class="alert alert-{{ $type }}">
        @if(is_array($message))
            <ul>
                @foreach ($message as $msg)
                    <li>{{ $msg }}</li>
                @endforeach
            </ul>
        @else
            {{ $message }}
        @endif
    </div>
@endif
