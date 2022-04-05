<div flash class="message
    @if(Session::has('status') && Session::get('status') == 'error') error
    @elseif(Session::has('status') && Session::get('status') == 'success') success
    @else hidden
    @endif
    my-3 py-2 px-3"
    onclick="this.classList.add('hidden')">
    @if(Session::has('data'))
        @foreach (Session::get('data') as $msg)
            {{ $msg }}<br />
        @endforeach
    @endif
</div>