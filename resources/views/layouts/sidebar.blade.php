<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
        <a class="sidebar-brand brand-logo" href="index.html"><img src="{{asset('/images/logo.svg')}}" alt="logo" /></a>
        <a class="sidebar-brand brand-logo-mini" href="index.html"><img src="{{asset('/images/logo-mini.svg')}}" alt="logo" /></a>
    </div>
    <ul class="nav">
        <li class="nav-item profile">
            <div class="profile-desc">
                <div class="profile-pic">
                    <div class="count-indicator">
                        <img class="img-xs rounded-circle " src="{{auth()->user()->photo}}" alt="">
                        <span class="count bg-success"></span>
                    </div>
                    <div class="profile-name">
                        <h5 class="mb-0 font-weight-normal">{{auth()->user()->name}}</h5>
                        <span>{{auth()->user()->email}}</span>
                    </div>
                </div>
                <a href="#" id="profile-dropdown" data-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></a>
                <div class="dropdown-menu dropdown-menu-right sidebar-dropdown preview-list" aria-labelledby="profile-dropdown">
                    <a href="#" class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                <i class="mdi mdi-settings text-primary"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject ellipsis mb-1 text-small">Account settings</p>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                <i class="mdi mdi-onepassword  text-info"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject ellipsis mb-1 text-small">Change Password</p>
                        </div>
                    </a>
                </div>
            </div>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="{{route('dashboard')}}">
              <span class="menu-icon">
                <i class="mdi mdi-speedometer"></i>
              </span>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        @can('users')
        <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
              <span class="menu-icon">
                <i class="mdi mdi-security"></i>
              </span>
                <span class="menu-title">User Pages</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="auth">
                <ul class="nav flex-column sub-menu">
                    @can('users')
                        <li class="nav-item"> <a class="nav-link" href="{{route('users.index')}}">Users List</a></li>
                    @endcan
                    @can('add user')
                        <li class="nav-item"> <a class="nav-link" href="{{route('users.create')}}">Add User</a></li>
                    @endcan
                </ul>
            </div>
        </li>
        @endcan
        @can('roles')
        <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#roles" aria-expanded="false" aria-controls="auth">
              <span class="menu-icon">
                <i class="mdi mdi-security"></i>
              </span>
                <span class="menu-title">Roles</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="roles">
                <ul class="nav flex-column sub-menu">
                    @can('roles')
                        <li class="nav-item"> <a class="nav-link" href="{{route('roles.index')}}">Roles List</a></li>
                    @endcan
                    @can('add role')
                        <li class="nav-item"> <a class="nav-link" href="{{route('roles.create')}}">Add Role</a></li>
                    @endcan
                </ul>
            </div>
        </li>
        @endcan
        @can('groups')
            <li class="nav-item menu-items">
                <a class="nav-link" data-toggle="collapse" href="#groups" aria-expanded="false" aria-controls="auth">
              <span class="menu-icon">
                <i class="mdi mdi-security"></i>
              </span>
                    <span class="menu-title">Groups</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="groups">
                    <ul class="nav flex-column sub-menu">
                        @can('groups')
                            <li class="nav-item"> <a class="nav-link" href="{{route('groups.index')}}">Groups List</a></li>
                        @endcan
                        @can('add groups')
                            <li class="nav-item"> <a class="nav-link" href="{{route('groups.create')}}">Add Group</a></li>
                        @endcan
                    </ul>
                </div>
            </li>
        @endcan
        @can('groups')
            <li class="nav-item menu-items">
                <a class="nav-link" data-toggle="collapse" href="#tasks" aria-expanded="false" aria-controls="auth">
              <span class="menu-icon">
                <i class="mdi mdi-security"></i>
              </span>
                    <span class="menu-title">Tasks</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="tasks">
                    <ul class="nav flex-column sub-menu">
                        @can('groups')
                            <li class="nav-item"> <a class="nav-link" href="{{route('tasks.index')}}">Tasks List</a></li>
                        @endcan
                        @can('add groups')
                            <li class="nav-item"> <a class="nav-link" href="{{route('tasks.create')}}">Add Task</a></li>
                        @endcan
                    </ul>
                </div>
            </li>
        @endcan
        <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#comunity" aria-expanded="false" aria-controls="auth">
              <span class="menu-icon">
                <i class="mdi mdi-security"></i>
              </span>
                <span class="menu-title">Community</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="comunity">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{url('community/groups')}}">Community Groups</a></li>
                </ul>
            </div>
        </li>
    </ul>
</nav>
