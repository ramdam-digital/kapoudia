
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>Ramdam CMS</title>
    <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="{{URL::base()}}/backend/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }

      @media (max-width: 980px) {
        /* Enable use of floated navbar text */
        .navbar-text.pull-right {
          float: none;
          padding-left: 5px;
          padding-right: 5px;
        }
      }
    </style>
    <link href="{{URL::base()}}/backend/css/bootstrap-responsive.css" rel="stylesheet">
    
    <script src="{{URL::base()}}/backend/js/jquery.js"></script>
    <script src="{{URL::base()}}/backend/js/jquery-ui.min.js"></script>
<script src="{{URL::base()}}/backend/js/bootstrap.js"></script>

    @yield('headers')

  </head>

  <body>
<div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="{{URL::to_route('admin')}}">Ramdam CMS</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li><a href="{{URL::to_route('manage_menu', array(0))}}">Gestion des menus</a></li>
              <li><a href="{{URL::to_route('manage_user')}}">Gestion des utilisateurs</a></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Gestion de contenu <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="{{URL::to_route('manage_page')}}">Gestion des pages</a></li>
                  <li><a href="{{URL::to_route('manage_event')}}">Gestion des événements</a></li>
                  <li><a href="{{URL::to_route('manage_faq')}}">Gestion des FAQs</a></li>
                  <li><a href="{{URL::to_route('manage_category')}}">Gestion des catégories</a></li>
                  <li><a href="{{URL::to_route('degustation')}}">Dégustation</a></li>
                </ul>
              </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">E-Shop <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="{{URL::to_route('manage_product')}}">Gestion des produits</a></li>
                </ul>
              </li>
            </ul>
            <ul class="nav pull-right">  
			  <li class="dropdown">  
			    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
			    	<i class="icon-user icon-white"></i> {{Auth::user()->nickname}}<b class="caret"></b>
			    </a>  
			    <ul class="dropdown-menu">  
			     <li><a href="#">Modifier mon profil</a></li>
                  <li><a href="{{URL::to_route('logout')}}">Deconnexion</a></li>
			    </ul>  
			  </li>  
			</ul>  
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>


    <div class="container">
      
    @if(Session::has('message'))
    <div class="alert alert-success">
      <button type="button" class="close" data-dismiss="alert">×</button>
      {{ Session::get('message') }}
    </div>
    @endif

    @if(Session::has('warning'))
    <div class="alert">
      <button type="button" class="close" data-dismiss="alert">×</button>
      {{ Session::get('warning') }}
    </div>
    @endif

    @if(Session::has('error'))
    <div class="alert alert-error">
      <button type="button" class="close" data-dismiss="alert">×</button>
      {{ Session::get('error') }}
    </div>
    @endif



      @yield('content')
      

    </div> <!-- /container -->



@yield('scripts')

  </body>
</html>


