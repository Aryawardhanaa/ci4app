<?php

if (!function_exists('format_uang')) {
    function format_uang($angka)
    {
        return number_format($angka, 0, ',', '.');
    }
}

if (!function_exists('getCurrentSemester')) {
    function getCurrentSemester()
    {
        return date('n') < 6 ? 'genap' : 'ganjil';
    }
}

if (!function_exists('formatRupiah')) {
    function formatRupiah($angka)
    {
        $formattedAngka = number_format($angka, 0, ',', '.');
        return 'Rp. ' . $formattedAngka;
    }
}

if (!function_exists('generateRandomString')) {
    function generateRandomString($length = 7)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

if (!function_exists('extractIntegerFromString')) {
    function extractIntegerFromString($string)
    {
        $cleanedString = preg_replace('/[^0-9]/u', '', $string);
        return (int)$cleanedString;
    }
}

if (!function_exists('createSlug')) {
    function createSlug($string, $char = '_')
    {
        $string = preg_replace('/([a-z])([A-Z])/', '$1' . $char . '$2', $string);
        $string = str_replace(' ', $char, $string);
        $string = strtolower($string);
        return $string;
    }
}

if (!function_exists('terbilang')) {
    function terbilang($angka)
    {
        $angka = abs($angka);
        $baca  = array('', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas');
        $terbilang = '';

        if ($angka < 12) {
            $terbilang = ' ' . $baca[$angka];
        } elseif ($angka < 20) {
            $terbilang = terbilang($angka - 10) . ' belas';
        } elseif ($angka < 100) {
            $terbilang = terbilang($angka / 10) . ' puluh' . terbilang($angka % 10);
        } elseif ($angka < 200) {
            $terbilang = ' seratus' . terbilang($angka - 100);
        } elseif ($angka < 1000) {
            $terbilang = terbilang($angka / 100) . ' ratus' . terbilang($angka % 100);
        } elseif ($angka < 2000) {
            $terbilang = ' seribu' . terbilang($angka - 1000);
        } elseif ($angka < 1000000) {
            $terbilang = terbilang($angka / 1000) . ' ribu' . terbilang($angka % 1000);
        } elseif ($angka < 1000000000) {
            $terbilang = terbilang($angka / 1000000) . ' juta' . terbilang($angka % 1000000);
        }

        return $terbilang;
    }
}

if (!function_exists('tanggal_indonesia')) {
    function tanggal_indonesia($tgl, $tampil_hari = true, $bulan_tahun = false)
    {
        $nama_hari  = array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum\'at', 'Sabtu');
        $nama_bulan = array(1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');

        $tahun   = substr($tgl, 0, 4);
        $bulan   = $nama_bulan[(int) substr($tgl, 5, 2)];
        $tanggal = substr($tgl, 8, 2);
        $text    = '';

        if ($bulan_tahun) {
            $text .= "$bulan $tahun";
            return $text;
        }

        if ($tampil_hari) {
            $urutan_hari = date('w', mktime(0, 0, 0, substr($tgl, 5, 2), $tanggal, $tahun));
            $hari        = $nama_hari[$urutan_hari];
            $text .= "$hari, $tanggal $bulan $tahun";
        } else {
            $text .= "$tanggal $bulan $tahun";
        }

        return $text;
    }
}

if (!function_exists('tambah_nol_didepan')) {
    function tambah_nol_didepan($value, $threshold = null)
    {
        return sprintf("%0" . $threshold . "s", $value);
    }
}
if (!function_exists('converTanggal')) {
    function converTanggal($data)
    {
        $tgl = tanggal_indonesia($data, true, true);
        $explode = explode(' ', $tgl);
        $bln = substr($explode[0], 0, 3);
        $thn = substr($explode[1], -2);

        return "$bln-$thn";
    }
}

if (!function_exists('hapus_titik')) {
    function hapus_titik($inputAmount)
    {
        return str_replace('.', '', $inputAmount);
    }
}

if (!function_exists('tambahkanRentangAngka')) {
    function tambahkanRentangAngka($angka)
    {
        $rentang = [];
        $jumlahAngka = count($angka);

        $i = 0;
        while ($i < $jumlahAngka) {
            $dari = $angka[$i];
            $sampai = $dari;

            while ($i < $jumlahAngka - 1 && $angka[$i + 1] - $angka[$i] == 1) {
                $sampai = $angka[$i + 1];
                $i++;
            }

            $rentang[] = ['dari' => $dari, 'sampai' => $sampai];
            $i++;
        }

        return $rentang;
    }
}

if (!function_exists('tanggal_indonesia_detik')) {
    function tanggal_indonesia_detik($tgl, $tampil_hari = true)
    {
        $nama_hari  = array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum\'at', 'Sabtu');
        $nama_bulan = array(1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');

        $tahun   = substr($tgl, 0, 4);
        $bulan   = $nama_bulan[(int) substr($tgl, 5, 2)];
        $tanggal = substr($tgl, 8, 2);

        // Mendapatkan waktu
        $jam     = substr($tgl, 11, 2);
        $menit   = substr($tgl, 14, 2);
        $detik   = substr($tgl, 17, 2);

        $text    = '';

        if ($tampil_hari) {
            $urutan_hari = date('w', mktime(0, 0, 0, substr($tgl, 5, 2), $tanggal, $tahun));
            $hari        = $nama_hari[$urutan_hari];
            $text .= "$hari, $tanggal $bulan $tahun $jam:$menit:$detik";
        } else {
            $text .= "$tanggal $bulan $tahun $jam:$menit:$detik";
        }

        return $text;
    }
}
