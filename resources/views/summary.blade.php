@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">

    </div>

    <div class="row justify-content-center">

        <div class="col-xl-10 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">

                <div class="card-body">
                    <div  id="checkout-alert" class=" alert alert-success alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong id="status-alert">Thank you for your order! </strong>
                      </div>
                    <div class="row no-gutters align-items-center">
                        <h5>Orders summary</h5>

                        @php
                            $items = $order_details->items;
                            $total_amount = 0;
                        @endphp
                        <table class="table table-bordered table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>Menu</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Amount</th>
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
                                        @php
                                            $total_amount += number_format($item->quantity * $item->orderedmenu->total_price,2);
                                        @endphp
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="3" align="right"><strong> Total</strong></td>
                                        <td align="right">{{ $total_amount }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Coupon - <span class="badge badge-success"> {{ $order_details->discount->code }} </span></td>

                                        <td align="right"><strong> Discount</strong></td>
                                        <td align="right"> {{ $order_details->discount->percent }}%</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="right"><strong> Total Amount</strong></td>
                                        <td align="right">{{ $order_details->total_order }}</td>
                                    </tr>
                                @endif

                            </tbody>
                        </table>

                        <a href="/home" class="btn btn-primary btn-block">Order Again</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
