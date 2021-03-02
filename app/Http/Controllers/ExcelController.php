<?php

namespace App\Http\Controllers;

use App\Exports\OrdersExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use App\Http\Libraries\ExcelUtil\export;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ExcelController extends Controller
{
    public function ordersExcel()
    {
        $userId = session()->get('user')['id'];
        $orders = DB::table('orders')
            ->select('orders.order_number','products.name as products_name','users.name as users_name','orders.status','orders.payment_method','orders.payment_status','orders.address','products.price')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->join('users','orders.user_id','=','users.id')
            ->where('orders.user_id', $userId)
            ->get();
//        $header = ['訂單編號','商品名稱','購買人姓名','出貨狀態','付款方式','付款狀態','寄送地址','商品價格'];//匯出頭
        $row = [];
        $temp = [];
        $temp[] = (object) ['0' => '發票組', '1' => 'AQ'];
        $temp[] = (object) ['0' => '發票號碼', '1' => 'AQ'];
        $temp[] = (object) ['0' => '發票時間', '1' => '2021-03-03 11:21:30'];
        $temp[] = (object) ['0' => '是否使用', '1' => '是'];
        $temp[] = (object) ['0' => '是否作廢', '1' => '否', '2' => '作廢日期', '3' => '2021-03-03 12:53:42'];
        $temp[] = (object) ['0' => '地址', '1' => ''];
        $temp[] = (object) ['0' => '電話', '1' => ''];
        $temp[] = (object) ['0' => '店家統編', '1' => ''];
        $temp[] = (object) ['0' => '客戶統編', '1' => ''];
        $temp[] = (object) ['0' => '店名', '1' => ''];
        $temp[] = (object) ['0' => '機號', '1' => ''];
        $temp[] = (object) ['0' => '序號', '1' => ''];
        $temp[] = (object) ['0' => '收銀員', '1' => ''];
        $temp[] = (object) ['0' => ''];
        $temp[] = (object) [
            '0' => '項次',
            '1' => '商品名稱',
            '2' => '購買人姓名',
            '3' => '金額',
            '4' => '出貨狀態',
            '5' => '付款方式',
            '6' => '付款狀態',
            '7' => '寄送地址',
            '8' => '稅項類別',
            '9' => '未稅金額',
            '10' => '稅額',
            '11' => ''
        ];

        foreach ($orders as $index => &$order) {
//            $num = count($)
//            dd($orders);
            $temp[] = (object)[
                '0' => $index + 1, // 項次
                '1' => $order->products_name,
                '2' => $order->users_name,
                '3' => $order->price,
                '4' => $order->status,
                '5' => $order->payment_method,
                '6' => $order->payment_status,
                '7' => $order->address
            ];
//            $temp[] = (object)[$order];
        }
        $timeNow = date ("Y-m-d_H:i:s");
        $countOrders = count($orders) + 15;
//        dd($countOrders);
        $temp = collect($temp);
//        dd($orders);

        $excel = new export($temp, $row);
        // 背景顏色
        $headerColor = [];
        $headerColor['A1:A13'] = 'ffd900';
        $headerColor['C5'] = 'ffd900';
        $headerColor['A15:K15'] = 'ff9900';
        $excel->setBackground($headerColor); // $放在setBackground內的$headerColor是$regin,其他欄位額外寫在export.php
//        $excel->setMergeCells(['C1' => 'C2']);
        // 1.可在export.php(ex:119行)做水平跟垂直置中(會針對ExcelController.php設定setBackground中的陣列設定
        // 2. 也可在ExcelController.php做]
        // 垂直位置
        $excel->setVertical([
//            'A1:A13' => 'center',
//            'C5' => 'center',
//            'A15:K15' => 'center',
//            'A16:A19' => 'center',
            'A1:Z'. $countOrders => 'center',
        ]);
        // 水平位置
        $excel->setHorizontal([
            'A1:A13' => 'center',
            'C5' => 'center',
            'A15:K15' => 'center',
            'A16:A'. $countOrders => 'center',
            'C16:C'. $countOrders => 'center',
            'E16:G'. $countOrders => 'center',
            'B1:B13' => 'right',
            'D5' => 'right',
            'B16:B'. $countOrders => 'center',
        ]);
        // 欄寬
        $excel->setColumnWidth([
            'A' => 15,
            'B' => 20,
            'C' => 20,
            'D' => 20,
            'E' => 20,
            'F' => 20,
            'G' => 20,
            'H' => 40,
            'I' => 20,
            'J' => 20,
            'K' => 20
        ]);
        // 粗體
        $excel->setBold([
            'A1:A13' => true,
            'A15:K15' => true,
            'C5' => true
        ]);
        // 字體
        $excel->setFontFamily([
            'A1:A13' => '微軟正黑體',
            'A15:K15' => '微軟正黑體',
            'C5' => '微軟正黑體',
            'H' => '微軟正黑體',
            // data的字體
            'B1:B13' => 'Arial',
            'D5' => 'Arial',
            'A16:G'. $countOrders => 'Arial',
            'I16:K'. $countOrders => 'Arial'
        ]);
        // 字體大小
        $excel->setFont([
            'A1:A13' => 13,
            'C5' => 13,
            'A15:K15' => 13,
            'A16:A'. $countOrders => 13
        ]);
//        dd($excel);
        return Excel::download($excel, $timeNow.'_orders.xlsx');
    }

    public function test_page()
    {
        // 開啟紀錄
        DB::connection()->enableQueryLog();
        $userId = session()->get('user')['id'];
        $orders = DB::table('orders')
            ->select('orders.order_number','products.name as products_name','users.name as users_name','orders.status','orders.payment_method','orders.payment_status','orders.address','products.price')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->join('users','orders.user_id','=','users.id')
            ->where('orders.user_id', $userId)
            ->get();
//        dd(DB::getQueryLog());
        $countOrders = count($orders) + 1;
//        dd($countOrders);
        $timeNow = date ("Y-m-d_H:i:s");
        $data = [];//要匯入的資料
        $header = ['訂單編號','商品名稱','購買人姓名','出貨狀態','付款方式','付款狀態','寄送地址','商品價格'];//匯出頭
        $excel = new export($orders, $header);
        $excel->setColumnWidth(['A' => 20, 'B' => 20,'C' => 20,'D' => 20,'E' => 20,'F' => 20,'G' => 40,'H' => 20,'I' => 20]);
//        $excel->setRowHeight([1 => 30]);
//        $excel->setFont(['A1:H1' => 14, 'A1:H1'.$countOrders => 12]);
//        $excel->setVertical('center');
//        $excel->setName('微軟正黑體');
        $excel->setBold(['A1:H1' => true]);

        $temp = array();
        $temp['A1:H1'] = 'ff9900';
        for($i = 2 ;$i <= $countOrders; $i++){
            $temp['A'.$i.':H'.$i] = ($i % 2 == 0) ?'ffe6c7':'f8c396';
        }
//        dd($temp);
        $excel->setBackground($temp);
//        exit;
        return Excel::download($excel, $timeNow.'_orders.xlsx');
    }

    public function ordersExport() {
        $data = [];//要匯入的資料
        $header = [];//匯出頭
        $excel = new OrdersExport($data, $header);
        $excel->setColumnWidth(['B' => 40, 'C' => 40]);
        $excel->setRowHeight([1 => 40, 2 => 50]);
        $excel->setFont(['A1:K7' => 12]);
        $excel->setBold(['A1:K7' => true]);
        $excel->setBackground(['A1:K7' => '808080']);
        return Excel::download($excel, '匯出的檔名.xlsx');
    }

    public function callModel()
    {
//        $passToExcelController = new OrdersExport();
//        $datas = $passToExcelController->passToExcelController();

        $datas2 = OrdersExport::passToExcelController();
        foreach ($datas2 as $data){
//            dd($data);
        }
    }
}
