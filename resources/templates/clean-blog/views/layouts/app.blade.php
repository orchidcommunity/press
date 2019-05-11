<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="">
	
	<title>@yield('title','Последние записи') - {{setting('site_title')}}</title>
    <meta name="description" content="@yield('description',setting('site_description'))">
    <meta name="keywords" content="@yield('keywords',setting('site_keywords'))">
    @php $theme_path = '/dashboard/resources/press/'.config('press.theme'); @endphp
    <link href="{{$theme_path.'/css/app.css'}}" rel="stylesheet">
    <script src="{{$theme_path.'/js/app.js'}}"></script>


  </head>

  <body>


  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
      <div class="container">
          <a class="navbar-brand" href="/">{{setting('site_title') ?? 'Start Bootstrap'}}</a>
          <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
              Menu
              <i class="fas fa-bars"></i>
          </button>
          @menu('header')
      </div>
  </nav>

  <!-- Page Header -->
  <header class="masthead" style="background-image: url('@yield('head_image',$theme_path.'/img/home-bg.jpg')')">
      <div class="overlay"></div>
      <div class="container">
          <div class="row">
              <div class="col-lg-8 col-md-10 mx-auto">
                  <div class="site-heading post-heading">
                      <h1>{{setting('site_title') ?? 'Clean Blog'}}</h1>
                      <span class="subheading">{{setting('site_description') ?? 'A Blog Theme by Start Bootstrap'}}</span>
                      @yield('author')
                  </div>
              </div>
          </div>
      </div>
  </header>

  <!-- Main Content -->
  @yield('content')

  <hr>

  <!-- Footer -->
  <footer>
      <div class="container">
          <div class="row">
              <div class="col-lg-8 col-md-10 mx-auto">
                  <ul class="list-inline text-center">
                      <li class="list-inline-item">
                          <a href="#">
                <span class="fa-stack fa-lg">
                  <i class="fas fa-circle fa-stack-2x"></i>
                  <i class="fab fa-twitter fa-stack-1x fa-inverse"></i>
                </span>
                          </a>
                      </li>
                      <li class="list-inline-item">
                          <a href="#">
                <span class="fa-stack fa-lg">
                  <i class="fas fa-circle fa-stack-2x"></i>
                  <i class="fab fa-facebook-f fa-stack-1x fa-inverse"></i>
                </span>
                          </a>
                      </li>
                      <li class="list-inline-item">
                          <a href="#">
                <span class="fa-stack fa-lg">
                  <i class="fas fa-circle fa-stack-2x"></i>
                  <i class="fab fa-github fa-stack-1x fa-inverse"></i>
                </span>
                          </a>
                      </li>
                  </ul>
                  <p class="copyright text-muted">Copyright &copy; Your Website 2019</p>
              </div>
          </div>
      </div>
  </footer>

</body>

</html>