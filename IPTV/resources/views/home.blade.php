@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div>
            <Channels></Channels>
        </div>
        <div class="row">
            <devices class="col-md-6"></devices>
            <monitor class="col-md-6"></monitor>
        </div>
        <div>
            <hotelclients></hotelclients>
        </div>
    </div>
</div>
@endsection
