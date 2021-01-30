<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link   rel="stylesheet"    href="{{ asset('styles/bootstrap-3.1.1/dist/css/bootstrap.min.css') }}">
    <link   rel="stylesheet"    href="{{ asset('styles/profile/style.css') }}">

    <link href="https://fonts.googleapis.com/css?family=Lato&display=swap&subset=latin-ext" rel="stylesheet">

    <title> PROFIL ADMINISTRATORA </title>
</head>
<body>

    <br><br>
    <a   href="{{URL('profile')}}"  class="link_style"> Profil </a>
    <br><br>
    <a   href="{{URL('logout')}}"  class="link_style"> Odjavi se </a>



    <div   class="container container_ext">
        <div   class="row" style="background-color: none; margin-top: 20px;" >
            <div   class="col-md-6 col-md-offset-3"  style="background-color: none; margin-left:0px;">
                @if( isset($data['LOGGED_ADMIN_INFO']) )
                        <p> Ime : <span class="container_ext_span">{{ $data['LOGGED_ADMIN_INFO']->name }}</span> </p>
                        <p> E-mail : <span class="container_ext_span">{{ $data['LOGGED_ADMIN_INFO']->email }}</span> </p>
                @endif
            </div>
        </div>
    </div>

    
    <div   class="shop_product_link_holder">
        <div>
            <a   href="{{URL('/stores/')}}"  class="link_style"> Prodavnice </a>
        </div>

        <div>
            <a   href="{{URL('/products/')}}"  class="link_style"> Proizvodi </a>
        </div>
    </div>




</body>
</html>