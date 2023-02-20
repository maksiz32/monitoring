@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Добавить точку') }}</div>

                    <div class="card-body">

                        @if(session()->get('message'))
                            <div class="alert alert-success mt-3 mb-3">
                                {!! session()->get('message') !!}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('point.store') }}">
                            @csrf
                            <div class="row mb-3">
                                <label for="city"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Город') }}</label>

                                <div class="col-md-6">
                                    <input id="city" type="text"
                                           class="form-control @error('city') is-invalid @enderror"
                                           name="city"
                                           value="{{old('city')}}"
                                           required autofocus>

                                    @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="address"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Адрес') }}</label>

                                <div class="col-md-6">
                                    <textarea id="address" type="text"
                                              class="form-control @error('address') is-invalid @enderror"
                                              name="address"
                                              required
                                    >{{old('address')}}</textarea>

                                    @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="is_active"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Действующая точка?') }}</label>

                                <div class="col-md-6">
                                    <select class="form-select @error('is_active') is-invalid @enderror"
                                            aria-label="Действующая точка?"
                                            name="is_active">
                                        <option value="1" selected>
                                            ДА
                                        </option>
                                        <option value="2" >
                                            НЕТ
                                        </option>
                                    </select>

                                    @error('is_active')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="router"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Модель роутера') }}</label>

                                <div class="col-md-6">
                                    <input id="router" type="text"
                                           class="form-control @error('router') is-invalid @enderror"
                                           name="router"
                                           value="{{old('router')}}"
                                    >

                                    @error('router')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="lan_ip"
                                       class="col-md-4 col-form-label text-md-end">{{ __('LAN IP') }}</label>

                                <div class="col-md-6">
                                    <input id="lan_ip" type="text" size="16"
                                           class="form-control @error('lan_ip') is-invalid @enderror"
                                           name="lan_ip"
                                           pattern="^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$"
                                           value="{{old('lan_ip')}}"
                                    >

                                    @error('lan_ip')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="vpn_ip"
                                       class="col-md-4 col-form-label text-md-end">{{ __('VPN IP') }}</label>

                                <div class="col-md-6">
                                    <input id="vpn_ip" type="text" size="16"
                                           class="form-control @error('vpn_ip') is-invalid @enderror"
                                           name="vpn_ip"
                                           pattern="^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$"
                                           value="{{old('vpn_ip')}}"
                                    >

                                    @error('vpn_ip')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="wan_ip"
                                       class="col-md-4 col-form-label text-md-end">{{ __('WAN IP') }}</label>

                                <div class="col-md-6">
                                    <input id="wan_ip" type="text" size="16"
                                           class="form-control @error('wan_ip') is-invalid @enderror"
                                           name="wan_ip"
                                           pattern="^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$"
                                           value="{{old('wan_ip')}}"
                                    >

                                    @error('wan_ip')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="telephony_status"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Статус телефонии') }}</label>

                                <div class="col-md-6">
                                    <select class="form-select @error('telephony_status') is-invalid @enderror"
                                            aria-label="Статус телефонии"
                                            name="telephony_status">
                                        <option value="1">
                                            Готова
                                        </option>
                                        <option selected value="2">
                                            Не готова
                                        </option>
                                    </select>

                                    @error('telephony_status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="provider"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Провайдер') }}</label>

                                <div class="col-md-6">
                                    <input id="provider" type="text"
                                           class="form-control @error('provider') is-invalid @enderror"
                                           name="provider"
                                           value="{{old('provider')}}"
                                    >

                                    @error('provider')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="login"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Логин') }}</label>

                                <div class="col-md-6">
                                    <input id="login" type="text"
                                           class="form-control @error('login') is-invalid @enderror"
                                           name="login"
                                           value="{{old('login')}}"
                                    >

                                    @error('login')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Пароль') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="text"
                                           class="form-control @error('password') is-invalid @enderror"
                                           name="password"
                                           value="{{old('password')}}"
                                    >

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="ups"
                                       class="col-md-4 col-form-label text-md-end">{{ __('UPS') }}</label>

                                <div class="col-md-6">
                                    <textarea id="ups" type="text"
                                              class="form-control @error('ups') is-invalid @enderror"
                                              name="ups"
                                    >{{old('ups')}}</textarea>

                                    @error('ups')
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
