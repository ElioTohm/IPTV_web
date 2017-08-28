@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        
        @if (Auth::user()->role == 1)
            <clients></clients>
            <authorizedclients></authorizedclients>    
        @endif

        <div>
            <div class="panel panel-default">
                <div class="panel-heading">Notification and Client Settings</div>
                <div class="panel-body">
                    <a href="/clientnotification/0">send notification to all clients</a>
                </div>
            </div>
        </div>
        <div>
            <Channels></Channels>
        </div>
        <div>
            <devices></devices>
        </div>
        <div>
            <hotelclients></hotelclients>
        </div>
    </div>
</div>
@endsection
