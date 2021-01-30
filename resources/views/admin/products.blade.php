<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link   rel="stylesheet"    href="{{ asset('styles/bootstrap-3.1.1/dist/css/bootstrap.min.css') }}">
    <link   rel="stylesheet"    href="{{ asset('styles/profile/style.css') }}">

    <link href="https://fonts.googleapis.com/css?family=Lato&display=swap&subset=latin-ext" rel="stylesheet">

    <title> Proizvodi </title>
</head>
<body>  


<br><br>
<a   href="{{URL('profile')}}"  class="link_style"> Profil </a>
<br><br>
<a   href="{{URL('logout')}}"  class="link_style"> Odjavi se </a>



<?php

    if( session()->has("data_session") ){
        $data_session = session()->get('data_session');
        if( isset($data_session['action'])  &&   $data_session['action'] != "product_view_all"  &&   $data_session['action'] != "product_view_specific"  &&  $data_session['action'] != "product_add"  &&  $data_session['action'] != "product_delete" && $data_session['action'] != "product_update" && $data_session['action'] != "product_update_and_save"){
            unset($data_session);
        }
    }else{
        $data_session = "";
    }

?>



        
<?php

        if( isset($data['LIST_OF_PRODUCTS'])  ){
            echo "<div   class='container container_ext'>";
                echo "<br>";
                echo "<h3   style='text-align:center;'> Spisak Proizvoda : </h3>";
                echo "<br>";
                echo "<table   border='4'   style='margin:auto auto; padding:10px; border:solid lightblue 2px;'>";
                    echo "<tr>";
                        echo "<td  style='padding:10px; color: rgb(212, 129, 80);'>ID</td>";
                        echo "<td  style='padding:10px; color: rgb(212, 129, 80);'>Naziv</td>";
                    echo "</tr>";

                    foreach($data['LIST_OF_PRODUCTS'] as $value){
                        echo "<tr>";
                            echo "<td  style='padding:10px; color: rgb(212, 129, 80);'>" . $value['id'] . "</td>";
                            echo "<td  style='padding:10px; color: lightblue;'><a    style='text-decoration:none; color:white;'    href=" . URL("products/" . $value['id'] ) . ">" . $value['name'] . "</a></td>";
                            
                        echo "</tr>";
                    }
                echo "</table>";
                echo "<br>";
            echo "</div>";
        }


        if( isset($data['SPECIFIC_PRODUCT']) ){
            echo "<div   class='container container_ext'>";
                echo "<br>";
                echo "<h3   style='text-align:center;'> Podaci Proizvoda : </h3>";
                echo "<br>";
                echo "<table   border='4'   style='margin:auto auto; padding:10px; border:solid lightblue 2px;'>";
                    echo "<tr>";
                        echo "<td style='padding:10px; color: rgb(212, 129, 80);'>ID</td>";
                        echo "<td style='padding:10px; color: rgb(212, 129, 80);'>Naziv</td>";
                        echo "<td style='padding:10px; color: rgb(212, 129, 80);'>Sku</td>";
                        echo "<td style='padding:10px; color: rgb(212, 129, 80);'>Opis</td>";
                        echo "<td style='padding:10px; color: rgb(212, 129, 80);'>Cena</td>";
                    echo "</tr>";

                    echo "<tr>";
                        echo "<td style='padding:10px; color: rgb(212, 129, 80);'>" . $data['SPECIFIC_PRODUCT']['id'] . "</td>";
                        echo "<td style='padding:10px; color: lightblue;'>" . $data['SPECIFIC_PRODUCT']['name'] . "</td>";
                        echo "<td style='padding:10px; color: lightblue;'>" . $data['SPECIFIC_PRODUCT']['sku'] . "</td>";
                        echo "<td style='padding:10px; color: lightblue;'>" . $data['SPECIFIC_PRODUCT']['description'] . "</td>";
                        echo "<td style='padding:10px; color: lightblue;'>" . $data['SPECIFIC_PRODUCT']['price'] . "</td>";
                    echo "</tr>";

                echo "</table>";

                echo "<br><a   class='link_style_2'      href=".URL("update_existing_product/".$data['SPECIFIC_PRODUCT']['id'] )."> Izmeni Proizvod </a><br>";
                echo "<br><a   class='link_style_2'      href=".URL("delete_specific_product/".$data['SPECIFIC_PRODUCT']['id'] )."> Obrisi Proizvod </a><br>";
                
            echo "</div>";

        }


