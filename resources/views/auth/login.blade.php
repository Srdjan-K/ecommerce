

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- <link   rel="stylesheet"    href="styles/style.css"> -->
    <link   rel="stylesheet"    href="{{ asset('styles/bootstrap-3.1.1/dist/css/bootstrap.min.css') }}">


    <title>Login</title>
</head>
<body>

    <div  class="container">
        <div class="row" style="margin-top: 45px;">
            <div class="col-md-4 col-md-offset-4">
                <h4 style='text-align:center;'> Login Form </h4>
                <br>
                <form   action="{{ route('auth.check_login') }}"   method="post">
                    @csrf
                    
                    <div   class="results">
                            @if( Session::get('fail') )
                                <div   class="alert alert-danger">
                                    {{ Session::get('fail') }}
                                </div>
                            @endif
                    </div>


                    <div class="form-group">
                        <label  for="email"> E-mail </label>
                        <input  type="email" class="form-control" name="email" placeholder="enter e-mail">
                        <span   class="text-danger">@error('email'){{ $message }} @enderror</span>
                    </div>

                    <div class="form-group">
                        <label  for="password"> Password </label>
                        <input  type="password" class="form-control" name="password" placeholder="enter password">
                        <span   class="text-danger">@error('password'){{ $message }} @enderror</span>
                    </div>

                    <div class="form-group">
                        <button   type="submit"   class="btn btn-block btn-primary"> Login </button>
                    </div>
                    <br>
                    <a   href="register"> Register an new account </a>
                </form>
            </div>
        </div>

    </div>
    
</body>
</html>