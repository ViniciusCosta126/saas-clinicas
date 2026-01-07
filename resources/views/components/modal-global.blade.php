@props(['id', 'title'])

<div id="{{ $id }}" class="modal-overlay" onclick="closeModal('{{ $id }}')">
    <div class="modal-content" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3>{{ $title }}</h3>
            <button class="modal-close" onclick="closeModal('{{ $id }}')">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        
        <div class="modal-body">
            {{ $slot }}
        </div>

        @if(isset($footer))
            <div class="modal-footer">
                {{ $footer }}
            </div>
        @endif
    </div>
</div>