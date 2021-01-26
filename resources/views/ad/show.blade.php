@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-xl-9">
                <div class="card-box">
                    <h2 style="display: inline-block; width: 80%">{{ $ad->title }}</h2>
                    <div
                        style="display: inline-block; width: 15%; text-align: right">{{ $ad->created_at->diffForHumans() }}</div>
                    <h4>{{ $ad->price }} грн</h4>
                    <hr/>
                    <div class="gallery">
                        @foreach($ad->images as $img)
                            <a href="{{ Storage::url($img->image) }}" data-lightbox="images"><img
                                    src="{{ Storage::url($img->image) }}"></a>

                        @endforeach
                    </div>
                    <hr/>
                    {{ $ad->city->city . ', ' . $ad->city->region }}
                    <hr/>
                    <p>
                        {{ $ad->description }}
                    </p>
                </div> <!-- end card-box-->
            </div> <!-- end col -->
            <div class="col-lg-3 col-xl-3">
                <div class="card-box text-center">

                    <a href="{{ route('user.profile', $ad->user) }}">
                        <img src="{{ Storage::url($ad->user->avatar) }}" class="rounded-circle avatar-xl img-thumbnail"
                             alt="profile-image">

                        <h4 class="mb-0">{{ $ad->user->name }}</h4>
                    </a>

                    <div class="text-left mt-3">
                        @if(!is_null($ad->user->about))
                            <h4 class="font-13 text-uppercase">Обо мне :</h4>
                            <p class="text-muted font-13 mb-3">
                                {{ $ad->user->about }}
                            </p>
                        @endif


                        <p class="text-muted mb-2 font-13"><strong>Телефон :</strong><span
                                class="ml-2">{{ $ad->user->phone }}</span></p>

                        <p class="text-muted mb-2 font-13"><strong>Почта :</strong> <span
                                class="ml-2 ">{{ $ad->user->email }}</span>
                        </p>
                    </div>
                    @if(Auth::id() === $ad->user->id)
                        <a href="{{ route('ad.edit', $ad) }}"><button class="btn btn-primary">Редактировать</button></a>
                        <br>
                        <br>
                        <form action="{{ route('ad.destroy', $ad->id) }}" method="POST" class="inline-block">
                            @method('DELETE')
                            @csrf
                            <button class="btn btn-danger mb-0" type="submit">Удалить объявление</button>
                        </form>

                    @endif

                </div> <!-- end card-box -->
            </div>
        </div>
    </div>
@endsection
