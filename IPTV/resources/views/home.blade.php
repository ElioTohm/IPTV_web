@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <clients></clients>
        <authorizedclients></authorizedclients>
        <personalaccesstokens></personalaccesstokens>
        <div>
            <div class="panel panel-default">
                <div class="panel-heading">Notification and Client Settings</div>
                <div class="panel-body">
                    <a href='/clientnotification/0'>Notifify all</a>                
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
