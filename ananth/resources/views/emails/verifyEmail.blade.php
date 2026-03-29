<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Vefify Email</title>
</head>

<body>
    <p>Hello {{ $user->name }}, your account is created on Ananth Decodes Logistics.</p>
    <p>Click <a href="{{ url('/user/verify/' . $user->verifyUser->token) }}">here</a> to verify your email.</p>
    <p>Thanks!</p>
</body>

</html>
