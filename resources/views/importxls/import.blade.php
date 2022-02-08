@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Загрузка данных') }}</div>

                    <div class="card-body">
                        <div class="alert alert-success" role="alert">
                            ВНИМАНИЕ! Данное действие очистит все старые данные и запишет новые!
                        </div>

                        @if(session()->get('message'))
                            <div class="alert alert-success mt-3 mb-3">
                                {!! session()->get('message') !!}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('point.saveXLS') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="xlsFile" class="form-label">Выберите файл Excel</label>
                                <input class="form-control" type="file" id="xlsFile" name="xlsFile"
                                    accept=".application/vnd.sealed.xls, .xls, .xlsx"
                                    required>
                            </div>

                            <div class="row mb-0">
                                <div class="d-grid gap-2 col-6 mx-auto">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        {{ __('Ввод') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
