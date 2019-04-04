@if(session()->has('message-type'))
<div class="card mb-4 py-3 border-left-{{ session()->get('message-type') }}">
    <div class="card-body">
        {{ session()->get('message-text') }}
    </div>
</div>
@endif
