@if(Session::has('message'))
<div class="col-12 alert alert-success" role="alert">
    <p class="m-0">{{ Session::get('message') }}</p>
</div>
@endif
@if(Session::has('alerte'))
<div class="col-12 alert alert-danger" role="alert">
    <p class="m-0">{{ Session::get('alerte') }}</p>
</div>
@endif
