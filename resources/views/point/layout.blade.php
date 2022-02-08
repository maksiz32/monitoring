@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light collapse">
                <div class="position-sticky pt-3">
                    <ul class="list-unstyled ps-0">
                        <li class="mb-1">
                            @foreach($points as $pointCity => $value)
                                <button class="btn btn-toggle align-items-center rounded collapsed"
                                        data-bs-toggle="collapse" data-bs-target="#home-collapse-{{$loop->index}}" aria-expanded="false">
                                    {{$pointCity}}
                                </button>
                                <div class="collapse" id="home-collapse-{{$loop->index}}">
                                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                        @foreach($value as $point)
                                            <li>
                                                <a href="{{ route('point.onepoint', [$point->id]) }}"
                                                   class="link-dark rounded">{{$point->address}}</a>
                                            </li>
                                            <br/>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        </li>
                        <li class="border-top my-3"></li>
                        <a href="#" class="link-dark rounded">{{ __('Выгрузить') }}</a>
                    </ul>
                </div>
            </div>

            <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                @yield('point_map')
            </div>
        </div>
    </div>
@endsection
