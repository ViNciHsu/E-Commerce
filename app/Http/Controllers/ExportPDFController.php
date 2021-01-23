<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use Dompdf\Dompdf;
use Dompdf\Options;

class ExportPDFController extends Controller
{
    public function ordersExportPDF(){
        $userId = session()->get('user')['id'];
        $orders = DB::table('orders')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->where('orders.user_id', $userId)
            // 加上 cart.id as cart_id 才能在 cartlist 中取得 cart.id 用來移除購物車商品
            ->get();

        $datetime = date ("Y-m-d/H:i:s");

//        $options = new Options();
//        $options->set('isRemoteEnabled', TRUE);
//        $pdf = new DomPDF($options);
        $image_file = public_path ('images/products/LG_mobile.jpg');   //图片路径
        $image_info = getimagesize($image_file);          //获取图片类型
        $data = file_get_contents($image_file);           //读取图片信息
        $str = "data:{$image_info['mime']};base64," . base64_encode($data);  //返回base64字符串
//        dd($image_file);
        $pdf = PDF::loadView('exportFile.myordersPDF', [
            'orders' => $orders,
            'str' => $str
        ])
        ->setOptions([
            'defaultFont' => 'msyh',
            'isRemoteEnabled' => true,
            'isPhpEnabled' => true
        ]);

//        dd($options);
        // 基本寫法
//        $dompdf = new Dompdf();
//        $dompdf->loadHtml('

//            <style>
//            .font-zh {
//                font-family: "msyh"
//            }
//            </style>
//
//            <p>English / <span class="font-zh">正體中文 123 Chinese</span></p>
//
//        ');
//        $dompdf->setPaper('A4', 'landscape');
//        $dompdf->render();

// Attachment: 0 直接顯示, 1 強制下載
//        return $pdf->stream(null, ['Attachment' => 0]);

        return $pdf->download($datetime.'_ordersPDF.pdf');
//        $pdf->loadHTML($orders);

    }

    public function ordersPDF(){
        $userId = session()->get('user')['id'];
        $orders = DB::table('orders')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->where('orders.user_id', $userId)
            ->get();
//        $url = Storage::get('images/products/LG_mobile.jpg');
//        dd($orders[2]->gallery);
//        $str = array();
//        $image_info= array();
//        $data= array();
//        $image_file= array();
//foreach ($orders as $key => $order) {
//    foreach($order as $k => $o) {
//        dd($orders[2]->gallery);
        $image_file = public_path('images/products/Red_Mi.jpg');   //图片路径
        //https://www.lg.com/us/images/MC/features/LG-Stylo-6.jpg
        //https://img.ltn.com.tw/Upload/3c/page/2019/10/01/191001-38143-0.jpg
        //https://www.jyes.com.tw/data/goods/gallery/201911/1575025729126855479.jpg
        $image_info = getimagesize($image_file);          //获取图片类型
        $data = file_get_contents($image_file);           //读取图片信息
//        $str[] = "data:{$image_info['mime']};base64," . base64_encode($data);  //返回base64字符串
        $str =  base64_encode($data);

//}
//        dd($str);

        return view('exportFile.myordersPDF',[
            'orders' => $orders,
            'str' => $str
        ]);
    }
}
