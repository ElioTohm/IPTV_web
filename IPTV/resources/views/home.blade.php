@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Admin panel
                <div class="panel-body">
                    <clients></clients>
                    <authorizedclients></authorizedclients>
                    <personalaccesstokens></personalaccesstokens>
                </div>
                <div class="panel-footer">
                    <a href='/clientnotification/0'>Notifify all</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
