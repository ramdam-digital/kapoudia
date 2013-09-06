
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>Authentification</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="{{URL::base()}}/backend/css/bootstrap.css" rel="stylesheet">
    <link href="{{URL::base()}}/backend/css/bootstrap-responsive.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }

      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }

      img{
        margin-bottom: 15px;
      }

    </style>
  </head>

  <body>

    <div class="container">

      {{ Form::open(URL::to_route('authentification'), 'POST', array('class'=>'form-signin')) }}
        <a href="http://www.ramdam.in" target="_blank"><img src="{{URL::base()}}/backend/img/ramdam.png" class="img-circle"></a>
        <!--<h2 class="form-signin-heading">Authentification</h2>-->
        @if(Session::has('login_errors'))
        <div class="text-error" style="margin-bottom:10px;">{{Lang::line('kapoudia.text5')->get()}}</div>
        @endif
        <input type="text" class="input-block-level" placeholder="Nom d'utilisateur" name="username">
        <input type="password" class="input-block-level" placeholder="Mot de passe" name="password">
        <input class="btn btn-primary" type="submit" value="Connexion">


      </form>
      

    </div> <!-- /container -->



  </body>
</html>
