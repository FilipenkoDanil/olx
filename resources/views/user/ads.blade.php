@extends('layouts.app')

@section('title', 'Объявления ' . $user->name)

@section('custom_css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css" integrity="sha256-2XFplPlrFClt0bIdPgpz8H7ojnk10H69xRqd9+uTShA=" crossorigin="anonymous">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-xl-3">
                <div class="card-box text-center">

                    <a href="{{ route('user.profile', $user->id) }}">
                        <img src="{{ Storage::url($user->avatar) }}" class="rounded-circle avatar-xl img-thumbnail"
                             alt="profile-image">
                        <h4 class="mb-0">{{ $user->name }}</h4>
                        <p><span class="rating"><i
                                    class="fa fa-star"></i></span>{{ $user->rating }}</p>
                    </a>

                    <div class="text-left mt-3">
                        @if(!is_null($user->about))
                            <h4 class="font-13 text-uppercase">Обо мне :</h4>
                            <p class="text-muted font-13 mb-3">
                                {{ $user->about }}
                            </p>
                        @endif
                        <p class="text-muted mb-2 font-13"><strong>Телефон :</strong><span
                                class="ml-2">{{ $user->phone }}</span></p>

                        <p class="text-muted mb-2 font-13"><strong>Почта :</strong> <span
                                class="ml-2 ">{{ $user->email }}</span>
                        </p>
                    </div>
                </div> <!-- end card-box -->
            </div>
            <div class="col-lg-9 col-xl-9">
                <div class="card-box">
                    @if(count($user->ads))
                        <div class="row row-cols-1 row-cols-md-3 g-4">
                            @foreach($user->ads as $ad)
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
                    @else
                        <h4 class="text-center">Объявлений нет</h4>
                    @endif
                </div> <!-- end card-box-->
            </div> <!-- end col -->
        </div>
    </div>
@endsection
