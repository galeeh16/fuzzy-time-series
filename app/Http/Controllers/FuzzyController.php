<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FuzzyController extends Controller
{
    public function index() 
    {
    	$data = [
    		['tahun' => 2001, 'jumlah_penduduk' => '178125'],
    		['tahun' => 2002, 'jumlah_penduduk' => '191990'],
    		['tahun' => 2003, 'jumlah_penduduk' => '201263'],
    		['tahun' => 2004, 'jumlah_penduduk' => '210984'],
    		['tahun' => 2000, 'jumlah_penduduk' => '174706'],
    		['tahun' => 2005, 'jumlah_penduduk' => '219351'],
    		['tahun' => 2006, 'jumlah_penduduk' => '225249'],
    		['tahun' => 2007, 'jumlah_penduduk' => '231121'],
    		['tahun' => 2008, 'jumlah_penduduk' => '240553'],
    		['tahun' => 2009, 'jumlah_penduduk' => '250367'],
    		['tahun' => 2010, 'jumlah_penduduk' => '253178'],
    		['tahun' => 2011, 'jumlah_penduduk' => '259913'],
    		['tahun' => 2012, 'jumlah_penduduk' => '268022'],
    		['tahun' => 2013, 'jumlah_penduduk' => '274089'],
    		['tahun' => 2015, 'jumlah_penduduk' => '285967'],
    		['tahun' => 2014, 'jumlah_penduduk' => '280109'],
    	];

    	echo "<b>Contoh Dataset (menggunakan data penduduk)</b><br>";
    	echo "<table border='1' style='border-collapse:collapse;'>
    			<tr>
    				<td>No</td>
    				<td>Tahun</td>
    				<td>Jumlah Penduduk</td>
    			</tr>";

    	foreach ($data as $key => $row) {
    		echo '<tr><td align="center">'. ($key + 1) .'</td>';
    		echo '<td align="center">'. $row['tahun'] .'</td>';
    		echo '<td align="center">'. $row['jumlah_penduduk'] .'</td></tr>';
    	}
    	echo "</table><br>";

    	$jumlah_data = count($data);

    	sort($data);
    	$dmin = $data[0]['jumlah_penduduk'];
    	$dmax = $data[$jumlah_data - 1]['jumlah_penduduk'];
    	$d1 = 3;
    	$d2 = 3;
    	echo "DMax = " . $dmax . '<br>';
    	echo "DMin = " . $dmin . '<br>';
    	echo "d1 = " . $d1 . '<br>';
    	echo "d2 = " . $d2 . '<br><br>';

    	// Pembentukan universe of discourse = U =[Dmin - D1, Dmax - D2]
    	$uod = array();
    	$min = $dmin - $d1;
    	$max = $dmax + $d2;

    	// array_push untuk memasukkan suatu nilai ke dalam array
    	array_push($uod, $min);
    	array_push($uod, $max);

    	echo "<b>Menentukan Universe of Discourse</b><br>";
    	echo "U = [" . $dmin . ' - ' . $d1 . ', ' . $dmax . ' + ' . $d2 .']<br>';
    	echo "Sehingga didapatkan<br> U = [" . $uod[0] .', ' . $uod[1] .']<br><br>';

    	// Menentukan interval = 1 + (3322 * log(n))
    	$jumlah_interval = round( (1 + (3.322 * log10($jumlah_data))));

    	// Cari lebar interval 
    	$lebar_interval = round(($uod[1] - $uod[0]) / $jumlah_interval);

    	echo "<b>Menentukan jumlah dan lebar interval</b><br>";
    	echo "Jumlah interval = 1 + (3.322 * log10(".$jumlah_data.")) = " . $jumlah_interval. "<br>";
    	echo 'Lebar interval = ('. $uod[1] .' - ' . $uod[0] .') / ' . $jumlah_data . ' = ' . $lebar_interval . '<br><br>';
    	
    	// Membagi data berdasarkan jumlah dan lebar interval 
    	$nilai_tengah = array();
    	$awal = $data[0]['jumlah_penduduk'];
    	$temp = $data[0]['jumlah_penduduk'];

    	echo '<b>Langkah selanjutnya adalah membagi data berdasarkan jumlah dan lebar interval.</b><br>';
    	
    	for($i = 1; $i <= $jumlah_interval; $i++) {
    		$hitung = 0;
    		$awal += $lebar_interval;
    		$hitung = round(($awal + $temp) / 2);
    		echo 'U'.$i .': '. $temp .' - ' . $awal . ' nilai tengah A' . $i  .': ' . $hitung . '<br>';
    		$temp = $awal; 
    		array_push($nilai_tengah, $hitung);
    	}

        echo "<pre>";
        print_r($nilai_tengah);
        echo "</pre>";

    	// Menentukan fuzzy logic relationship (FLR) 
    	echo '<br><b>Menentukan Fuzzy Logic Relationship(FLR)</b><br>';
        $flr = array();
        $counter = 0;

        $awalan = $data[0]['jumlah_penduduk'] + $lebar_interval;
        foreach ($data as $key => $row) {
            for ($i=0; $i < count($nilai_tengah); $i++) {
                
            }
            // if($row['jumlah_penduduk'] <= ($nilai_tengah[0] + $lebar_interval)) {
            //     echo $row['jumlah_penduduk'] ." A1".'<br>';
            // } else if($row['jumlah_penduduk'] <= ($nilai_tengah[1] + $lebar_interval)) {
            //     echo $row['jumlah_penduduk'] ." A2".'<br>';
            // } else if($row['jumlah_penduduk'] <= ($nilai_tengah[2] + $lebar_interval)) {
            //     echo $row['jumlah_penduduk']. " A3".'<br>';
            // } else if($row['jumlah_penduduk'] <= ($nilai_tengah[3] + $lebar_interval)) {
            //     echo $row['jumlah_penduduk']. " A4".'<br>';
            // } else if($row['jumlah_penduduk'] <= ($nilai_tengah[4] + $lebar_interval)) {
            //     echo $row['jumlah_penduduk']. " A5".'<br>';
            // }
        }

        echo "<pre>";
        print_r($flr);

    	echo "<br><br><br><br>";
    	echo "<br><br><br><br>";
    	echo "<br><br><br><br>";
    	echo "<br><br><br><br>";
    	echo "<br><br><br><br>";

    }


}
