@extends('layouts.app')

@section('title', 'Главная')

@section('content')
    <div class="container">
        <nav class="navbar">
            <form class="form-inline" method="GET" action="{{ route('search') }}">
                <select class="form-control" name="сity">
                    <option selected value="0">Вся Украина</option>
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}">{{ $city->city }}</option>
                    @endforeach
                </select>
                <input class="form-control mr-sm-2" name="query" type="search" placeholder="Поиск по объявлениям"
                       aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Найти</button>
            </form>
        </nav>
        <div class="row">
            <div class="col-lg-12 col-xl-12">
                @isset($query)
                    <h3>Поиск по запросу: {{ $query }}</h3>
                @endisset
                @if(session()->has('success'))
                    <div class="alert alert-success text-center" role="alert">
                        {{ session()->get('success') }}
                    </div>
                @endif
                <div class="card-box">
                    <div class="row row-cols-1 row-cols-md-4 g-4">
                        @foreach($ads as $ad)
                            <div class="col">
                                <div class="card h-60 card-item">
                                    <a href="{{ route('show', $ad) }}">
                                        <img src="{{ Storage::url($ad->images[0]->image) }}" class="card-img-top"
                                             alt="city">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $ad->title }}</h5>
                                            <p class="card-text">{{ $ad->price }} грн
                                                <br>
                                                {{ $ad->city->city . ', ' . $ad->city->region}}
                                            </p>
                                        </div>
                                    </a>
                                    <div class="card-footer">
                                        <small
                                            class="text-muted">Добавлено {{ $ad->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{ $ads->links() }}
                </div> <!-- end card-box-->
            </div> <!-- end col -->
        </div>
    </div>
@endsection
