<nav id="navbar" class="navbar">
  <div class="sidebar-toggle">
    <button class="btn ml-3" id="sidebar-toggle">
      <i class="fas fa-list visible-on-sidebar-regular" id="regular"></i>
      <i class="fas fa-align-center" id="mini"></i>
    </button>
    
    <div class="logo-container">
    <img src="{{ asset('assets/img/logo.png')}}">
    </div>
    <a class="navbar-brand l-text float-left" href="#">{{ucwords(breadcrumbize(request()->path()))}}</a>

  </div>
  <div>
  
  <ul class="nav nav-pills">
    <li>
      <a href="" data-target="#search_bar" id="search_icon" data-toggle="modal">
        <i class="fas fa-search"></i>
      </a>
    </li>
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle l-text" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">{{auth()->user()->name()}}</a>
      <div class="dropdown-menu">
        <ul>
          <li>
          <a class="dropdown-item d-text" href="#one">Profile</a>
          </li>
          <li class="">
          <a class="dropdown-item d-text" href="{{ route('logout')}}">Logout</a>
          </li>
        </ul>
      </div>
    </li>
  </ul>
</nav>
<multi-search></multi-search>