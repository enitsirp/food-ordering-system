@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="row">

        <div class="col-lg-12">

          <!-- Basic Card Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h5 class="m-1 font-weight-bold text-primary">{{ $menu_category->category }}</h5>
            </div>
            <div class="card-body">
                <div class="container">
                    <div class="row">


                @foreach ($menu_category->menus as $menu)

                <div class="col-lg-6">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">

                            <div class="row no-gutters align-items-center">
                                <div class="col-3 mr-2">

                                    <img src="{{ asset('images/menus/'.$menu->image) }}" class="card-img-top col-sm-12"  alt="{{ $menu->menu }}">
                                </div>
                                <div class="col-7">
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $menu->menu }} -
                                        PHP {{ $menu->total_price  }}</div>
                                        <p></p>
                                    <form action="/orders/process" method="POST" class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100">
                                        @csrf

                                        <label class="sr-only" for="inlineFormInputGroupUsername2">Username</label>
                                        <div class="input-group mb-2 mr-sm-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text mb-2">Qty.</div>
                                            </div>
                                            <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                                            <input type="number" class="form-control col-3 small" placeholder="Quantity" name="quantity" aria-label="Quantity" aria-describedby="basic-addon2" value="1">
                                            <div class="input-group-prepend">
                                                <button type="submit" class="btn btn-primary mb-2">Order</button>
                                            </div>
                                        </div>

                                    </form>


                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                @endforeach
            </div>
        </div>
            </div>
          </div>

        </div>
    </div>
</div>

@endsection
