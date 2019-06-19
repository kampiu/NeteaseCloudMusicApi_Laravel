<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            *{
                padding: 0;
                margin: 0;
                box-sizing: border-box;
            }
            html,body{
                width: 100%;
                min-height: 10vh;
            }
            ul{
                margin: 20px 0 0 50px;
            }
            ul > li{
                list-style: none;
                width: 100%;
                height: 50px;
                overflow: hidden;
                display:flex;
                padding:0 20px;
                background-color:#Fff;
            }
            ul > li:nth-child(odd){
                background-color:#f4f4f4;
            }
            li span{
                width: 80px;
                display:flex;
                line-height: 50px;
                font-size: 14px;
                font-weight: bold;
                margin:0 20px;
            }
            li img{
                width: 40px;
                height: 40px;
            }
        </style>
    </head>
    <body>
        <ul>
            @foreach($user as $item)
            <li>
                <span>{{$item['wx_nickname']}}</span>
                <img src="{{$item['wx_avatarUrl']}}" alt="">
            </li>
            @endforeach
        </ul>
    </body>
</html>
