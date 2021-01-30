@extends('layouts.app')

@section('title', $ad->title)

@section('custom_css')
    <link href="/css/lightbox.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css"
          integrity="sha256-2XFplPlrFClt0bIdPgpz8H7ojnk10H69xRqd9+uTShA=" crossorigin="anonymous">
@endsection

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

                        @if(Auth::id() !== $ad->user->id)
                            <button id="modal" type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#exampleModal" data-whatever="{{ $ad->user->name }}">Написать сообщение
                            </button>
                        @endif
                    </div>
                    @if(Auth::id() === $ad->user->id)
                        <a href="{{ route('ad.edit', $ad) }}">
                            <button class="btn btn-primary">Редактировать</button>
                        </a>
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


    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Новое сообщение</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('message') }}" method="post">
                        @csrf
                        <input type="hidden" value="{{ $ad->user->id }}" name="receiver_id">
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Получатель:</label>
                            <input type="text" class="form-control" id="recipient-name" readonly
                                   value="{{ $ad->user->name }}">
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Сообщение:</label>
                            <textarea class="form-control" id="message-text" name="message"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                            <button type="submit" class="btn btn-primary">Отправить сообщение</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('custom_js')
    <script src="/js/lightbox-plus-jquery.min.js"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        var titleOld = document.title;
        $(document).ready(function () {
            var pusher = new Pusher('2b4af12051c497449641', {
                cluster: 'eu'
            });

            var channel = pusher.subscribe('my-channel');
            channel.bind('my-event', function (data) {

                var isOldTitle = true;
                var newTitle = "Новое сообщение";
                var interval = null;

                function changeTitle() {
                    document.title = isOldTitle ? titleOld : newTitle;
                    isOldTitle = !isOldTitle;
                }
                interval = setInterval(changeTitle, 700);

                $(window).focus(function () {
                    clearInterval(interval);
                    $("title").text(titleOld);
                });
            });

        });
    </script>
@endsection
