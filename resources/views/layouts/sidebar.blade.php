  <!-- Main Sidebar Container -->
  <aside class="main-sidebar elevation-4 sidebar-light-yellow">
      <!-- Brand Logo -->
      <a href="/" class="brand-link navbar-orange">
          <img src="{{ asset('favicon.ico') }}" alt="AdminLTE Logo"
              class="brand-image img-circle elevation-3" style="opacity: .8">
          <span class="brand-text font-weight-light">MOTTO</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="image">
                  <img src="{{ asset('AdminLTE/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                      alt="User Image">
              </div>
              <div class="info">
                  <a href="#" class="d-block">{{ Auth::user()->fullname }}</a>
              </div>
          </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                  data-accordion="false">
                  <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                  <li class="nav-item">
                      <a href="/boardassignment"
                          class="nav-link {{ request()->is('boardassignment') ? 'active' : '' }}">
                          <i class="nav-icon fas fa-columns"></i>
                          <p>
                              Board Assignment
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="/projectboard" class="nav-link {{ request()->is('projectboard') ? 'active' : '' }}">
                          <i class="nav-icon fas fa-columns"></i>
                          <p>
                              Project Board
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="/story" class="nav-link {{ request()->is('story') ? 'active' : '' }}">
                          <i class="nav-icon fas fa-columns"></i>
                          <p>
                              Story
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="/sow" class="nav-link {{ request()->is('sow') ? 'active' : '' }}">
                          <i class="nav-icon fas fa-tasks"></i>
                          <p>
                              Scope Of Work
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="/technology" class="nav-link {{ request()->is('technology') ? 'active' : '' }}">
                          <i class="nav-icon fas fa-laptop"></i>
                          <p>
                              Technology
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="/trainer" class="nav-link {{ request()->is('trainer') ? 'active' : '' }}">
                          <i class="nav-icon fas fa-chalkboard-teacher"></i>
                          <p>
                              Trainer
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="/batch" class="nav-link {{ request()->is('batch') ? 'active' : '' }}">
                          <i class="nav-icon fas fa-users"></i>
                          <p>
                              Batch
                          </p>
                      </a>
                  </li>
              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>
