@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        
        @if (Auth::user()->role == 1)
            <clients></clients>
            <authorizedclients></authorizedclients>    
        @endif
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
