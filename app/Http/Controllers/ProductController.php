<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\Null_;
use Session;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\Input;

class ProductController extends Controller
{
    //
    function index()
    {
//        $data = Product::all();
        $data = DB::table('products')
//            ->orderBy('id','desc')
            ->paginate(10);
        // 回首頁時,清除顯示在search bar的條件
        Session::forget('query');
        return view('product',['products' => $data]);
    }

    function detail($id)
    {
        $data = Product::find($id);
        return view('detail',['product' => $data]);
    }

    // 搜尋
    function search(Request $request)
    {
        // 開啟紀錄
        DB::connection()->enableQueryLog();
        // 資料庫查詢
        $data = Product::where('name', 'like', '%'.$request->input('query').'%')
            // 增加模糊搜尋價格
            ->orwhere('price', 'like', '%'.$request->input('query').'%')
            ->get();

        // 印出 SQL 語法
//        dd(DB::getQueryLog());
//        dd($data);

        // 用來將search.blade.php中的搜尋條件放到session中
        // 使header.blade.php可以利用session的資料,在搜尋條顯示搜尋條件
        $search = $request->input('query');
        $request->session()->put('query',$search);
//        dd($search);
        return view('search',[
            'products' => $data,
//            'search' => $search, // 如果要在search.blade.php顯示才加
        ]);
    }

    // 加品項至購物車
    function addToCart(Request $request)
    {
        // 如果有登入
        if($request->session()->has('user'))
        {
            $cart = new Cart;
            $cart->user_id = $request->session()->get('user')['id'];
            $cart->product_id = $request->product_id;
            $cart->save();

            return redirect('/');
        }
        else
        {
            return redirect('/login');
        }

    }

    // 根據 user_id 計算購物車購買數量
    static function cartItem()
    {
        $userId = Session::get('user')['id'];
        return Cart::where('user_id',$userId)->count();
    }

    function cartList(Request $request)
    {
        $userId = Session::get('user')['id'];

//        $products = DB::table('cart')
//            ->join('products','cart.product_id','=','products.id')
//            ->where('cart.user_id',$userId)
//            // 加上 cart.id as cart_id 才能在 cartlist 中取得 cart.id 用來移除購物車商品
//            ->select('products.*','cart.id as cart_id')
//            ->get();

        $cartlist_search = DB::table('cart')
            ->join('products','cart.product_id','=','products.id')
            ->where('cart.user_id',$userId)
            ->where('name', 'like', '%'.$request->input('cartlist_query').'%')
            // 增加模糊搜尋價格
//            ->orwhere('price', 'like', '%'.$request->input('cartlist_query').'%')
            ->select('products.*','cart.id as cart_id')
            ->get();

        // 存放到session內
        $search = $request->input('cartlist_query');
        $request->session()->put('cartlist_query',$search);
//        dd($tmp);
        return view('cartlist', [
//            'products' => $products,
            'cartlist_search' => $cartlist_search,
        ]);
    }

    function removeCart($id)
    {
        Cart::destroy($id);

        // 從session中取出刪除前的搜尋條件
        $old_cartlist_query = session()->all()['cartlist_query'];
//        dd($old_cartlist_query);

        return redirect('cartlist?cartlist_query=' . $old_cartlist_query);
    }

    function orderNow()
    {
        $userId = Session::get('user')['id'];
//        dd($userId);
//        $total = $products = DB::table('cart')
//            ->join('products','cart.product_id','=','products.id')
//            ->where('cart.user_id',$userId)
//            // 加上 cart.id as cart_id 才能在 cartlist 中取得 cart.id 用來移除購物車商品
//            ->sum('products.price');

        $total = $products = DB::table('cart')
            ->join('products','cart.product_id','=','products.id')
            ->where('cart.user_id',$userId)
            // 加上 cart.id as cart_id 才能在 cartlist 中取得 cart.id 用來移除購物車商品

            ->sum('products.price');
//        dd($total);
        return view('ordernow', ['total' => $total]);
    }

    // 用 post 執行 ordernow 的 submit
    function orderPlace(Request $request)
    {
        $userId = Session::get('user')['id'];
        $allCart = Cart::where('user_id',$userId)->get();
//        dd($allCart);
        $input = $request->input();
        $rules = ['address' => 'required|min:5'];
//        $messages = ['required' => '欄位不能空白，且字數必須超過5個字'];
        $validator = Validator::make($input, $rules);
        if($validator->passes()) {
            foreach ($allCart as $cart) {
                $order = new Order;
                $order->product_id = $cart['product_id'];
                $order->user_id = $cart['user_id'];
                $order->status = "pending";
                $order->payment_method = $request->payment;
                $order->payment_status = "pending";
                $order->address = $request->address;
                $order->save();
                Cart::where('user_id', $userId)->delete();
            }
            $request->input();
            return redirect('/');
        }
        return redirect('/ordernow')
            ->withInput()
            ->withErrors($validator);
    }

    function myOrders()
    {

//        $userId = Session::get('user')['id'];
        $userId = isset(Session::get('user')['id']) ? Session::get('user')['id'] : Null;
        if(isset($userId) && $userId != Null)
        {
            $orders = $products = DB::table('orders')
                ->join('products', 'orders.product_id', '=', 'products.id')
                ->where('orders.user_id', $userId)
                // 加上 cart.id as cart_id 才能在 cartlist 中取得 cart.id 用來移除購物車商品
                ->get();

            return view('myorders', ['orders' => $orders]);
        }
        else
        {
            return redirect('/');
        }
    }
}

