@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Добавить устройство') }}</div>

                    <div class="card-body">

                        @if(session()->get('message'))
                            <div class="alert alert-success mt-3 mb-3">
                                {!! session()->get('message') !!}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('device.store') }}">
                            @csrf
                            <div class="row mb-3">
                                <label for="name"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Название') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           name="name"
                                           value="{{old('name')}}"
                                           required autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="serial_number"
                                       class="col-md-4 col-form-label text-md-end">{{ __('S/N') }}</label>

                                <div class="col-md-6">
                                    <textarea id="serial_number" type="text"
                                              class="form-control @error('serial_number') is-invalid @enderror"
                                              name="serial_number"
                                    >{{old('serial_number')}}</textarea>

                                    @error('serial_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="description"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Описание') }}</label>

                                <div class="col-md-6">
                                    <textarea id="description" type="text"
                                              class="form-control @error('description') is-invalid @enderror"
                                              name="description"
                                    >{{old('description')}}</textarea>

                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            @isset($points)
                                <div class="row mb-3">
                                    <label for="points_id"
                                           class="col-md-4 col-form-label text-md-end">{{ __('На какой точке устройство') }}</label>

                                    <div class="col-md-6">
                                        <select class="form-select" aria-label="На какой точке устройство"
                                                name="point_id" required>
                                            <option class="text-muted @error('point_id') is-invalid @enderror" value="">Нет привязки к точке
                                            </option>
                                            @foreach($points as $point)
                                                <option value="{{$point->id}}">{{$point->city . ', ' . $point->address}}</option>
                                            @endforeach
                                        </select>

                                        @error('points_id')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                            @endisset

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Добавить') }}
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
