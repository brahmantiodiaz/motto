  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-light navbar-orange">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
          <li class="nav-item">
              <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
              <a href="/" class="nav-link">Home</a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
              <a href="#" class="nav-link">Contact</a>
          </li>
      </ul>
      <ul class="navbar-nav ml-auto">
          <!-- Notifications Dropdown Menu -->
          <li class="nav-item">
              <a class="nav-link" href="#" role="button" onclick="$('#logout-form').submit()">
                  <i class="fas fa-sign-out-alt"></i>
              </a>
          </li>
      </ul>
  </nav>
  <form action="{{ route('logout') }}" method="post" id="logout-form" style="display: none;">
      @csrf
  </form>
  <!-- /.navbar -->