?>

        



        <div   class="results">
                <br>
                @if( isset($data_session)   &&   !empty($data_session)  &&  isset($data_session['action'])   &&  ($data_session['action'] == "product_add"  ||  $data_session['action'] == "product_delete" ||  $data_session['action'] == "product_update"  ||  $data_session['action'] == "product_update_and_save")  &&   isset($data_session['response'])   &&   !empty($data_session['response'])   &&   isset($data_session['ind'])     &&  $data_session['ind'] == 1 )
                    <div   class="alert alert-success">
                        {{ $data_session['response'] }}
                    </div>
                @elseif( isset($data_session)   &&   !empty($data_session)  &&  isset($data_session['action'])  &&  ($data_session['action'] == "product_add"  ||  $data_session['action'] == "product_delete" ||  $data_session['action'] == "product_update"  ||  $data_session['action'] == "product_update_and_save")  &&   isset($data_session['response'])   &&   !empty($data_session['response'])   &&   isset($data_session['ind'])  &&  $data_session['ind'] == -1 )
                    <div   class="alert alert-danger">
                        {{ $data_session['response'] }}
                    </div>
                @endif
                
        </div>


        @if( isset($data['LIST_OF_PRODUCTS'])  &&  ((!isset($data_session)  ||  empty($data_session))  ||  $data_session['action'] == "product_add"  ||  $data_session['action'] == "product_delete" ||  $data_session['action'] == "product_update_and_save") )
            <form   class="new_product_form"  action="{{ route('add_new_product') }}"   method="post"  >
                    @csrf

                    <div class="form-group">
                        <label  for="name"> Naziv Proizvoda </label>
                        <input  type="text" class="form-control" name="name" placeholder="enter name" value="{{old('name')}}">
                        <span   class="text-danger">@error('name'){{ $message }} @enderror</span>
                    </div>

                    <div class="form-group">
                        <label  for="sku"> Sku </label>
                        <input  type="text" class="form-control" name="sku" placeholder="enter sku" value="{{old('sku')}}">
                        <span   class="text-danger">@error('sku'){{ $message }} @enderror</span>
                    </div>

                    <div class="form-group">
                        <label  for="description"> Opis Proizvoda </label>
                        <input  type="text" class="form-control" name="description" placeholder="enter descr" value="{{old('description')}}">
                        <span   class="text-danger">@error('description'){{ $message }} @enderror</span>
                    </div>

                    <div class="form-group">
                        <label  for="price"> Cena Proizvoda </label>
                        <input  type="text" class="form-control" name="price" placeholder="enter price" value="{{old('price')}}">
                        <span   class="text-danger">@error('price'){{ $message }} @enderror</span>
                    </div>

                    <div class="form-group">
                        <button    name="new_product" type="submit"   class="link_style_2"> Dodaj Novi Proizvod </button>
                    </div>
            </form>
        @endif
        
        




        @if( isset($data_session)   &&   !empty($data_session)  &&  $data_session['action'] == "product_update"  &&  isset($data_session['SPECIFIC_PRODUCT'])  )
            <form   class="new_product_form"   action="{{ route('update_and_save_existing_product') }}"  method='post'>
                    @csrf

                    <input   name='id'  style="display: none;"   value="{{ $data_session['product_id'] }}"></input>


                    <div class="form-group">
                        <label  for="name"> Izmeni Naziv Proizvoda </label>
                        <input  type="text" class="form-control" name="name" placeholder="enter name" value="{{ $data_session['SPECIFIC_PRODUCT']['name'] }}">
                        <span   class="text-danger">@error('name'){{ $message }} @enderror</span>
                    </div>

                    <div class="form-group">
                        <label  for="sku"> Izmeni Kod </label>
                        <input  type="text" class="form-control" name="sku" placeholder="enter sku" value="{{ $data_session['SPECIFIC_PRODUCT']['sku'] }}">
                        <span   class="text-danger">@error('sku'){{ $message }} @enderror</span>
                    </div>

                    <div class="form-group">
                        <label  for="description"> Izmeni Base Url </label>
                        <input  type="text" class="form-control" name="description" placeholder="enter description" value="{{ $data_session['SPECIFIC_PRODUCT']['description'] }}">
                        <span   class="text-danger">@error('description'){{ $message }} @enderror</span>
                    </div>

                    <div class="form-group">
                        <label  for="price"> Izmeni Opis Proizvoda </label>
                        <input  type="text" class="form-control" name="price" placeholder="enter price" value="{{ $data_session['SPECIFIC_PRODUCT']['price'] }}">
                        <span   class="text-danger">@error('price'){{ $message }} @enderror</span>
                    </div>
                    <div class="form-group">
                        <button    name="update_existing_product" type="submit"   class="link_style_2"> Izmeni Postojeci Proizvod </button>
                    </div>
            </form>
        @endif


</body>
</html>