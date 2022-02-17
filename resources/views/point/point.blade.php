@extends('point.layout')

@section('point_map')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header point-card__header">
                    <div class="point-card-title__text">
                        {{$point->address}}
                    </div>
                    <div class="point-card-title__group-button">
                        <a href="{{ route('point.edit', ['point' => $point]) }}" class="btn btn-success btn-sm">Редактировать</a>
                        <a href="{{ route('point.close-point', ['point' => $point]) }}" class="btn btn-warning btn-sm">Закрыть
                            точку</a>
                    </div>
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

                                    <div>
                                        <strong>{{ __('Адрес: ') }}</strong>{{ $point->city . ', ' . $point->address }}
                                    </div>
                                    <div>
                                        <strong>{{ __('Роутер: ') }}</strong>{{ $point->router }}
                                    </div>
                                    <div>
                                        <strong>{{ __('LAN ip: ') }}</strong>
                                        @isset($point->lan_ip)
                                            <a href="{{ 'http://' . $point->lan_ip }}" class="link-dark rounded"
                                               target="_blank">{{ 'http://' . $point->lan_ip }}</a>
                                            <span class="badge bg-warning text-dark point-view__exec"
                                                  data-ip="{{ $point->lan_ip }}"
                                                  data-action="lan"
                                            >
                                            PING
                                        </span>
                                        @endisset
                                    </div>
                                    <div class="point-view__screen point-view__screen-lan point-view__miracle"
                                         style="display: none">
                                        Loading ...
                                    </div>

                                    <div>
                                        <strong>{{ __('VPN ip: ') }}</strong>
                                        @isset($point->vpn_ip)
                                            {{$point->vpn_ip}}
                                            <span class="badge bg-warning text-dark point-view__exec"
                                                  data-ip="{{ $point->vpn_ip }}"
                                                  data-action="vpn"
                                            >
                                            PING
                                        </span>
                                        @endisset
                                    </div>
                                    <div class="point-view__screen point-view__screen-vpn point-view__miracle"
                                         style="display: none">
                                        Loading ...
                                    </div>

                                    <div>
                                        <strong>{{ __('WAN ip: ') }}</strong>
                                        @isset($point->wan_ip)
                                            {{$point->wan_ip}}
                                            <span class="badge bg-warning text-dark point-view__exec"
                                                  data-ip="{{ $point->wan_ip }}"
                                                  data-action="wan"
                                            >
                                            PING
                                        </span>
                                        @endisset
                                    </div>
                                    <div class="point-view__screen point-view__screen-wan point-view__miracle"
                                         style="display: none">
                                        Loading ...
                                    </div>

                                    <div>
                                        <strong>{{ __('Статус телефонии: ') }}</strong>
                                        @if($point->telephony_status)
                                            {{ __('Готово')}}
                                        @else
                                            {{ __('Не готова')}}
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
                                        <div class="point-contract-item__edit d-grid col-8 mx-auto mt-2">
                                            <a class="btn btn-primary btn-sm"
                                               href="{{ route('contract.edit', ['contract' => $point->contract]) }}">
                                                Перепривязать/отредактировать договор
                                            </a>
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
                                            <div><strong>{{ __('SN: ') }}</strong>{{$printer->serial_number}}</div>
                                            <div>
                                                <strong>{{ __('Описание: ') }}</strong>{{$printer->description}}
                                            </div>
                                            <div>
                                                <strong>{{ __('Есть запасной картридж?: ') }}</strong>
                                                @if(isset($printer->is_spare) && $printer->is_spare === true)
                                                    есть
                                                @else
                                                    нет
                                                @endisset
                                            </div>

                                            <div class="point-printer-item__edit d-grid col-8 mx-auto m-2">
                                                <a class="btn btn-primary btn-sm"
                                                   href="{{ route('printer.edit', ['printer' => $printer]) }}">
                                                    Перепривязать/отредактировать принтер
                                                </a>
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

                                            <div class="point-remote-item__edit d-grid col-8 mx-auto m-2">
                                                <a class="btn btn-primary btn-sm"
                                                   href="{{ route('remote.edit', ['remote' => $remote]) }}">
                                                    Перепривязать/отредактировать удалёнку
                                                </a>
                                            </div>

                                            @if(!$loop->last)
                                                <hr class="divider">
                                            @endif

                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                        @isset($point->devices[0]['name'])
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="panelsStayOpen-headingDevices">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#panelsStayOpen-collapseDevices" aria-expanded="true"
                                            aria-controls="panelsStayOpen-collapseDevices">
                                        Устройства (видеорегистраторы и пр.)
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseDevices" class="accordion-collapse collapse"
                                     aria-labelledby="panelsStayOpen-headingDevices">
                                    <div class="accordion-body">
                                        @foreach($point->devices as $device)
                                            <div><strong>{{ __('Устройство: ') }}</strong>{{$device->name}}</div>
                                            <div><strong>{{ __('SN: ') }}</strong>{{$device->serial_number}}</div>
                                            <div>
                                                <strong>{{ __('Описание: ') }}</strong>{{$device->description}}
                                            </div>
                                            @if(!$loop->last)
                                                <hr class="divider">
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endisset
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
@push('js')
    <script type="text/javascript">
        $('.point-view__exec').on('click', (el) => {
            const action = $(el.target).data('action');
            const ip = $(el.target).data('ip');
            $(`.point-view__screen-${action}`).fadeIn();
            $.ajax({
                method: 'get',
                url: `/point/ping/${ip}`,
                success(Response) {
                    $(`.point-view__screen-${action}`).removeClass('point-view__miracle');
                    $(`.point-view__screen-${action}`).html(Response.message.replace(/(?:\r\n|\r|\n)/g, '<br />'));
                },
                error(Error) {
                    $(`.point-view__screen-${action}`).removeClass('point-view__miracle');
                    $(`.point-view__screen-${action}`).html('Непредвиденная ошибка сервиса');
                },
            });
        });
    </script>
@endpush
