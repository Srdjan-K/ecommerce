<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link   rel="stylesheet"    href="{{ asset('styles/bootstrap-3.1.1/dist/css/bootstrap.min.css') }}">
    <link   rel="stylesheet"    href="{{ asset('styles/profile/style.css') }}">

    <link href="https://fonts.googleapis.com/css?family=Lato&display=swap&subset=latin-ext" rel="stylesheet">

    <title> Prodavnica </title>
</head>
<body>  


<br><br>
<a   href="{{URL('profile')}}"  class="link_style"> Profil </a>
<br><br>
<a   href="{{URL('logout')}}"  class="link_style"> Odjavi se </a>



<?php

    if( session()->has("data_session") ){
        $data_session = session()->get('data_session');
        if( isset($data_session['action'])  &&   $data_session['action'] != "store_view_all"  &&   $data_session['action'] != "store_view_specific"  &&  $data_session['action'] != "store_add"  &&  $data_session['action'] != "store_delete" && $data_session['action'] != "store_update" && $data_session['action'] != "store_update_and_save"){
            unset($data_session);
        }
    }else{
        $data_session = "";
    }

?>



        
<?php

        if( isset($data['LIST_OF_STORES'])  ){
            echo "<div   class='container container_ext'>";
                echo "<br>";
                echo "<h3   style='text-align:center;'> Spisak Prodavnica : </h3>";
                echo "<br>";
                echo "<table   border='4'   style='margin:auto auto; padding:10px; border:solid lightblue 2px;'>";
                    echo "<tr>";
                        echo "<td  style='padding:10px; color: rgb(212, 129, 80);'>ID</td>";
                        echo "<td  style='padding:10px; color: rgb(212, 129, 80);'>Naziv</td>";
                    echo "</tr>";

                    foreach($data['LIST_OF_STORES'] as $value){
                        echo "<tr>";
                            echo "<td  style='padding:10px; color: rgb(212, 129, 80);'>" . $value['id'] . "</td>";
                            echo "<td  style='padding:10px; color: lightblue;'><a    style='text-decoration:none; color:white;'    href=" . URL("stores/" . $value['id'] ) . ">" . $value['name'] . "</a></td>";
                            
                        echo "</tr>";
                    }
                echo "</table>";
                echo "<br>";
            echo "</div>";
        }


        if( isset($data['SPECIFIC_STORE']) ){
            echo "<div   class='container container_ext'>";
                echo "<br>";
                echo "<h3   style='text-align:center;'> Podaci Prodavnice : </h3>";
                echo "<br>";
                echo "<table   border='4'   style='margin:auto auto; padding:10px; border:solid lightblue 2px;'>";
                    echo "<tr>";
                        echo "<td style='padding:10px; color: rgb(212, 129, 80);'>ID</td>";
                        echo "<td style='padding:10px; color: rgb(212, 129, 80);'>Naziv</td>";
                        echo "<td style='padding:10px; color: rgb(212, 129, 80);'>Kod</td>";
                        echo "<td style='padding:10px; color: rgb(212, 129, 80);'>URL</td>";
                        echo "<td style='padding:10px; color: rgb(212, 129, 80);'>OPIS</td>";
                    echo "</tr>";

                    echo "<tr>";
                        echo "<td style='padding:10px; color: rgb(212, 129, 80);'>" . $data['SPECIFIC_STORE']['id'] . "</td>";
                        echo "<td style='padding:10px; color: lightblue;'>" . $data['SPECIFIC_STORE']['name'] . "</td>";
                        echo "<td style='padding:10px; color: lightblue;'>" . $data['SPECIFIC_STORE']['code'] . "</td>";
                        echo "<td style='padding:10px; color: lightblue;'>" . $data['SPECIFIC_STORE']['base_url'] . "</td>";
                        echo "<td style='padding:10px; color: lightblue;'>" . $data['SPECIFIC_STORE']['description'] . "</td>";
                    echo "</tr>";

                echo "</table>";

                echo "<br><a   class='link_style_2'      href=".URL("update_existing_store/".$data['SPECIFIC_STORE']['id'] )."> Izmeni Prodavnicu </a><br>";
                echo "<br><a   class='link_style_2'      href=".URL("delete_specific_store/".$data['SPECIFIC_STORE']['id'] )."> Obrisi Prodavnicu </a><br>";
                
            echo "</div>";

        }


