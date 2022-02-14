@extends('layouts.app')

@section('content')

    <!-- Modal -->
    <div class="modal fade" id="ModalDelete" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="staticModalDelete" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticModalDeleteLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Внимание! Удаление элемента необратимо.
                    <p>
                        Вы уверены?
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                    <button type="button" class="btn btn-primary" data-remote-id="" id="remote-modal__delete">Удалить</button>

                    <div class="spinner-border text-danger" id="remote-modal__spinner" hidden role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-6">
                <h1>Удалённое управление</h1>
            </div>
            <div class="col-2">
                <a class="btn btn-success text-right" href="{{route('remote.create')}}">Добавить запись</a>
            </div>
        </div>

        @if(session('message'))
            <div class="alert alert-success mt-3 mb-3">
                {!! session()->get('message') !!}
            </div>
        @endif

        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col-2">Номер</th>
                <th scope="col">Описание/пароль</th>
                <th scope="col">Точка</th>
            </tr>
            </thead>
            <tbody>
            @foreach($remotes as $remote)
                <tr>
                    <th scope="row">{{$loop->iteration}}</th>
                    <th>{{$remote->number}}</th>
                    <th>{{$remote->description}}</th>
                    <th>
                        @isset($remote->point)
                            {{$remote->point->city . ', ' . $remote->point->address}}
                        @endisset
                    </th>
                    <th>
                        <a href="{{ route('remote.edit', ['remote' => $remote]) }}" class="link-warning">Edit</a>
                        |
                        <a data-remote-id="{{ $remote->id }}" href="#" class="link-danger remote-modal__show"
                           data-bs-toggle="modal"
                           data-bs-target="#ModalDelete">Удалить</a>
                    </th>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

