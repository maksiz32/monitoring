@extends('point.layout')

@section('point_map')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body text-center">
                    {{ __('Выберите подразделение') }}
                </div>
            </div>

            @if(session('message'))
                <div class="alert alert-success mt-3 mb-3">
                    {!! session()->get('message') !!}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
