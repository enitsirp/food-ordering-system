@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        @if ($message = Session::get('success'))
								<div class="row">
									<div class="col">
										<div class="alert alert-light alert-success alert-elevate fade show	" role="alert">
											<div class="alert-icon"><i class="flaticon-warning kt-font-brand"></i></div>
											<div class="alert-text">
												{{ $message }}
											</div>
											<div class="alert-close">
												<button type="button" class="close" data-dismiss="alert" aria-label="Close">
													<span aria-hidden="true"><i class="la la-close"></i></span>
												</button>
											</div>
										</div>
									</div>
								</div>
								@endif
								@if ($message = Session::get('error'))
								<div class="row">
									<div class="col">
										<div class="alert alert-light alert-danger alert-elevate fade show	" role="alert">
											<div class="alert-icon"><i class="flaticon-warning kt-font-brand"></i></div>
											<div class="alert-text">
												{{ $message }}
											</div>
											<div class="alert-close">
												<button type="button" class="close" data-dismiss="alert" aria-label="Close">
													<span aria-hidden="true"><i class="la la-close"></i></span>
												</button>
											</div>
										</div>
									</div>
								</div>
								@endif
      </div>

    <div class="row justify-content-center">

        @foreach ($menu_categories as $category)
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">

                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $category->category }}</div>
                            </div>
                            <div class="col-auto">
                                <a href="{{ url('/orders/'.$category->id) }}" class="btn btn-primary">Order now</a>
                            </div>
                        </div>
                    </div>
                    <img src="{{ asset('images/'.$category->image) }}" class="card-img-top" style=""  alt="{{ $category->description }}">
                </div>
            </div>
        @endforeach

    </div>
</div>
@endsection
