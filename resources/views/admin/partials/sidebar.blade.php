<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin') }}">
        <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-utensils"></i>
        </div>
        <div class="sidebar-brand-text mx-3">FOS</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item ">
        <a class="nav-link" href="{{ route('home') }}">
        <i class="fas fa-fw fa-home"></i>
        <span>Home</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Categories
    </div>

    <li class="nav-item ">
        <a class="nav-link" href="{{ url('admin/categories') }}">
        <i class="fab fa-elementor"></i>
        <span>Menus</span></a>
    </li>
    <li class="nav-item ">
        <a class="nav-link" href="{{ url('admin/coupons') }}">
        <i class="fas fa-tags"></i>
        <span>Coupons</span></a>
    </li>


   <!-- Divider -->
   <hr class="sidebar-divider">

   <!-- Heading -->
   <div class="sidebar-heading">
       Settings
   </div>

   <li class="nav-item ">
       <a class="nav-link" href="{{ route('home') }}">
        <i class="fas fa-users"></i>
       <span>Users</span></a>
   </li>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>


