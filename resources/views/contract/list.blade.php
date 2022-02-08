@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Договоры</h1>
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Номер</th>
                <th scope="col">Владелец</th>
                <th scope="col">Скорость</th>
                <th scope="col">Стоимость</th>
                <th scope="col">Логин PPPoE</th>
                <th scope="col">Пароль PPPoE</th>
                <th scope="col">Точка договора</th>
            </tr>
            </thead>
            <tbody>
            @foreach($contracts as $contract)
                <tr>
                    <th scope="row">{{$loop->iteration}}</th>
                    <th>{{$contract->number}}</th>
                    <th>{{$contract->contracts_master}}</th>
                    <th>{{$contract->speed}}</th>
                    <th>{{$contract->price}}</th>
                    <th>{{$contract->login_pppoe}}</th>
                    <th>{{$contract->password_pppoe}}</th>
                    <th>{{$contract->point->city . ', ' . $contract->point->address}}</th>
                    <th><a href="{{ route('contract.edit', ['contract' => $contract->id]) }}" class="link-warning">Edit</a></th>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
