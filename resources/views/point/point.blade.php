@extends('point.layout')

@section('point_map')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header point-card__header">{{$point->address}}
                    <a href="#" class="btn btn-success btn-sm">Редактировать</a>
                </div>
                <div class="card-body">
                    <div class="accordion" id="accordionPanelsStayOpenExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#panelsStayOpen-collapseMain" aria-expanded="true"
                                        aria-controls="panelsStayOpen-collapseOne">
                                    Общее
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseMain" class="accordion-collapse collapse show"
                                 aria-labelledby="panelsStayOpen-headingMain">
                                <div class="accordion-body">

                                    <div><strong>{{ __('Адрес: ') }}</strong>{{ $point->city . ', ' . $point->address }}
                                    </div>
                                    <div><strong>{{ __('Роутер: ') }}</strong>{{ $point->router }}</div>
                                    <div><strong>{{ __('LAN ip: ') }}</strong>
                                        <a href="{{ 'http://' . $point->lan_ip }}" class="link-dark rounded"
                                           target="_blank">{{ 'http://' . $point->lan_ip }}</a>
                                    </div>
                                    <div><strong>{{ __('VPN ip: ') }}</strong>{{$point->vpn_ip }}</div>
                                    <div><strong>{{ __('WAN ip: ') }}</strong>{{$point->wan_ip }}</div>
                                    <div>
                                        <strong>{{ __('Статус телефонии: ') }}</strong>
                                        @if($point->telephony_status)
                                            {{ __('Готово')}}
                                        @endif
                                    </div>
                                    <div><strong>{{ __('Провайдер: ') }}</strong>{{$point->provider }}</div>
                                    <div><strong>{{ __('Логин: ') }}</strong>{{$point->login }}</div>
                                    <div><strong>{{ __('Пароль: ') }}</strong>{{$point->password }}</div>
                                </div>
                            </div>
                        </div>
                        @if(isset($point->contract->number))
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="panelsStayOpen-headingContract">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#panelsStayOpen-collapseContract" aria-expanded="true"
                                            aria-controls="panelsStayOpen-collapseContract">
                                        Договор
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseContract" class="accordion-collapse collapse"
                                     aria-labelledby="panelsStayOpen-headingContract">
                                    <div class="accordion-body">
                                        <div><strong>{{ __('Договор: ') }}</strong>{{$point->contract->number }}</div>
                                        <div>
                                            <strong>{{ __('На кого договор: ') }}</strong>{{$point->contract->contracts_master }}
                                        </div>
                                        <div><strong>{{ __('Скорость: ') }}</strong>{{$point->contract->speed }}</div>
                                        <div><strong>{{ __('Стоимость: ') }}</strong>{{$point->contract->price }}</div>
                                        <div>
                                            <strong>{{ __('Логин PPPoE: ') }}</strong>{{$point->contract->login_pppoe }}
                                        </div>
                                        <div>
                                            <strong>{{ __('Пароль PPPoE: ') }}</strong>{{$point->contract->password_pppoe }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @isset($point->printers[0]['name'])
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="panelsStayOpen-headingPrinter">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#panelsStayOpen-collapsePrinter" aria-expanded="true"
                                            aria-controls="panelsStayOpen-collapsePrinter">
                                        Принтеры
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapsePrinter" class="accordion-collapse collapse"
                                     aria-labelledby="panelsStayOpen-headingPrinter">
                                    <div class="accordion-body">
                                        @foreach($point->printers as $printer)
                                            <div><strong>{{ __('Принтер: ') }}</strong>{{$printer->name}}</div>
                                            <div>
                                                <strong>{{ __('Описание: ') }}</strong>{{$printer->description}}
                                            </div>
                                            <div>
                                                <strong>{{ __('Есть запасной картридж?: ') }}</strong>
                                                @if(isset($printer->pivot->is_spare) && $printer->pivot->is_spare === true)
                                                    есть
                                                @else
                                                    нет
                                                @endisset
                                            </div>
                                            @if(!$loop->last)
                                                <hr class="divider">
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endisset
                        @if(isset($point->remotes[0]['number']))
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="panelsStayOpen-headingRemote">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#panelsStayOpen-collapseRemote" aria-expanded="true"
                                            aria-controls="panelsStayOpen-collapseRemote">
                                        Удалённое управление
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseRemote" class="accordion-collapse collapse"
                                     aria-labelledby="panelsStayOpen-headingRemote">
                                    <div class="accordion-body">
                                        @foreach($point->remotes as $remote)
                                            <div><strong>{{ __('Номер: ') }}</strong>{{$remote->number}}</div>
                                            @isset($remote->description)
                                            <div>
                                                <strong>{{ __('Описание: ') }}</strong>{{$remote->description}}
                                            </div>
                                            @endisset
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                        @isset($point->ups)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingUPS">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#panelsStayOpen-collapseUPS" aria-expanded="true"
                                        aria-controls="panelsStayOpen-collapseUPS">
                                    УПС
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseUPS" class="accordion-collapse collapse"
                                 aria-labelledby="panelsStayOpen-headingUPS">
                                <div class="accordion-body">
                                    <div><strong>{{ __('УПС: ') }}</strong>{{$point->ups }}</div>
                                </div>
                            </div>
                        </div>
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
