<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />


    </head>
    <body class="antialiased">
        <div class="d-flex justify-content-center align-items-end w-100 vh-100">
            <div class="w-100 p-4">
                <div id="mesg-box">
                    {{-- ...  --}}
                </div>
                <form method="post" onsubmit="sendMessage(event)">
                    <input type="text" id="message" class="form-control w-75 d-inline-block" name="message" placeholder="Type your message here">
                    <button type="submit" class="btn btn-primary mb-1">Send</button>
                </form>
            </div>
        </div>
    </body>

    @vite('resources/js/app.js')

    <script type="text/javascript">
    var userId = Math.floor(Math.random() * 100000);
    // laravel echo listening channel
    document.addEventListener('DOMContentLoaded', function () {
        window.Echo.channel('test-event')
        // very important shit thing is '.' prefix in event name in listening
        // it took me 24 hours to find solution, everything is working, but listening not working
        // this stupid. be careful
            .listen('.chatEvent', (data) => {
                // console.log('message => ' + data.data.message);
                // console.log('user id => ' + data.data.user_id);

                if(userId === data.data.user_id) {
                    // append message to message box
                    document.getElementById('mesg-box').insertAdjacentHTML('beforeend', `<div class="sent-msg text-end w-100"><p class="p-2 px-3  bg-primary d-inline-block rounded-pill">${data.data.message}</p></div>`);
                    // clear input field
                    document.getElementById('message').value = '';
                } else {
                    // append message to message box
                    document.getElementById('mesg-box').insertAdjacentHTML('beforeend', `<div class="sent-msg w-100"><p class="p-2 px-3  bg-secondary d-inline-block rounded-pill">${data.data.message}</p></div>`);
                }
            });

    });

    function sendMessage(e) {
        e.preventDefault();
        // post Message with fetch request
        fetch('/test-event', {
            method: 'post',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({
                data: {
                    message: document.getElementById('message').value,
                    user_id: userId,
                },
            }),
        })
       .then(response => {
        // console.log(response.json());
       })
    }
    </script>
</html>
