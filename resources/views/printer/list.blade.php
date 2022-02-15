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
                    <button type="button" class="btn btn-primary" data-printer-id="" id="printer-modal__delete">Удалить</button>

                    <div class="spinner-border text-danger fade" id="printer-modal__spinner" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-3">
                <h1>Принтеры</h1>
            </div>
            <div class="col-2">
                <a class="btn btn-success text-right" href="{{route('printer.create')}}">Добавить принтер</a>
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
                <th scope="col-2">Имя</th>
                <th scope="col">S/N</th>
                <th scope="col">Описание</th>
                <th scope="col">Где установлен</th>
                <th scope="col">Запасной картридж</th>
                <th scope="col">Редактировать</th>
            </tr>
            </thead>
            <tbody>
            @foreach($printers as $printer)
                <tr>
                    <th scope="row">{{$loop->iteration}}</th>
                    <th>{{$printer->name}}</th>
                    <th>{{$printer->serial_number}}</th>
                    <th>{{$printer->description}}</th>
                    <th>
                        @isset($printer->point)
                            {{$printer->point->city . ', ' . $printer->point->address}}
                        @endisset
                    </th>
                    <th>@if($printer->is_spare)ДА@elseНЕТ@endif</th>
                    <th>
                        <a href="{{ route('printer.edit', ['printer' => $printer]) }}" class="link-warning">Edit</a>
                        |
                        <a data-printer-id="{{ $printer->id }}" href="#" class="link-danger printer-modal__show"
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
        $('.printer-modal__show').on('click', (el) => {
            const deleteId = $(el.target).data('printer-id');
            $('#printer-modal__delete').attr('data-printer-id', deleteId);
        });

        $('#printer-modal__delete').on('click', () => {
            $('#printer-modal__delete').hide();
            $('#printer-modal__spinner').toggle('fade');
            const deleteId = $('#printer-modal__delete').data('printer-id');
            $.ajax({
                method: 'DELETE',
                url: `/printer/${deleteId}`,
                data: {"_token": $('meta[name="csrf-token"]').attr('content')},
                success(Response) {
                    window.location.href = '/printer';
                },
                error(Error) {
                    window.location.href = '/printer';
                },
                always() {
                    $('#printer-modal__spinner').toggle('fade');
                    $('#printer-modal__delete').show();
                },
            })
        });

    </script>
@endpush
