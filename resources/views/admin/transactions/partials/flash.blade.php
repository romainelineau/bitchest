@if(Session::has('message'))
<div class="col-12 alert alert-success" role="alert">
    <p class="m-0">{{ Session::get('message') }}</p>
</div>
@endif
