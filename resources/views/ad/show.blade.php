@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-xl-9">
                <div class="card-box">
                    <h2 style="display: inline-block">{{ $ad->title }}</h2>
                    <h4>{{ $ad->price }} грн</h4>
                    <hr/>
                    <div class="gallery">
                        @foreach($ad->images as $img)
                            <a href="{{ Storage::url($img->image) }}" data-lightbox="images"><img src="{{ Storage::url($img->image) }}"></a>

                        @endforeach
                    </div>
                    <hr/>
                    <p>
                        {{ $ad->description }}
                    </p>
                </div> <!-- end card-box-->
            </div> <!-- end col -->
            <div class="col-lg-3 col-xl-3">
                <div class="card-box text-center">

                    <img src="{{ Storage::url($ad->user->avatar) }}" class="rounded-circle avatar-xl img-thumbnail" alt="profile-image">

                    <h4 class="mb-0">{{ $ad->user->name }}</h4>

                    <div class="text-left mt-3">
                        @if(!is_null($ad->user->about))
                            <h4 class="font-13 text-uppercase">Обо мне :</h4>
                            <p class="text-muted font-13 mb-3">
                                {{ $ad->user->about }}
                            </p>
                        @endif


                        <p class="text-muted mb-2 font-13"><strong>Телефон :</strong><span class="ml-2">{{ $ad->user->phone }}</span></p>

                        <p class="text-muted mb-2 font-13"><strong>Почта :</strong> <span class="ml-2 ">{{ $ad->user->email }}</span>
                        </p>

                    </div>

                </div> <!-- end card-box -->
            </div>
        </div>
    </div>
@endsection
