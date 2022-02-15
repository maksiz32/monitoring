@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Создать договор') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('contract.store') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="number"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Номер договора') }}</label>

                                <div class="col-md-6">
                                    <input id="number" type="text"
                                           class="form-control @error('number') is-invalid @enderror" name="number"
                                           value="{{old('number')}}"
                                           required autofocus>

                                    @error('number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="contracts_master"
                                       class="col-md-4 col-form-label text-md-end">{{ __('На кого договор') }}</label>

                                <div class="col-md-6">
                                    <textarea id="contracts_master" type="text"
                                              class="form-control @error('contracts_master') is-invalid @enderror"
                                              name="contracts_master"
                                              required>{{old('contracts_master')}}</textarea>

                                    @error('contracts_master')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="speed"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Скорость') }}</label>

                                <div class="col-md-6">
                                    <input id="speed" type="text"
                                           class="form-control @error('speed') is-invalid @enderror" name="speed"
                                           value="{{old('speed')}}">

                                    @error('speed')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="price"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Стоимость') }}</label>

                                <div class="col-md-6">
                                    <input id="price" type="text"
                                           class="form-control @error('price') is-invalid @enderror" name="price"
                                           value="{{old('price')}}">

                                    @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="login_pppoe"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Логин PPPoE') }}</label>

                                <div class="col-md-6">
                                    <input id="login_pppoe" type="text"
                                           class="form-control @error('login_pppoe') is-invalid @enderror"
                                           name="login_pppoe"
                                           value="{{old('login_pppoe')}}">

                                    @error('login_pppoe')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password_pppoe"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Пароль PPPoE') }}</label>

                                <div class="col-md-6">
                                    <input id="password_pppoe" type="text"
                                           class="form-control @error('password_pppoe') is-invalid @enderror"
                                           name="password_pppoe"
                                           value="{{old('password_pppoe')}}">

                                    @error('password_pppoe')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            @isset($points)
                                <div class="row mb-3">
                                    <label for="point_id"
                                           class="col-md-4 col-form-label text-md-end">{{ __('На какой точке договор') }}</label>

                                    <div class="col-md-6">
                                        <select class="form-select @error('point_id') is-invalid @enderror"
                                                aria-label="На какой точке договор" name="point_id" required>
                                            <option class="text-muted">Нет привязки к точке</option>
                                            @foreach($points as $point)
                                                <option
                                                    value="{{$point->id}}">{{$point->city . ', ' . $point->address}}</option>
                                            @endforeach
                                        </select>

                                        @error('point_id')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                            @endisset

                            <div class="row mb-0">
                                <div class="d-grid col-6 mx-auto">
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