?>

        



        <div   class="results">
                <br>
                @if( isset($data_session)   &&   !empty($data_session)  &&  isset($data_session['action'])   &&  ($data_session['action'] == "store_add"  ||  $data_session['action'] == "store_delete" ||  $data_session['action'] == "store_update"  ||  $data_session['action'] == "store_update_and_save")  &&   isset($data_session['response'])   &&   !empty($data_session['response'])   &&   isset($data_session['ind'])     &&  $data_session['ind'] == 1 )
                    <div   class="alert alert-success">
                        {{ $data_session['response'] }}
                    </div>
                @elseif( isset($data_session)   &&   !empty($data_session)  &&  isset($data_session['action'])  &&  ($data_session['action'] == "store_add"  ||  $data_session['action'] == "store_delete" ||  $data_session['action'] == "store_update"  ||  $data_session['action'] == "store_update_and_save")  &&   isset($data_session['response'])   &&   !empty($data_session['response'])   &&   isset($data_session['ind'])  &&  $data_session['ind'] == -1 )
                    <div   class="alert alert-danger">
                        {{ $data_session['response'] }}
                    </div>
                @endif
                
        </div>


        @if( isset($data['LIST_OF_STORES'])  &&  ((!isset($data_session)  ||  empty($data_session))  ||  $data_session['action'] == "store_add"  ||  $data_session['action'] == "store_delete" ||  $data_session['action'] == "store_update_and_save") )
            <form   class="new_store_form"  action="{{ route('add_new_store') }}"   method="post"  >
                    @csrf

                    <div class="form-group">
                        <label  for="name"> Naziv Prodavnice </label>
                        <input  type="text" class="form-control" name="name" placeholder="enter name" value="{{old('name')}}">
                        <span   class="text-danger">@error('name'){{ $message }} @enderror</span>
                    </div>

                    <div class="form-group">
                        <label  for="code"> Kod </label>
                        <input  type="text" class="form-control" name="code" placeholder="enter code" value="{{old('code')}}">
                        <span   class="text-danger">@error('code'){{ $message }} @enderror</span>
                    </div>

                    <div class="form-group">
                        <label  for="base_url"> Base Url </label>
                        <input  type="text" class="form-control" name="base_url" placeholder="enter base_url" value="{{old('base_url')}}">
                        <span   class="text-danger">@error('base_url'){{ $message }} @enderror</span>
                    </div>

                    <div class="form-group">
                        <label  for="description"> Opis Prodavnice </label>
                        <input  type="text" class="form-control" name="description" placeholder="enter descr" value="{{old('description')}}">
                        <span   class="text-danger">@error('description'){{ $message }} @enderror</span>
                    </div>
                    <div class="form-group">
                        <button    name="new_store" type="submit"   class="link_style_2"> Dodaj Novu Prodavnicu </button>
                    </div>
            </form>
        @endif
        
        




        @if( isset($data_session)   &&   !empty($data_session)  &&  $data_session['action'] == "store_update"  &&  isset($data_session['SPECIFIC_STORE'])  )
            <form   class="new_store_form"   action="{{ route('update_and_save_existing_store') }}"  method='post'>
                    @csrf

                    <input   name='id'  style="display: none;"   value="{{ $data_session['store_id'] }}"></input>


                    <div class="form-group">
                        <label  for="name"> Izmeni Naziv Prodavnice </label>
                        <input  type="text" class="form-control" name="name" placeholder="enter name" value="{{ $data_session['SPECIFIC_STORE']['name'] }}">
                        <span   class="text-danger">@error('name'){{ $message }} @enderror</span>
                    </div>

                    <div class="form-group">
                        <label  for="code"> Izmeni Kod </label>
                        <input  type="text" class="form-control" name="code" placeholder="enter code" value="{{ $data_session['SPECIFIC_STORE']['code'] }}">
                        <span   class="text-danger">@error('code'){{ $message }} @enderror</span>
                    </div>

                    <div class="form-group">
                        <label  for="base_url"> Izmeni Base Url </label>
                        <input  type="text" class="form-control" name="base_url" placeholder="enter base_url" value="{{ $data_session['SPECIFIC_STORE']['base_url'] }}">
                        <span   class="text-danger">@error('base_url'){{ $message }} @enderror</span>
                    </div>

                    <div class="form-group">
                        <label  for="description"> Izmeni Opis Prodavnice </label>
                        <input  type="text" class="form-control" name="description" placeholder="enter descr" value="{{ $data_session['SPECIFIC_STORE']['description'] }}">
                        <span   class="text-danger">@error('description'){{ $message }} @enderror</span>
                    </div>
                    <div class="form-group">
                        <button    name="update_existing_store" type="submit"   class="link_style_2"> Izmeni Postojecu Prodavnicu </button>
                    </div>
            </form>
        @endif


</body>
</html>