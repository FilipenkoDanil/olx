@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-xl-12">
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
                                        <small class="text-muted">Добавлено {{ $ad->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div> <!-- end card-box-->

            </div> <!-- end col -->
        </div>
    </div>

@endsection
