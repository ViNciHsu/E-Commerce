<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Collection;


class OrdersExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $userId = session()->get('user')['id'];
        return DB::table('orders')
        ->join('products', 'orders.product_id', '=', 'products.id')
        ->where('orders.user_id', $userId)
        ->get();
    }

    public function registerEvents():array
    {
        return [
            AfterSheet::class => function(AfterSheet $event){
                $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                $drawing->setName('submit_img');
                $drawing->setDescription('submit_img');
                $drawing->setPath(storage_path('001.jpg'));
                $drawing->setWidth('500');
                $drawing->setOffsetX('10');
                $drawing->setOffsetY('10');
                $drawing->setCoordinates('C1');
                //設定高度
                $event->sheet->getRowDimension(2)->setRowHeight($drawing->getHeight());

                $drawing->setWorksheet($event->sheet->getDelegate());


                //調整欄位寬度
                $event->sheet->getColumnDimension('A')->setWidth(5);
                $event->sheet->getColumnDimension('B')->setWidth(18);
                $event->sheet->getColumnDimension('C')->setWidth(70);

            },
        ];
    }

    static public function passToExcelController()
    {
        $userId = session()->get('user')['id'];
        $orders = DB::table('orders')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->where('orders.user_id', $userId)
            ->get();
        return $orders;
    }
}
