@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Принтеры</h1>

        @if(session('message'))
            <div class="alert alert-success mt-3 mb-3">
                {!! session()->get('message') !!}
            </div>
        @endif

        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col-2">Имя</th>
                <th scope="col">Описание</th>
                <th scope="col">Где установлен</th>
                <th scope="col">Редактировать</th>
            </tr>
            </thead>
            <tbody>
            @foreach($printers as $printer)
                <tr>
                    <th scope="row">{{$loop->iteration}}</th>
                    <th>{{$printer->name}}</th>
                    <th>{{$printer->description}}</th>
                    <th>
                        @foreach($printer->points as $point)
                            {{$point->city . ', ' . $point->address}}
                        @endforeach
                    </th>
                    <th><a href="{{ route('printer.edit', ['printer' => $printer->id]) }}" class="link-warning">Edit</a></th>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
