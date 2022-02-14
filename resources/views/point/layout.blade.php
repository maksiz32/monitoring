@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div id="sidebarMenu" class="col-lg-2 d-block bg-light collapse">
                <div class="position-sticky pt-3">
                    <ul class="list-unstyled ps-0 left-menu__list">
                        <li class="mb-1 left-menu__list-item">
                            @foreach($points as $pointCity => $value)
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
                            @endforeach
                        </li>
                        <li class="border-top my-3"></li>
                        <a href="#" class="btn btn-outline-success">{{ __('Выгрузить') }}</a>
                    </ul>
                </div>
            </div>

            <div class="col-lg-10 px-md-4">
                @yield('point_map')
            </div>
        </div>
    </div>
@endsection
