<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    let my_id = {{ Auth::id() }}
    var titleOld = document.title;
    $(document).ready(function () {
        var pusher = new Pusher('2b4af12051c497449641', {
            cluster: 'eu'
        });

        var channel = pusher.subscribe('my-channel');
        channel.bind('my-event', function (data) {
           if(my_id == data['message']['to']){
               var messages = parseInt($('a').find('.badge.badge-light').html());
               $('a').find('.badge.badge-light').html(messages + 1);

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
           }
        });

    });
</script>
