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
                    <button type="button" class="btn btn-primary" data-device-id="" id="device-modal__delete">Удалить</button>

                    <div class="spinner-border text-danger" id="device-modal__spinner" hidden role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-6">
                <h1>Устройства</h1>
            </div>
            <div class="col-2">
                <a class="btn btn-success text-right" href="{{route('device.create')}}">Добавить запись</a>
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
                <th scope="col">Название</th>
                <th scope="col">S/N</th>
                <th scope="col">Разное</th>
                <th scope="col">Точка</th>
                <th scope="col">Действие</th>
            </tr>
            </thead>
            <tbody>
            @foreach($devices as $device)
                <tr>
                    <th scope="row">{{$loop->iteration}}</th>
                    <th>{{$device->name}}</th>
                    <th>{{$device->serial_number}}</th>
                    <th>{{$device->description}}</th>
                    <th>
                        @isset($device->point)
                            {{$device->point->city . ', ' . $device->point->address}}
                        @endisset
                    </th>
                    <th>
                        <a href="{{ route('device.edit', ['device' => $device]) }}" class="link-warning">Edit</a>
                        |
                        <a data-device-id="{{ $device->id }}" href="#" class="link-danger device-modal__show"
                           data-bs-toggle="modal"
                           data-bs-target="#ModalDelete">Удалить</a>
                    </th>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
@push('js')
    <script type="text/javascript">
        $('.device-modal__show').on('click', (el) => {
            const deleteId = $(el.target).data('device-id');
            $('#device-modal__delete').attr('data-device-id', deleteId);
        });

        $('#device-modal__delete').on('click', () => {
            $('#device-modal__delete').hide();
            $('#device-modal__spinner').toggle('fade');
            const deleteId = $('#device-modal__delete').data('device-id');
            $.ajax({
                method: 'DELETE',
                url: `/device/${deleteId}`,
                data: {"_token": $('meta[name="csrf-token"]').attr('content')},
                success(Response) {
                    window.location.href = '/device';
                },
                error(Error) {
                    window.location.href = '/device';
                },
                always() {
                    $('#device-modal__spinner').toggle('fade');
                    $('#device-modal__delete').show();
                },
            })
        });

    </script>
@endpush
