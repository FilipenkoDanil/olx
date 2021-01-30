@extends('layouts.app')

@section('title', 'Сообщения')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="user-wrapper">
                    <ul class="users" id="chats">
                        @foreach($users as $user)
                            @if($user->id != Auth::id())
                                <li class="user" id="{{ $user->id }}">
                                    @if($user->unread)
                                        <span class="pending">{{ $user->unread }}</span>
                                    @endif

                                    <div class="media">
                                        <div class="media-left">
                                            <img src="{{ Storage::url($user->avatar) }}" alt="" class="media-object">
                                        </div>

                                        <div class="media-body">
                                            <p class="name">{{ $user->name }}</p>
                                            <p class="email">{{ $user->email }}</p>
                                        </div>

                                    </div>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="col-md-9" id="messages">
            </div>
        </div>
    </div>
@endsection

@section('custom_js')
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        var receiver_id = '';
        var my_id = "{{ Auth::id() }}";
        var titleOld = document.title;
        $(document).ready(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            var pusher = new Pusher('2b4af12051c497449641', {
                cluster: 'eu'
            });

            var channel = pusher.subscribe('my-channel');
            channel.bind('my-event', function (data) {

                if (my_id == data['message']['from']) {
                    $('#' + data['message']['to']).click();
                } else if (my_id == data['message']['to']) {
                    if (receiver_id == data['message']['from']) {
                        $('#' + data['message']['from']).click();
                    } else {

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




                        var pending = parseInt($('#' + data['message']['from']).find('.pending').html());

                        if (pending) {
                            $('#' + data['message']['from']).find('.pending').html(pending + 1)

                        } else {
                            $('#' + data['message']['from']).append('<span class="pending">1</span>')
                        }
                    }
                }
            });


            $('.user').click(function () {
                $('.user').removeClass('active-user');
                $(this).addClass('active-user');
                $(this).find('.pending').remove();

                receiver_id = $(this).attr('id');
                $.ajax({
                    type: "get",
                    url: "message/" + receiver_id,
                    data: "",
                    cache: false,
                    success: function (data) {
                        $('#messages').html(data);
                        scrollToBottomFunc();
                    }
                })
            })

            $(document).on('keyup', '.input-text input', function (e) {
                var message = $(this).val();

                if (e.keyCode == 13 && message != '' && receiver_id != '') {
                    $(this).val('');

                    var datasrt = "receiver_id=" + receiver_id + '&message=' + message;
                    $.ajax({
                        type: 'post',
                        url: "message",
                        data: datasrt,
                        success: function (data) {

                        },

                        error: function (jqXHR, status, err) {

                        },

                        complete: function () {
                            scrollToBottomFunc();
                        }
                    })
                }
            });
        });

        function scrollToBottomFunc() {
            $('.message-wrapper').animate({
                scrollTop: $('.message-wrapper').get(0).scrollHeight
            }, 1)
        }
    </script>
@endsection
