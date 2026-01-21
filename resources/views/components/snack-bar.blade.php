@vite(['resources/css/components/snack-bar.scss'])
<div id="snack-container">
    @foreach(['success', 'error', 'warning', 'info'] as $msg)
        @if(session($msg))
            <div class="snack snack-{{ $msg }}" onclick="this.remove()">
                <div class="snack-icon">
                    @if($msg == 'success') <i class="fa-solid fa-circle-check"></i>
                    @elseif($msg == 'error') <i class="fa-solid fa-circle-xmark"></i>
                    @elseif($msg == 'warning') <i class="fa-solid fa-triangle-exclamation"></i>
                    @else <i class="fa-solid fa-circle-info"></i>
                    @endif
                </div>
                <div class="snack-content">
                    {{ session($msg) }}
                </div>
                <div class="snack-close">&times;</div>
            </div>
        @endif
    @endforeach
</div>