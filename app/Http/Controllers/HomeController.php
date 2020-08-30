<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuCategory;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Coupon;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $menu_categories = MenuCategory::all();
        return view('home', compact('menu_categories'));
    }

    public function orders($category_id)
    {
        $menu_category = MenuCategory::find($category_id);
        return view('menus', compact('menu_category'));
    }

    public function processOrder(Request $request)
    {
        $menu = Menu::find($request->input('menu_id'));
        $total_order = ($request->input('quantity') * $menu->total_price);

        /* check for pending orders */
        $pending_orders = Order::pending(Auth::user()->id)->first();

        if(is_null($pending_orders)){
            $order = Order::create([
                'user_id' => Auth::user()->id,
                'total_order' => $total_order
            ]);
         }else{

            $total_order = ($total_order + $pending_orders->total_order);
            $order = Order::find($pending_orders->id);
            $order->update(['total_order' => $total_order]);

         }


        if($order){
            $order_items = OrderItem::create([
                'order_id' => $order->id,
                'menu_id' => $request->input('menu_id'),
                'quantity' => $request->input('quantity')
            ]);
        }else{
            return redirect()->route('home')->with('error', 'Something went wrong');
        }

        return redirect()->route('home')->with('success', 'Successfully added to cart');
    }

    public function checkoutOrder(Request $request)
    {

        $coupon_code = $request->input('coupon');
        $order = Order::find($request->input('order_id'));
        $invalid_coupon = false;

        if(!is_null($coupon_code)){
            $check_query = Coupon::where('code', $coupon_code);
            if($check_query->count() == 0){
                $invalid_coupon = true;
            }else{
                $coupon_details = $check_query->first();
                if($coupon_details->is_valid == false){
                    $invalid_coupon = true;
                }else{
                    $data['coupon'] = $coupon_details->id;
                    $less = (($coupon_details->percent/100)*$order->total_order);
                    $data['total_order'] = ($order->total_order - $less);
                }
            }
        }

        if($invalid_coupon == true){
            $response = response()->json(['message' => 'Invalid Coupon code'], 400);
        }else{
            $data['status'] = 'Completed';
            $order->update($data);
            $response = response()->json(['message' => 'Thank you for your order'], 200);
        }

        return $response;

    }

    public function summary($order_id)
    {
        $order_details = Order::find($order_id);
        return view('summary', compact('order_details'));
    }
}
