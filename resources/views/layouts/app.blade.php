@php
    $cart_details = Auth::user()->pending();
@endphp
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Food Ordering System') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('sb-admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('sb-admin/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="">
    <div id="app">
         <!-- Page Wrapper -->
         <div id="wrapper">

            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content" class="bg-gradient-primary">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <a class="navbar-brand" href="{{ url('/home') }}">
                        <i class="fas fa-utensils"></i>  {{ config('app.name', 'Food Ordering System') }}
                    </a>

                    <!-- Topbar Navbar -->

                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - Alerts -->
                        <!-- Nav Item - Messages -->

                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link" href="#" data-toggle="modal" data-target="#cartModal">
                                <i class="fas fa-shopping-cart"></i>
                                <!-- Counter - Messages -->
                                <span class="badge badge-danger badge-counter">{{ !is_null($cart_details) ?$cart_details->items->count() : 0 }}</span>
                                </a>

                        </li>
                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">  {{ Auth::user()->full_name }}</span>
                                <img class="img-profile rounded-circle" src="https://source.unsplash.com/QAB-WJcbgJk/60x60">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">


                                @if (Auth::user()->is_admin)
                                    <a class="dropdown-item" href="{{ route('admin') }}">
                                        <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i> Dashboard
                                    </a>
                                @endif

                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                                </a>
                            </div>
                        </li>
                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                @yield('content')
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; Your Website {{ date('Y') }}</span>
                </div>
                </div>
            </footer>
            <!-- End of Footer -->

            </div>
            <!-- End of Content Wrapper -->

        </div>
        <!-- End of Page Wrapper -->

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <!-- Logout Modal-->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>

                </div>
            </div>
            </div>
        </div>

        @if (!is_null($cart_details))
            <!-- Cart Modal-->
                <div class="modal fade" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="cartModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">


                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="cartModalLabel"><i class="fas fa-shopping-cart"></i> Checkout Order</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        </div>

                            <div class="modal-body">
                                <div  id="checkout-alert" class=" alert  alert-dismissible fade show" style="display: none" >
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong id="status-alert">Success!</strong> <span id="status-message"> Indicates a successful or positive action. </span>
                                  </div>
                                @php
                                    $items = $cart_details->items
                                @endphp
                                <h5>Orders</h5>
                                <table class="table table-bordered table-sm">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Menu</th>
                                            <th>Qty</th>
                                            <th>Price</th>
                                            <th>Total Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($items)
                                            @foreach ($items as $item)
                                                <tr>
                                                <td> {{ $item->orderedmenu->menu  }}</td>
                                                <td>{{ $item->quantity  }}</td>
                                                <td align="right"> {{ $item->orderedmenu->total_price  }}</td>
                                                <td align="right">{{ number_format($item->quantity * $item->orderedmenu->total_price,2)  }}</td>
                                                </tr>
                                            @endforeach

                                            <tr>
                                                <td colspan="3" align="right"><strong> Total</strong></td>
                                                <td align="right">{{ $cart_details->total_order }}</td>
                                            </tr>
                                        @endif

                                    </tbody>
                                </table>
                                <form id="checkout-form">
                                    <div class="input-group mb-2 mr-sm-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text mb-2 ">Coupon</div>
                                        </div>
                                        @csrf
                                        <input type="hidden" name="order_id" id="order_id" value="{{ $cart_details->id }}">
                                        <input type="text" class="form-control small" placeholder="Enter Valid Coupon" name="coupon" aria-label="Coupon" aria-describedby="basic-addon2">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                <button class="btn btn-primary" type="button" id="checkout-btn"><i class="fas fa-shopping-basket"></i> Checkout</button>
                            </div>

                    </div>
                </form>
                    </div>
                </div>
        @endif

    </div>


        <!-- Bootstrap core JavaScript-->
        <script src="{{ asset('sb-admin/vendor/jquery/jquery.min.js') }}"></script>

        <!-- Core plugin JavaScript-->
        <script src="{{ asset('sb-admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
        <!-- Custom scripts for all pages-->
        <script src="{{ asset('sb-admin/js/sb-admin-2.min.js') }}"></script>
        <script>
            $(document).ready(function() {

                $('#checkout-btn').on('click', function (e) {
                    event.preventDefault();
                    var form = $('#checkout-form').serialize();
                    $.ajax({
                        type:"post",
                        url: "/orders/checkout",
                        data: form ,
                        success:function(response)
                        {
                          window.location = '/orders/summary'+ $('#order_id').val();
                        },
                        error: function(error)
                        {
                            $('#checkout-alert').show();
                            $('#checkout-alert').addClass('alert-danger');
                            $('#status-alert').html('Warning');
                            $('#status-message').html(error.responseJSON.message);
                            console.log(error.responseJSON.message);

                        }
                    });


                });

            });
        </script>
</body>
</html>
