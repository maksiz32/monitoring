@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div id="sidebarMenu" class="col-12 col-sm-3 col-xl-2 d-block bg-light collapse">
                <div class="position-sticky pt-3">
                    <ul class="list-unstyled ps-0 left-menu__list">
                        <li class="mb-1 left-menu__list-item">
                            @foreach($points as $pointCity => $value)
                                <div>
                                <button class="btn btn-toggle align-items-center left-menu__list-city__btn rounded collapsed"
                                        data-bs-toggle="collapse" data-bs-target="#home-collapse-{{$loop->index}}"
                                        @if(isset($city) && $city == $loop->index) aria-expanded="true"
                                        @else aria-expanded="false" @endif>
                                    {{$pointCity}}
                                </button>
                                <div class="collapse @if(isset($city) && $city == $loop->index) show @endif"
                                     id="home-collapse-{{$loop->index}}">
                                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                        @foreach($value as $pointCity)
                                            <li>
                                                <a href="{{ route('point.onepoint', ['point' => $pointCity->id, 'city' => $loop->parent->index]) }}"
                                                   class="link-dark rounded-top @if(isset($point) && $pointCity->id == $point->id)left-menu__active border-bottom border-2 border-primary @endif">{{$pointCity->address}}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                </div>
                            @endforeach
                        </li>
                        <li class="border-top my-3"></li>
                        <a href="#" class="btn btn-outline-success left-menu__export-btn">
                            {{ __('Выгрузить') }}
                        </a>
                    </ul>
                    <div class="left-menu__export" style="display: none">
                        <a href="{{ route('point.export-all') }}">Выгрузить всё</a>
                        <a href="{{ route('point.export-finance') }}">Выгрузить финансы</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-9 col-xl-10 px-md-4">
                @yield('point_map')
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script type="text/javascript">
        $('.left-menu__export-btn').on('click', (ev) => {
            ev.preventDefault();
            $('.left-menu__export').fadeToggle();
        });
    </script>
@endpush
