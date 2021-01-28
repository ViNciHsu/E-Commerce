<?php

namespace App\Http\Libraries\ExcelUtil;


use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class export implements FromCollection, WithHeadings, WithEvents
{
    protected $data;
    protected $headings;
    protected $columnWidth = [];//設定列寬       key：列  value:寬
    protected $rowHeight = [];  //設定行高       key：行  value:高
    protected $mergeCells = []; //合併單元格      key：第一個單元格  value:第二個單元格
    protected $font = [];       //設定字型       key：A1:K8  value:11
    protected $bold = [];       //設定粗體       key：A1:K8  value:true
    protected $background = []; //設定背景顏色    key：A1:K8  value:#F0F0F0F

    // 2021/01/27新增 字體/水平/垂直
    protected $vertical = [];   //設定定位       key：A1:K8  value:center
    protected $horizontal = [];   //設定定位       key：A1:K8  value:center
    protected $fontFamily = [];  // 新增設定字體       Key: 'A1:A13' value:'Verdana'

    //設定頁面屬性時如果無效   更改excel格式嘗試即可

    //建構函式傳值
    public function __construct($data, $headings)
    {
        $this->data = $data;
        $this->headings = $headings;
        $this->createData();
    }

    public function headings(): array
    {
        return $this->headings;
    }

    //陣列轉集合
    public function collection()
    {
        return new Collection($this->data);
    }

    //業務程式碼
    public function createData()
    {
        $this->data = collect($this->data)->toArray();
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                //設定列寬
                foreach ($this->columnWidth as $column => $width) {
                    $event->sheet->getDelegate()
                        ->getColumnDimension($column)
                        ->setWidth($width);
                }

                //設定行高，$i為資料行數
                foreach ($this->rowHeight as $row => $height) {
                    $event->sheet->getDelegate()
                        ->getRowDimension($row)
                        ->setRowHeight($height);
                }

                //設定區域單元格垂直居中
                foreach ($this->vertical as $region => $position) {
//                    dd($this->vertical);
                    $event->sheet->getDelegate()
                        ->getStyle($region)
                        ->getAlignment()
                        ->setVertical($position);
                }

                //設定區域單元格水平居中
                foreach ($this->horizontal as $region => $position) {
//                    dd($this->horizontal);
                    $event->sheet->getDelegate()
                        ->getStyle($region)
                        ->getAlignment()
                        ->setHorizontal($position);
                }

                //設定區域單元格字型大小
                foreach ($this->font as $region => $value) {
                    $event->sheet->getDelegate()
                        ->getStyle($region)
                        ->getFont()
                        ->setSize($value);
                }

                //設定區域單元格字型粗體
                foreach ($this->bold as $region => $bool) {
                    $event->sheet->getDelegate()
                        ->getStyle($region)
                        ->getFont()
                        ->setBold($bool);
                }

                //設定區域單元格背景顏色
                foreach ($this->background as $region => $item) {
//                    dd($this->background);
                    // ExcelController.php內 ordersExcel()內 自行定義的$headerColor ,其他欄位要額外寫，否則會全部定義成一樣的樣式
                    $event->sheet->getDelegate()->getStyle($region)->applyFromArray([
//                        'font' => [
//                            'size' => '13',
//                            'name' => '微軟正黑體',
//                            'bold' => true,
//                            'italic' => false,
//                            'strikethrough' => false,
//                            'color' => [
//                                'rgb' => '595959'
//                            ]
//                        ],
                        // 取消註解可在export.php做水平跟垂直置中
//                        'alignment' => [
//                            'horizontal' => Alignment::HORIZONTAL_CENTER,
//                            'vertical' => Alignment::VERTICAL_CENTER,
//                            'wrapText' => true,
//                        ],
                        'fill' => [
                            'fillType' => 'linear', //線性填充，類似漸變
                            'startColor' => [
                                'rgb' => $item //初始顏色
                            ],
                            //結束顏色，如果需要單一背景色，請和初始顏色保持一致
                            'endColor' => [
                                'argb' => $item
                            ]
                        ]
                    ]);

                    // 設置'B1:B13'
                    $event->sheet->getDelegate()->getStyle('B1:B13')->applyFromArray([
//                        'font' => [
//                            'size' => '11',
//                            'name' => '微軟正黑體',
//                            'bold' => false,
//                            'italic' => true,
//                            'strikethrough' => false,
//                            'color' => [
//                                'rgb' => '000000'
//                            ]
//                        ],
                    ]);

                    // 設置'A16:K19'
                    $event->sheet->getDelegate()->getStyle('A16:K19')->applyFromArray([
//                        'font' => [
//                            'size' => '11',
//                            'name' => '微軟正黑體',
//                            'bold' => false,
//                            'italic' => true,
//                            'strikethrough' => false,
//                            'color' => [
//                                'rgb' => '000000'
//                            ]
//                        ],
                    ]);

                    // 設置'D5'
                    $event->sheet->getDelegate()->getStyle('D5')->applyFromArray([
//                        'font' => [
//                            'size' => '11',
//                            'name' => '微軟正黑體',
//                            'bold' => false,
//                            'italic' => true,
//                            'strikethrough' => false,
//                            'color' => [
//                                'rgb' => '000000'
//                            ]
//                        ],
                    ]);
                }

                //合併單元格
                foreach ($this->mergeCells as $start => $end) {
//                    dd($end);
                    $event->sheet->getDelegate()->mergeCells($start . ':' . $end);
                }

                //設定區域單元格字體 2021/01/27 新增
                foreach ($this->fontFamily as $region => $value) {
//                    dd($this->fontFamily);
                    $event->sheet->getDelegate()
                        ->getStyle($region)
                        ->getFont()
                        ->setName($value);
                }
            }
        ];
    }

    /**
     * @return array
     * @2020/3/22 10:33
     * [
     *    'B' => 40,
     *    'C' => 60
     * ]
     */
    public function setColumnWidth(array $columnwidth)
    {
        $this->columnWidth = array_change_key_case($columnwidth, CASE_UPPER);
    }

    /**
     * @return array
     * @2020/3/22 10:33
     * [
     *    1 => 40,
     *    2 => 60
     * ]
     */
    public function setRowHeight(array $rowHeight)
    {
        $this->rowHeight = $rowHeight;
    }

    /**
     * @return array
     * @2020/3/22 10:33
     * [
     *    A1:K7 => 12
     * ]
     */
    public function setFont(array $font)
    {
        $this->font = array_change_key_case($font, CASE_UPPER);
    }

    /**
     * @return array
     * @2020/3/22 10:33
     * [
     *    A1:K7 => true
     * ]
     */
    public function setBold(array $bold)
    {
        $this->bold = array_change_key_case($bold, CASE_UPPER);
    }

    /**
     * @return array
     * @2020/3/22 10:33
     * [
     *    A1:K7 => F0FF0F
     * ]
     */
    public function setBackground(array $background)
    {
        $this->background = array_change_key_case($background, CASE_UPPER);
    }

    /**
     * @return array
     * @2021/01/27 15:53
     * [
     *   'A1:A13' => 'center'
     * ]
     */
    public function setVertical(array $vertical)
    {
        $this->vertical = array_change_key_case($vertical, CASE_UPPER);
    }

    /**
     * @return array
     * @2021/01/27 15:53
     * [
     *   'A1:A13' => 'center',
     *    'A15:K15' => 'left'
     * ]
     */
    public function setHorizontal(array $horizontal)
    {
        $this->horizontal = array_change_key_case($horizontal, CASE_UPPER);
    }

    /**
     * @return array
     * @2021/01/27 15:53
     * [
     *     'A1:A13' => '微軟正黑體',
     *     'A15:K15' => '微軟正黑體',
     * ]
     */
    public function setFontFamily(array $fontFamily)
    {
//        dd($this->fontFamily);
        $this->fontFamily = array_change_key_case($fontFamily, CASE_UPPER);
    }

    public function setMergeCells(array $mergeCells)
    {
        $this->mergeCells = array_change_key_case($mergeCells, CASE_UPPER);
    }

}
