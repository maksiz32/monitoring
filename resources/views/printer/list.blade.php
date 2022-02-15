@extends('layouts.app')

@section('content')
    <div class="container">
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Имя</th>
                <th scope="col">Описание</th>
                <th scope="col">Редактировать</th>
            </tr>
            </thead>
            <tbody>
            @foreach($printers as $printer)
                <tr>
                    <th scope="row">{{$loop->iteration}}</th>
                    <th>{{$printer->name}}</th>
                    <th>{{$printer->description}}</th>
                    <th><a href="{{ route('printer.edit', ['printer' => $printer->id]) }}" class="link-warning">Edit</a></th>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
