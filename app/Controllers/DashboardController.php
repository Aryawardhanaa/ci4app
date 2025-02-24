<?php

namespace App\Controllers;

use App\Models\ExcelModel;
use DateTime;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DashboardController extends BaseController
{
    public function index(): string
    {

        // echo '<pre>';
        // var_dump($this->request->getMethod() == 'POST');
        // exit;

        $reqmethod = $this->request->getMethod();

        $excelModel = new ExcelModel();

        $datafilter = $excelModel->select('month_year')
            ->where('is_deleted', 0)->groupBy('month_year')
            ->orderBy('month_year', 'desc')
            ->get()
            ->getResultArray();


        // echo '<pre>';
        // var_dump('dasdas');
        // exit;
        $param = $this->request->getPost('monthyear') ?? $datafilter[0]['month_year'];
        $isempty = count($datafilter);
        $datas = $excelModel->getAccountData($isempty, $param);
        // echo '<pre>';
        // var_dump($datas[0]['Des-23'] == 0);
        // exit;
        // ceil(($growthmom / $data[$aliasMom]) * 100) . '%';

        // if ($reqmethod == 'POST') {
        // }

        $startMom = $isempty != 0 ? $this->minusDate($param, 'month') : date('Y-m-d');
        $startYoy =  $isempty != 0 ? $this->minusDate($param, 'year') : date('Y-m-d');

        $endmonth = $param;
        return view('dashboard/index', compact('datas', 'endmonth', 'datafilter', 'startMom', 'startYoy', 'isempty'));
    }
    public function exportExcel($id)
    {
        $excelModel = new ExcelModel();

        $param = DateTime::createFromFormat('Ymd', $id)->format('Y-m-d');

        $datas = $excelModel->getAccountData(1, $param);
        $startMom =  converTanggal($this->minusDate($param, 'month'));
        $startYoy =   converTanggal($this->minusDate($param, 'year'));


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->mergeCells('A1:A2')->setCellValue('A1', 'GL Account');

        $sheet->mergeCells('B1:E1')->setCellValue('B1', 'MoM');

        $sheet->mergeCells('F1:I1')->setCellValue('F1', 'YoY');

        $sheet->setCellValue('B2', $startMom);
        $sheet->setCellValue('C2', converTanggal($param));
        $sheet->setCellValue('D2', 'Growth');
        $sheet->setCellValue('E2', 'Rate');
        $sheet->setCellValue('F2', $startYoy);
        $sheet->setCellValue('G2', converTanggal($param));
        $sheet->setCellValue('H2', 'Growth');
        $sheet->setCellValue('I2', 'Rate');

        $curr_month = converTanggal($param);


        $totalstartMom = 0;
        $totalendMom = 0;

        $totalstartYoy = 0;
        $totalendYoy = 0;

        $row = 3;
        foreach ($datas as $data) {
            $kodeAkun = $data['kode_akun_2'];
            $desc = '';
            switch ($data['kode_akun_2']) {
                case '52':
                    $desc = 'Operations and Maintenance';
                    break;
                case '53':
                    $desc = 'Personel';
                    break;
                case '54':
                    $desc = 'Marketing and Sales';
                    break;
                case '55':
                    $desc = 'General and Administrative';
                    break;
                case '56':
                    $desc = 'Cost of Service';
                    break;
                default:
                    $text = ' Default';
                    break;
                    // converTanggal($f['month_year'])
            }

            $growthmom = (int)$data[$curr_month] - (int)$data[$startMom];

            $rateMom = $data[$startMom] == 0 ? "-" : ceil(($growthmom / $data[$startMom]) * 100);

            // Hitung Growth & Rate YoY
            $growthyoy = (int)$data[$curr_month] - (int)$data[$startYoy];
            $rateYoy = $data[$startYoy] == 0 ? "-" : ceil(($growthyoy / $data[$startYoy]) * 100);


            $totalstartMom += $data[$startMom];
            $totalendMom += $data[$curr_month];
            // Set Data ke Excel
            $totalstartYoy += $data[$startYoy];
            $totalendYoy += $data[$curr_month];

            $sheet->setCellValue('A' . $row, $kodeAkun . ' - ' . $desc);
            $sheet->setCellValue('B' . $row, $data[$startMom]);
            $sheet->setCellValue('C' . $row, $data[$curr_month]);
            $sheet->setCellValue('D' . $row, $growthmom);
            $sheet->setCellValue('E' . $row, $rateMom);
            $sheet->setCellValue('F' . $row, $data[$startYoy]);
            $sheet->setCellValue('G' . $row, $data[$curr_month]);
            $sheet->setCellValue('H' . $row, $growthyoy);
            $sheet->setCellValue('I' . $row, $rateYoy);

            $row++;
        }
        $growthmom = (int)$totalendMom - (int)$totalstartMom;
        $rateMom = (int)$totalstartMom == 0 ? "-" : ceil(($growthmom / (int)$totalstartMom) * 100);

        $growthYoy = (int)$totalendYoy - (int)$totalstartYoy;
        $rateYoy = (int)$totalstartYoy == 0 ? "-" : ceil(($growthYoy / (int)$totalstartYoy) * 100);

        $sheet->setCellValue('A' . $row, 'Total');
        $sheet->setCellValue('B' . $row, $totalstartMom);
        $sheet->setCellValue('C' . $row, $totalendMom);
        $sheet->setCellValue('D' . $row, $growthmom);
        $sheet->setCellValue('E' . $row, $rateMom);
        $sheet->setCellValue('F' . $row, $totalstartYoy);
        $sheet->setCellValue('G' . $row, $totalendYoy);
        $sheet->setCellValue('H' . $row, $growthYoy);
        $sheet->setCellValue('I' . $row, $rateYoy);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="data.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        // Output file ke browser
        $writer->save('php://output');
    }
    protected function converTanggal($data)
    {
        $tgl = tanggal_indonesia($data, true, true);
        $explode = explode(' ', $tgl);
        $bln = substr($explode[0], 0, 3);
        $thn = substr($explode[1], -2);

        return "$bln-$thn";
    }
    protected function minusDate($data, $type)
    {
        $date = new DateTime($data);

        $date->modify("-1 $type");

        // $converted = $this->converTanggal($date->format('Y-m-d')); 
        return $date->format('Y-m-d');
    }

    public function showTabs(): string
    {
        return view('home');
    }
}
