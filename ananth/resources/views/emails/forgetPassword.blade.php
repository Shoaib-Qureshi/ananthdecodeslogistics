<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forgot Password</title>
</head>

<body>
    <p>Hi there,</p>
    <p>A request has been received to change the password of your account on Ananth Decodes Logistics.</p>
    <p>Click the link below to reset your password.</p>
    <p><strong><a href="{{ route('reset.password.get', $token) }}">Reset Password</a></strong></p>
    <p>If you did not request a password reset, you can safely ignore this message.</p>
    <p>Thanks!</p>
</body>

</html>
