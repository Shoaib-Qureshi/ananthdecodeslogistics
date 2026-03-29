<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/style.css">
    <title>Reset Password</title>
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
                    <form action="{{ route('forget.password.post') }}" method="POST">
                        @csrf
                        <h1>Let's reset!</h1>

                        <h3>Enter Your Email</h3>
                        <input name="email" type="email" placeholder="Email">
                        <p>Don't have an account? <a href="/signup/">Sign Up</a></p>
                        <button type="submit">Send Reset Link</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
