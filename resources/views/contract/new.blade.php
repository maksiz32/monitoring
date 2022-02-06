@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Создать/отредактировать договор') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('contract.store') }}">
                            @csrf
                            @isset($contract->id)
                                <input type="hidden" name="id" value="{{$contract->id}}">
                            @endisset

                            <div class="row mb-3">
                                <label for="number"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Номер договора') }}</label>

                                <div class="col-md-6">
                                    <input id="number" type="text"
                                           class="form-control @error('number') is-invalid @enderror" name="number"
                                           value="@isset($contract->number){{$contract->number}} @else {{old('number')}} @endisset" required autofocus>

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
                                              required>@isset($contract->contracts_master){{$contract->contracts_master}} @else {{old('contracts_master', $contract->contracts_master)}}@endisset</textarea>

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
                                           value="@isset($contract->speed){{$contract->speed}} @else {{old('speed', $contract->speed)}}@endisset">

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
                                           value="@isset($contract->price){{$contract->price}} @else {{old('price', $contract->price)}}@endisset">

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
                                           value="@isset($contract->login_pppoe){{$contract->login_pppoe}} @else {{old('login_pppoe', $contract->login_pppoe)}}@endisset">

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
                                           value="@isset($contract->password_pppoe){{$contract->password_pppoe}} @else {{old('password_pppoe', $contract->password_pppoe)}}@endisset">

                                    @error('password_pppoe')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
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
