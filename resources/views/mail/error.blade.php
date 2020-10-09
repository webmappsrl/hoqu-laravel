<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Hoqu Error</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/1.8.12/tailwind.min.css" integrity="sha512-KO1h5ynYuqsFuEicc7DmOQc+S9m2xiCKYlC3zcZCSEw0RGDsxcMnppRaMZnb0DdzTDPaW22ID/gAGCZ9i+RT/w==" crossorigin="anonymous" />
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a , .small {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Error Hoqu:
                </div>

                <div class="small">
                    id: {{ $mail_data['id'] }}<br/>
                </div>

                <div class="small">
                    id_server: {{ $mail_data['id_server'] }}<br/>
                </div>

                <div class="small">
                    task: {{ $mail_data['job'] }}<br/>
                </div>

                <div class="small">
                    process_status: {{ $mail_data['process_status'] }}<br>
                </div>

                <div class="small">
                    process_log: {{ $mail_data['process_log'] }}<br/>
                </div>
                <div class="small">
                    <button class="bg-blue hover:bg-blue-light text-white font-bold py-2 px-4 border-b-4 border-blue-dark hover:border-blue rounded"><a href="http://hoqu-laravel.test/error"> Go to Error</a>

                </div>
        </div>

  </button>
    </body>
</html>


















