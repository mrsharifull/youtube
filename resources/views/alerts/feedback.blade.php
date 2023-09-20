@if ($errors->has($field))
    <span class="alert alert-danger" style="opacity:1" role="alert">{{ $errors->first($field) }}</span>
@endif
