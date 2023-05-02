<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anaz Verification Code</title>
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

        .code {
            height: 50px;
            width: 180px;
            line-height: 50px !important;
            text-align: center;
            border-width: thin;
            border-style: dashed;
            border-radius: 5px;
            font-size: 28px;
            font-weight: bold;
            color: #ff6700f5;
            margin: 10px auto;
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

    <p class="title">Your Verification Code</p>

    <div class="container box">
        <p>Hi, In order to protect your account security, we need to verify your identity.
            Please enter below mentioned {{strlen((string) $code)}} digit code into the verification page.
        </p>
        <div class="code">
            {{$code}}
        </div>
    </div>

    <p class="footer">You have received this email because you or someone wanted to verify this email address.
        If you didnt request for verification code, please ignore this email!</p>
</div>
</body>

</html>
