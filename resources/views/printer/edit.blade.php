@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Отредактировать принтер') }}</div>

                    <div class="card-body">

                        @if(session()->get('message'))
                            <div class="alert alert-success mt-3 mb-3">
                                {!! session()->get('message') !!}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('printer.update', ['printer' => $printer]) }}">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="id" value="{{old('id', $printer->id)}}">
                            <div class="row mb-3">
                                <label for="name"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Принтер') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           name="name"
                                           value="{{old('name', $printer->name)}}"
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
                                    <input id="serial_number" type="text"
                                           class="form-control @error('serial_number') is-invalid @enderror"
                                           name="serial_number"
                                           value="{{old('serial_number', $printer->serial_number)}}"
                                           >

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
                                    >{{old('description', $printer->description)}}</textarea>

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
                                           class="col-md-4 col-form-label text-md-end">{{ __('На какой точке принтер') }}</label>

                                    <div class="col-md-6">
                                        <select class="form-select" aria-label="На какой точке принтер"
                                                name="point_id">
                                            <option class="text-muted @error('point_id') is-invalid @enderror" value="">Нет привязки к точке
                                            </option>
                                            @foreach($points as $point)
                                                <option
                                                    @if(isset($printer->point) && $printer->point->id === $point->id)
                                                    selected
                                                    @endif
                                                    value="{{$point->id}}">{{$point->city . ', ' . $point->address}}</option>
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

                            <div class="row mb-3">
                                <label for="is_spare"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Есть запасной картридж?') }}</label>

                                <div class="col-md-6">
                                    <select class="form-select @error('is_spare') is-invalid @enderror" aria-label="Есть запасной картридж?" required
                                            name="is_spare">
                                        <option value="1"
                                                @if($printer->is_spare)
                                                selected
                                                @endif
                                        >
                                            ЕСТЬ
                                        </option>
                                        <option selected value="2">
                                            НЕТ
                                        </option>
                                    </select>

                                    @error('is_spare')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="reset" class="btn btn-outline-dark">
                                        {{ __('Сброс') }}
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Редактировать') }}
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
