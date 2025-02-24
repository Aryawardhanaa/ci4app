namespace App\Controllers;

use CodeIgniter\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DashboardController extends Controller
{
public function exportExcel()
{
// Data contoh (seharusnya dari database)
$startMom = '2024-01';
$endmonth = '2024-02';
$startYoy = '2023-02';

// Buat spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Merge untuk "GL Account" (rowspan 2 baris)
$sheet->mergeCells('A1:A2')->setCellValue('A1', 'GL Account');

// Merge untuk "MoM" (colspan 4 kolom)
$sheet->mergeCells('B1:E1')->setCellValue('B1', 'MoM');

// Merge untuk "YoY" (colspan 4 kolom)
$sheet->mergeCells('F1:I1')->setCellValue('F1', 'YoY');

// Header Baris Kedua
$sheet->setCellValue('B2', $this->convertTanggal($startMom));
$sheet->setCellValue('C2', $this->convertTanggal($endmonth));
$sheet->setCellValue('D2', 'Growth');
$sheet->setCellValue('E2', 'Rate');
$sheet->setCellValue('F2', $this->convertTanggal($startYoy));
$sheet->setCellValue('G2', $this->convertTanggal($endmonth));
$sheet->setCellValue('H2', 'Growth');
$sheet->setCellValue('I2', 'Rate');

// Tambahkan border biar rapi
$styleArray = [
'borders' => [
'allBorders' => [
'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
],
],
'alignment' => [
'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
],
'font' => [
'bold' => true,
],
];
$sheet->getStyle('A1:I2')->applyFromArray($styleArray);

// Simpan sebagai file Excel
$filename = 'Export-Excel.xlsx';
$writer = new Xlsx($spreadsheet);

// Atur header agar browser mendownload file
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$writer->save('php://output');
exit;
}

// Fungsi untuk format tanggal (gantilah sesuai kebutuhan)
private function convertTanggal($tanggal)
{
return date('F Y', strtotime($tanggal . '-01'));
}
}







namespace App\Controllers;

use CodeIgniter\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DashboardController extends Controller
{
public function exportExcel()
{
// Data contoh (seharusnya dari database)
$datas = [
['kode_akun_2' => '52', '2024-01' => 5000000, '2024-02' => 7000000, '2023-02' => 4000000],
['kode_akun_2' => '53', '2024-01' => 3000000, '2024-02' => 3500000, '2023-02' => 2500000],
['kode_akun_2' => '54', '2024-01' => 4500000, '2024-02' => 5000000, '2023-02' => 4200000],
];

$startMom = '2024-01';
$endmonth = '2024-02';
$startYoy = '2023-02';

// Inisialisasi Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Header dengan merge cells
$sheet->mergeCells('A1:A2')->setCellValue('A1', 'GL Account');
$sheet->mergeCells('B1:E1')->setCellValue('B1', 'MoM');
$sheet->mergeCells('F1:I1')->setCellValue('F1', 'YoY');

// Baris Header Kedua
$sheet->setCellValue('B2', $this->convertTanggal($startMom));
$sheet->setCellValue('C2', $this->convertTanggal($endmonth));
$sheet->setCellValue('D2', 'Growth');
$sheet->setCellValue('E2', 'Rate');
$sheet->setCellValue('F2', $this->convertTanggal($startYoy));
$sheet->setCellValue('G2', $this->convertTanggal($endmonth));
$sheet->setCellValue('H2', 'Growth');
$sheet->setCellValue('I2', 'Rate');

// Mapping deskripsi akun
$descriptions = [
'52' => 'Operations and Maintenance',
'53' => 'Personnel',
'54' => 'Marketing and Sales',
'55' => 'General and Administrative',
'56' => 'Cost of Service',
];

// Looping Data
$row = 3;
foreach ($datas as $data) {
$kodeAkun = $data['kode_akun_2'];
$desc = $descriptions[$kodeAkun] ?? 'Default';

// Hitung Growth & Rate MoM
$growthmom = $data[$endmonth] - $data[$startMom];
$rateMom = $data[$startMom] == 0 ? "-" : ceil(($growthmom / $data[$startMom]) * 100) . '%';

// Hitung Growth & Rate YoY
$growthyoy = $data[$endmonth] - $data[$startYoy];
$rateYoy = $data[$startYoy] == 0 ? "-" : ceil(($growthyoy / $data[$startYoy]) * 100) . '%';

// Set Data ke Excel
$sheet->setCellValue('A' . $row, $kodeAkun . ' - ' . $desc);
$sheet->setCellValue('B' . $row, $this->formatRupiah($data[$startMom]));
$sheet->setCellValue('C' . $row, $this->formatRupiah($data[$endmonth]));
$sheet->setCellValue('D' . $row, $this->formatRupiah($growthmom));
$sheet->setCellValue('E' . $row, $rateMom);
$sheet->setCellValue('F' . $row, $this->formatRupiah($data[$startYoy]));
$sheet->setCellValue('G' . $row, $this->formatRupiah($data[$endmonth]));
$sheet->setCellValue('H' . $row, $this->formatRupiah($growthyoy));
$sheet->setCellValue('I' . $row, $rateYoy);

$row++;
}

// Styling untuk border dan rata tengah
$styleArray = [
'borders' => [
'allBorders' => [
'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
],
],
'alignment' => [
'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
],
'font' => [
'bold' => true,
],
];
$sheet->getStyle('A1:I' . ($row - 1))->applyFromArray($styleArray);

// Simpan dan Download Excel
$filename = 'Export-Excel.xlsx';
$writer = new Xlsx($spreadsheet);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$writer->save('php://output');
exit;
}

// Fungsi untuk format tanggal
private function convertTanggal($tanggal)
{
return date('F Y', strtotime($tanggal . '-01'));
}

// Fungsi untuk format Rupiah
private function formatRupiah($angka)
{
return 'Rp ' . number_format($angka, 0, ',', '.');
}
}