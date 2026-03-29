<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/style.css">
    <title>Update Password</title>
</head>

<body>
    <section>
        <header class="authHeader">
            <h2><a href="/"><img width="200px" src="" alt=""></a></h2>
        </header>
        <div class="container">
            <div class="col-lg-5 col-md-7 m-auto">
                <div class="authForm">
                    @if (session()->has('message'))
                        <div class="successMessage">
                            {{ session()->get('message') }}
                        </div>
                    @endif
                    @if (session()->has('errors'))
                        <div class="errorMessage">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
                    <form action="{{ route('reset.password.post') }}" method="POST">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <h1>Change Password</h1>
                        <h3>Enter Your Email</h3>
                        <input name="email" type="email" placeholder="Enter Your Email">
                        <h3>Enter New Password</h3>
                        <input name="password" type="password" placeholder="Create New Password">
                        <h3>Confirm Password</h3>
                        <input name="password_confirmation" type="password" placeholder="Confirm Password">
                        <p>Don't have an account? <a href="/signup/">Sign Up</a></p>
                        <button type="submit">Update Password</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
