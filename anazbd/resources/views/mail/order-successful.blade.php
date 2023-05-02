<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Anaz Order</title>
    <style>
        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            font-size: 16px;
        }

        body {
            background-color: #fff;
            margin: auto;
        }

        .container {
            max-width: 600px;
            margin: auto;
            display: flex;
            flex-direction: column;
            background-color: rgb(241, 245, 248);
            padding: 20px;
        }

        .logo {
            width: 217px;
            height: 67px;
            margin: auto;
        }

        .title {
            display: inline-block;
            font-size: 30px;
            letter-spacing: 1px;
            font-weight: bold;
            text-align: center;
            color: #555;
            padding: 30px;
        }

        p {
            padding: 10px;
            color: #777;
            line-height: 1.4rem;
        }

        .box {
            background-color: #fff;
        }

        .footer {
            font-size: 0.8rem;
            color: #777;
            margin-top: 10px;
        }
    </style>
</head>

<body>
<div class="container">
    <img src="{{asset('frontend/assets/anazlogo.png')}}" class="logo" alt="logo">

    <p class="title">Hi {{$name}}!</p>

    <div class="container box">
        <p>
            Your order #{{$order_no}} has been received.
            <br>
            We will contact you soon for your confirmation!
        </p>
    </div>

    <p class="footer"></p>
</div>
</body>

</html>
