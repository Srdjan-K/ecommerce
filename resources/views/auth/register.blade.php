

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link   rel="stylesheet"    href="{{ asset('styles/bootstrap-3.1.1/dist/css/bootstrap.min.css') }}">


    <title>Register</title>
</head>
<body>

    <div  class="container">
        <div class="row" style="margin-top: 45px;">
            <div class="col-md-4 col-md-offset-4">
                <h4 style='text-align:center;'> Register Form </h4>
                <br>
                <form   action="{{ route('auth.create_new_user') }}"   method="post" >
                    @csrf
                    

                    <div   class="results">
                            @if( Session::get('success') )
                                <div   class="alert alert-success">
                                    {{ Session::get('success') }}
                                </div>
                            @endif

                            @if( Session::get('fail') )
                                <div   class="alert alert-danger">
                                    {{ Session::get('fail') }}
                                </div>
                            @endif
                    </div>


                    <div class="form-group">
                        <label  for="name"> Name </label>
                        <input  type="name" class="form-control" name="name" placeholder="enter name" value="{{old('name')}}">
                        <span   class="text-danger">@error('name'){{ $message }} @enderror</span>
                    </div>

                    <div class="form-group">
                        <label  for="email"> E-mail </label>
                        <input  type="email" class="form-control" name="email" placeholder="enter e-mail"   value="{{old('email')}}">
                        <span   class="text-danger">@error('email'){{ $message }} @enderror</span>
                    </div>

                    <div class="form-group">
                        <label  for="password"> Password </label>
                        <input  type="password" class="form-control" name="password" placeholder="enter password">
                        <span   class="text-danger">@error('password'){{ $message }} @enderror</span>
                    </div>

                    <br><br>


                    <div class="form-group">
                        <button   type="submit"   class="btn btn-block btn-primary"> Register </button>
                    </div>
                    <br>
                    <a   href="login"> LogIn  </a>
                </form>
            </div>
        </div>

    </div>
    
</body>
</html>