@if ($message = Session::get('success'))
    <div class="row justify-content-center">
        <div class="alert alert-primary" role="alert">
            {{$message}}
        </div>
    </div>
@elseif ($message = Session::get('unsuccessfully'))
    <div class="row justify-content-center">
        <div class="alert alert-danger" role="alert">
            {{$message}}
        </div>
    </div>
@endif

