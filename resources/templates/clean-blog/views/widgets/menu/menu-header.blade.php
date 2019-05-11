<!-- Collect the nav links, forms, and other content for toggling -->
<div class="collapse navbar-collapse" id="navbarResponsive">
  <ul class="navbar-nav ml-auto">
	@include(config('press.view').'widgets.menu.menuitem',[
		'menu'=>$menu
	])
  </ul>
</div>
<!-- /.navbar-collapse -->