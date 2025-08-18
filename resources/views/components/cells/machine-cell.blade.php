<div class="d-flex align-items-center">
    <div class="avatar-sm bg-light rounded-circle d-flex align-items-center justify-content-center me-2">
        <i class="fas fa-tractor text-muted"></i>
    </div>
    <div>
        <span class="fw-medium">{{ $item->nome }}</span>
        @if($item->modelo)
            <br><small class="text-muted">{{ $item->modelo }}</small>
        @endif
    </div>
</div>