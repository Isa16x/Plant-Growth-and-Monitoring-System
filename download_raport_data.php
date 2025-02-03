<?php
// ob_start(); 
require('./fpdf/fpdf.php');
$start_date = $_GET['start_date'];
$end_date = $_GET['end_date'];
$compare_type = $_GET['compare_type'];
$data_which_sensor = $_GET['data_which_sensor'];
$title = 'Raport for ' . $start_date . " - " . $end_date;

class PDF extends FPDF
{
    private $title;
    private $reference_values_for_water;
    function __construct($title, $reference_values_for_water)
    {
        parent::__construct();
        $this->title = $title;
        $this->reference_values_for_water = $reference_values_for_water;
    }

    function LoadData()
    {
    }
    // Page header
    function Header()
    {
        // Logo
        $this->Image('./imagini/logo.png', 10, 6, 40);
        // Arial bold 15
        $this->SetFont('Arial', 'I', 15);
        // Move to the right
        $this->Cell(80);
        // Title

        $this->Cell(20, 20, $this->title, 0, 0, 'C');

        // Line break
        $this->Ln(5);
    }

    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }
    // Better table
    function ImprovedTable($header, $data)
    {
        // Column widths
        $w = array(40, 35, 40, 45);
        // Header
        for ($i = 0; $i < count($header); $i++)
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C');
        $this->Ln();
        // Data
        foreach ($data as $row) {
            $this->Cell($w[0], 6, $row[0], 'LR');
            $this->Cell($w[1], 6, $row[1], 'LR');
            $this->Cell($w[2], 6, number_format($row[2]), 'LR', 0, 'R');
            $this->Cell($w[3], 6, number_format($row[3]), 'LR', 0, 'R');
            $this->Ln();
        }
        // Closing line
        $this->Cell(array_sum($w), 0, '', 'T');
    }
}
$reference_values_for_water = "Reference for soil moisture sensor data: 45-65%.";
$reference_values_for_light = "Reference for light level sensor data: 50% (about 800 lumens).";
$reference_values_for_temperature = "Reference for temperature sensor data: 15 - 30 degrees (Celsius).";
$reference_values_for_air_humidity = "Reference for air temperature sensor data: 50-70%.";

// $headers_for_soil_moisture = array('Date', 'Temperature (average)', );
$headers = array('Date', 'Average Value', 'Minimum value', 'Maximum value');
if ($compare_type == "per_week") {
    $compare_type = "week";
    $for_header;
} else if ($compare_type == "per_month") {
    $compare_type = "month";
} else if ($compare_type == "per_day") {
    $compare_type = "day";
}
$soil_moisture_title = "Soil moisture comparing per " . $compare_type;
$light_title = "Light level comparing per \n" . $compare_type;
$temp_title = "Temperatures per " . $compare_type;
$air_humidity_title = "Air Humidity per " . $compare_type;
$pdf = new PDF($title, $reference_values_for_water);
// $data = $pdf->LoadData();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 14);
// $pdf->ImprovedTable($header,$data);
$pdf->Ln();
$pdf->SetFont('Arial', '', 12);
include 'conectarebd.php';
if ($data_which_sensor == "soil_humidity" || $data_which_sensor == "all_sensors") {
    $pdf->Cell(5, 20, $soil_moisture_title, 0, 0, 'J');
    $pdf->Ln();
    $pdf->Cell(5, -5, $reference_values_for_water, 0, 0, 'J');
    $pdf->Ln(6);
    $sql = "SELECT * FROM `senzorasi` where id_senzor = 2 AND `timestamp` BETWEEN '" . $start_date . "' AND '" . $end_date . "' order by timestamp asc;";
    if ($result = mysqli_query($link2, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                // DATA | VALOARE AVERAGE | INCREASE/DECREASE BY | MIN VALUE | MAX VALUE | STANDARD DEVIATION ?
                $timestamp = new DateTime($row['timestamp']);
                //    $timestamp = $row['timestamp'];
                $valori[] = $row['valoare'];
                $formatted_timestamp = $timestamp->format('d-m-Y H:i');
                $timestamps[] = $formatted_timestamp;
                $formatted_timestamp = $timestamp->format('d-m-Y');
                $only_dates[] = $formatted_timestamp;
            }
        } else {
            $pdf->SetFont('Arial', 'I', 11);
            $pdf->Cell(5, 20, "No data available for the selected dates", 0, 0, 'J');
            $pdf->Ln();
            $pdf->SetFont('Arial', '', 12);
        }
    }
    $index = 0;
    // $total_valori_per_zile = array();
    $total_valori_per_zile = array_fill(0, count(array_unique($only_dates)), 0);
    $averages_per_days = array_fill(0, count(array_unique($only_dates)), 0);
    $start_for_dates_average = $only_dates[0];
    $min = 999999;
    // echo implode(', ', $only_dates);
    $max = array_fill(0, count(array_unique($only_dates)), -999999);
    $min = array_fill(0, count(array_unique($only_dates)), 999999);
    $array_with_dates_only_once = array();
    $array_with_dates_only_once[0] = $only_dates[0];

    $sql = "SELECT DISTINCT DATE(timestamp) AS unique_dates FROM senzorasi where id_senzor = 2 AND `timestamp` BETWEEN '" . $start_date . "' AND '" . $end_date . "' order by timestamp asc;";
    if ($result = mysqli_query($link2, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                // DATA | VALOARE AVERAGE | INCREASE/DECREASE BY | MIN VALUE | MAX VALUE | STANDARD DEVIATION ?
                $dates_solo[] = $row['unique_dates'];
            }
        } else {
            $pdf->SetFont('Arial', 'I', 11);
            $pdf->Cell(5, 20, "No data available for the selected dates", 0, 0, 'J');
            $pdf->Ln();
            $pdf->SetFont('Arial', '', 12);
        }
    }
    $old_date = $only_dates[0];
    for ($i = 0; $i < count($only_dates); $i++) {
        // $pdf->Cell(5,20,"for nr ".$i,0,0,'J');
        // $pdf->Ln();

        // echo "testuletz\n";
        if ($only_dates[$i] == $old_date) {
            // if(!$averages_per_days[$index]){
            //     $averages_per_days[$index] =0;
            // }
            $averages_per_days[$index] += $valori[$i];
            $total_valori_per_zile[$index]++;
            if ($valori[$i] < $min) {
                $min[$index] = $valori[$i];
            }
            if ($valori[$i] > $max[$index]) {
                $max[$index] = $valori[$i];
            }
            // $pdf->Cell(5,20,"for data ".$only_dates[$i]." am gasit valoarea ".$valori[$i],0,0,'J');
            // $pdf->Ln();
            // $pdf->Cell(5,20,"average per day ".$averages_per_days[$index]." nr de valori = ".$total_valori_per_zile[$index] ,0,0,'J');
            // $pdf->Ln();
        } else {

            // $pdf->Cell(5,20,"for data ".$only_dates[$i]." am gasit ca e diferita de ".$start_for_dates_average,0,0,'J');
            // $pdf->Ln();
            // $start_for_dates_average = $only_dates[$i];
            $index++;
            $array_with_dates_only_once[$index] = $only_dates[$i];
            if ($valori[$i] < $min[$index]) {
                $min[$index] = $valori[$i];
            }
            if ($valori[$i] > $max[$index]) {
                $max[$index] = $valori[$i];
            }
            // $averages_per_days[$index] = $averages_per_days[$index] +$valori[$i];
            // $total_valori_per_zile[$index]++;
            // $pdf->Cell(5,20,"average per day ".$averages_per_days[$index]." nr de valori = ".$total_valori_per_zile[$index] ,0,0,'J');
            // $pdf->Ln();
        }
        $old_date = $only_dates[$i];
    }
    // echo implode(',', $averages_per_days);
    $valori_pe_rows = array();
    // echo implode(", ",$array_with_dates_only_once);
    // echo implode(", ",$averages_per_days);
    // echo implode(", ",$min);
    // echo implode(", ",$max);
    for ($i = 0; $i < count($averages_per_days); $i++) {
        if ($max[$i] == -999999) {
            $max[$i] = 0;
        }
        if ($min[$i] == 999999) {
            $min[$i] = 0;
        }
        if ($averages_per_days[$i] != 0) {
            $averages[] = $averages_per_days[$i] / $total_valori_per_zile[$i];
        } else {
            $averages[] = 0;
        }
    }
    for ($i = 0; $i < count($averages); $i++) {
        // $pdf->Cell(5,20,"pentru i = ".$i. " avem valoarea ".$averages[$i],0,0,'J');
        // echo "pentru i = ".$i. " avem valoarea ".$array_with_dates_only_once[$i];
        $valori_pe_rows[$i] = $array_with_dates_only_once[$i] . ", " . $averages[$i] . ", " . $min[$i] . ", " . $max[$i];
        // echo $valori_pe_rows[$i];
    }

    // $averages = $averages_per_days[0]/$total_valori_per_zile[0];
    // $pdf->Cell(5,20,implode(" ", $min),0,0,'J');
    // $pdf->Ln();
    // Column widths
    $w = array(25, 50, 50, 50);
    // Header
    for ($i = 0; $i < count($headers); $i++)
        $pdf->Cell($w[$i], 7, $headers[$i], 1, 0, 'C');
    $pdf->Ln();
    // Data
    for ($i = 0; $i < count(array_unique($only_dates)); $i++) {
        $pdf->Cell($w[0], 7, $array_with_dates_only_once[$i], 'LR', 0, 'C');
        $pdf->Cell($w[1], 7, $averages[$i], 'LR', 0, 'C');
        $pdf->Cell($w[2], 7, $min[$i], 'LR', 0, 'C');
        $pdf->Cell($w[3], 7, $max[$i], 'LR', 0, 'C');
        $pdf->Ln();
    }
    // $pdf->Ln();
    // Closing line
    $number_of_averages_below = 0;
    $number_of_averages_normal = 0;
    $number_of_averages_above = 0;
    $pdf->Cell(array_sum($w), 0, '', 'T');
    $pdf->Ln();
    $pdf->SetFont('Arial', 'I', 11);
    for ($i = 0; $i < count(array_unique($only_dates)); $i++) {
        if ($averages[$i] <= 45) {
            $number_of_averages_below++;
        } else if ($averages[$i] > 45 || $averages[$i] <= 65) {
            $number_of_averages_normal++;
        } else if ($averages[$i] > 65) {
            $number_of_averages_above++;
        }
    }
    // $number_of_averages_below=0;
    // $number_of_averages_above=0;
    // $number_of_averages_normal=4;
    if ($number_of_averages_below >= count(array_unique($only_dates)) / 2) {
        $status = "Overall status of plants in the greenhouse (for soil humidity): underwatered";
        $recommendations = "Water your plants and check the water level in the water tank.";
        $pdf->SetTextColor(220, 50, 50);
        $pdf->Cell(0, 20, $status, 0, 0, 'J');
        $pdf->Ln(15);
        $pdf->MultiCell(0, 5, $recommendations);
        // $pdf ->Cell(0,20,$recommendations,0,0,'J');
        $pdf->Ln();
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 12);
    } else if ($number_of_averages_above >= count(array_unique($only_dates)) / 2) {
        $status = "Overall status of plants in the greenhouse (for soil humidity): overwatered";
        $recommendations = "Check the plants, and if you see that overwatering has ocurred, check the plants' draining,\nturn and aerate your soil, add compost to your soil, change the soil composition.";
        $pdf->SetTextColor(220, 50, 50);
        $pdf->Cell(0, 20, $status, 0, 0, 'J');
        $pdf->Ln(15);
        $pdf->MultiCell(0, 5, $recommendations);
        // $pdf ->Cell(0,20,$recommendations,0,0,'J');
        $pdf->Ln();
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 12);
    } else if ($number_of_averages_normal >= count(array_unique($only_dates)) / 2) {
        $status = "Overall status of plants in the greenhouse (for soil humidity): normal";
        $recommendations = "Soil humidity appears to be in good shape.";
        $pdf->SetTextColor(140, 16, 185);
        $pdf->Cell(0, 20, $status, 0, 0, 'J');
        $pdf->Ln(15);
        $pdf->MultiCell(0, 5, $recommendations);
        // $pdf ->Cell(0,20,$recommendations,0,0,'J');
        $pdf->Ln();
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 12);
    }

    $pdf->Ln(5);
    $pdf->Image('./imagini/umiditate_per_luna_curenta.png', null, null, -220, 100);
    $pdf->Ln(15);
}


// $pdf->ln();
if ($data_which_sensor == "light_sensor" || $data_which_sensor == "all_sensors") {
    $pdf->AddPage();
    $pdf->Ln(10);
    $pdf->Cell(5, 20, $light_title, 0, 0, 'J');
    $pdf->Ln();
    $pdf->Cell(5, -5, $reference_values_for_light, 0, 0, 'J');
    $pdf->Ln(6);

    $sql = "SELECT * FROM `senzorasi` WHERE id_senzor = 1 AND `timestamp` BETWEEN '" . $start_date . "' AND '" . $end_date . "' ORDER BY timestamp ASC;";
    $valori = [];
    $timestamps = [];
    $only_dates = [];

    if ($result = mysqli_query($link2, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $timestamp = new DateTime($row['timestamp']);
                $valori[] = $row['valoare'];
                $formatted_timestamp = $timestamp->format('d-m-Y H:i');
                $timestamps[] = $formatted_timestamp;
                $formatted_timestamp = $timestamp->format('d-m-Y');
                $only_dates[] = $formatted_timestamp;
            }
        } else {
            $pdf->SetFont('Arial', 'I', 11);
            $pdf->Cell(5, 20, "No data available for the selected dates", 0, 0, 'J');
            $pdf->Ln();
            $pdf->SetFont('Arial', '', 12);
        }
    }

    if (empty($only_dates)) {
        // If there are no dates, we can't proceed with the calculations
        $pdf->SetFont('Arial', 'I', 11);
        $pdf->Cell(5, 20, "No data available for the selected dates", 0, 0, 'J');
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 12);
        return;
    }

    $index = 0;
    $unique_dates = array_unique($only_dates);
    $total_valori_per_zile = array_fill(0, count($unique_dates), 0);
    $averages_per_days = array_fill(0, count($unique_dates), 0);
    $min = array_fill(0, count($unique_dates), 999999);
    $max = array_fill(0, count($unique_dates), -999999);
    $array_with_dates_only_once = [$only_dates[0]];

    $sql = "SELECT DISTINCT DATE(timestamp) AS unique_dates FROM senzorasi WHERE id_senzor = 1 AND `timestamp` BETWEEN '" . $start_date . "' AND '" . $end_date . "' ORDER BY timestamp ASC;";
    $dates_solo = [];
    if ($result = mysqli_query($link2, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $dates_solo[] = $row['unique_dates'];
            }
        } else {
            $pdf->SetFont('Arial', 'I', 11);
            $pdf->Cell(5, 20, "No data available for the selected dates", 0, 0, 'J');
            $pdf->Ln();
            $pdf->SetFont('Arial', '', 12);
        }
    }

    $old_date = $only_dates[0];
    for ($i = 0; $i < count($only_dates); $i++) {
        if ($only_dates[$i] == $old_date) {
            $averages_per_days[$index] += $valori[$i];
            $total_valori_per_zile[$index]++;
            if ($valori[$i] < $min[$index]) {
                $min[$index] = $valori[$i];
            }
            if ($valori[$i] > $max[$index]) {
                $max[$index] = $valori[$i];
            }
        } else {
            $index++;
            $array_with_dates_only_once[$index] = $only_dates[$i];
            if ($valori[$i] < $min[$index]) {
                $min[$index] = $valori[$i];
            }
            if ($valori[$i] > $max[$index]) {
                $max[$index] = $valori[$i];
            }
        }
        $old_date = $only_dates[$i];
    }

    $averages = [];
    for ($i = 0; $i < count($averages_per_days); $i++) {
        if ($max[$i] == -999999) {
            $max[$i] = 0;
        }
        if ($min[$i] == 999999) {
            $min[$i] = 0;
        }
        if ($averages_per_days[$i] != 0) {
            $averages[] = $averages_per_days[$i] / $total_valori_per_zile[$i];
        } else {
            $averages[] = 0;
        }
    }

    $valori_pe_rows = [];
    for ($i = 0; $i < count($averages); $i++) {
        $valori_pe_rows[$i] = $array_with_dates_only_once[$i] . ", " . $averages[$i] . ", " . $min[$i] . ", " . $max[$i];
    }

    $w = array(25, 50, 50, 50);
    for ($i = 0; $i < count($headers); $i++)
        $pdf->Cell($w[$i], 7, $headers[$i], 1, 0, 'C');
    $pdf->Ln();

    for ($i = 0; $i < count($unique_dates); $i++) {
        $pdf->Cell($w[0], 7, $array_with_dates_only_once[$i] ?? '', 'LR', 0, 'C');
        $pdf->Cell($w[1], 7, $averages[$i] ?? '', 'LR', 0, 'C');
        $pdf->Cell($w[2], 7, $min[$i] ?? '', 'LR', 0, 'C');
        $pdf->Cell($w[3], 7, $max[$i] ?? '', 'LR', 0, 'C');
        $pdf->Ln();
    }

    $number_of_averages_below = 0;
    $number_of_averages_normal = 0;
    $number_of_averages_above = 0;
    $pdf->Cell(array_sum($w), 0, '', 'T');
    $pdf->Ln();
    $pdf->SetFont('Arial', 'I', 11);

    for ($i = 0; $i < count($unique_dates); $i++) {
        if ($averages[$i] <= 45) {
            $number_of_averages_below++;
        } else if ($averages[$i] > 45 && $averages[$i] <= 65) {
            $number_of_averages_normal++;
        } else if ($averages[$i] > 65) {
            $number_of_averages_above++;
        }
    }

    if ($number_of_averages_below >= count($unique_dates) / 2) {
        $status = "Overall status of plants in the greenhouse (for light levels): underexposed";
        $recommendations = "Ensure your plants receive more light.";
        $pdf->SetTextColor(220, 50, 50);
        $pdf->Cell(0, 20, $status, 0, 0, 'J');
        $pdf->Ln(15);
        $pdf->MultiCell(0, 5, $recommendations);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 12);
    } else if ($number_of_averages_above >= count($unique_dates) / 2) {
        $status = "Overall status of plants in the greenhouse (for light levels): overexposed";
        $recommendations = "Reduce the light exposure for your plants.";
        $pdf->SetTextColor(220, 50, 50);
        $pdf->Cell(0, 20, $status, 0, 0, 'J');
        $pdf->Ln(15);
        $pdf->MultiCell(0, 5, $recommendations);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 12);
    } else if ($number_of_averages_normal >= count($unique_dates) / 2) {
        $status = "Overall status of plants in the greenhouse (for light levels): normal";
        $recommendations = "Light levels appear to be in good shape.";
        $pdf->SetTextColor(140, 16, 185);
        $pdf->Cell(0, 20, $status, 0, 0, 'J');
        $pdf->Ln(15);
        $pdf->MultiCell(0, 5, $recommendations);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 12);
    }

    $pdf->Ln(5);
    $pdf->Image('./imagini/light_levels_per_luna_curenta.png', null, null, -220, 100);
    $pdf->Ln(15);
}






if ($data_which_sensor == "air_humidity" || $data_which_sensor == "all_sensors") {
    $pdf->AddPage();
    $pdf->Ln(10);
    $pdf->Cell(5, 20, $air_humidity_title, 0, 0, 'J');
    $pdf->Ln();
    $pdf->Cell(5, -5, $reference_values_for_air_humidity, 0, 0, 'J');
    $pdf->Ln(6);

    $sql = "SELECT * FROM `senzorasi` WHERE id_senzor = 4 AND `timestamp` BETWEEN '" . $start_date . "' AND '" . $end_date . "' ORDER BY timestamp ASC;";
    $valori = [];
    $timestamps = [];
    $only_dates = [];

    if ($result = mysqli_query($link2, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $timestamp = new DateTime($row['timestamp']);
                $valori[] = $row['valoare'];
                $formatted_timestamp = $timestamp->format('d-m-Y H:i');
                $timestamps[] = $formatted_timestamp;
                $formatted_timestamp = $timestamp->format('d-m-Y');
                $only_dates[] = $formatted_timestamp;
            }
        } else {
            $pdf->SetFont('Arial', 'I', 11);
            $pdf->Cell(5, 20, "No data available for the selected dates", 0, 0, 'J');
            $pdf->Ln();
            $pdf->SetFont('Arial', '', 12);
        }
    }

    if (empty($only_dates)) {
        // If there are no dates, we can't proceed with the calculations
        $pdf->SetFont('Arial', 'I', 11);
        $pdf->Cell(5, 20, "No data available for the selected dates", 0, 0, 'J');
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 12);
        return;
    }

    $index = 0;
    $unique_dates = array_unique($only_dates);
    $total_valori_per_zile = array_fill(0, count($unique_dates), 0);
    $averages_per_days = array_fill(0, count($unique_dates), 0);
    $min = array_fill(0, count($unique_dates), 999999);
    $max = array_fill(0, count($unique_dates), -999999);
    $array_with_dates_only_once = [$only_dates[0]];

    $sql = "SELECT DISTINCT DATE(timestamp) AS unique_dates FROM senzorasi WHERE id_senzor = 4 AND `timestamp` BETWEEN '" . $start_date . "' AND '" . $end_date . "' ORDER BY timestamp ASC;";
    $dates_solo = [];
    if ($result = mysqli_query($link2, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $dates_solo[] = $row['unique_dates'];
            }
        } else {
            $pdf->SetFont('Arial', 'I', 11);
            $pdf->Cell(5, 20, "No data available for the selected dates", 0, 0, 'J');
            $pdf->Ln();
            $pdf->SetFont('Arial', '', 12);
        }
    }

    $old_date = $only_dates[0];
    for ($i = 0; $i < count($only_dates); $i++) {
        if ($only_dates[$i] == $old_date) {
            $averages_per_days[$index] += $valori[$i];
            $total_valori_per_zile[$index]++;
            if ($valori[$i] < $min[$index]) {
                $min[$index] = $valori[$i];
            }
            if ($valori[$i] > $max[$index]) {
                $max[$index] = $valori[$i];
            }
        } else {
            $index++;
            $array_with_dates_only_once[$index] = $only_dates[$i];
            if ($valori[$i] < $min[$index]) {
                $min[$index] = $valori[$i];
            }
            if ($valori[$i] > $max[$index]) {
                $max[$index] = $valori[$i];
            }
        }
        $old_date = $only_dates[$i];
    }

    $averages = [];
    for ($i = 0; $i < count($averages_per_days); $i++) {
        if ($max[$i] == -999999) {
            $max[$i] = 0;
        }
        if ($min[$i] == 999999) {
            $min[$i] = 0;
        }
        if ($averages_per_days[$i] != 0) {
            $averages[] = $averages_per_days[$i] / $total_valori_per_zile[$i];
        } else {
            $averages[] = 0;
        }
    }

    $valori_pe_rows = [];
    for ($i = 0; $i < count($averages); $i++) {
        $valori_pe_rows[$i] = $array_with_dates_only_once[$i] . ", " . $averages[$i] . ", " . $min[$i] . ", " . $max[$i];
    }

    $w = array(25, 50, 50, 50);
    for ($i = 0; $i < count($headers); $i++)
        $pdf->Cell($w[$i], 7, $headers[$i], 1, 0, 'C');
    $pdf->Ln();

    for ($i = 0; $i < count($unique_dates); $i++) {
        $pdf->Cell($w[0], 7, $array_with_dates_only_once[$i] ?? '', 'LR', 0, 'C');
        $pdf->Cell($w[1], 7, $averages[$i] ?? '', 'LR', 0, 'C');
        $pdf->Cell($w[2], 7, $min[$i] ?? '', 'LR', 0, 'C');
        $pdf->Cell($w[3], 7, $max[$i] ?? '', 'LR', 0, 'C');
        $pdf->Ln();
    }

    $number_of_averages_below = 0;
    $number_of_averages_normal = 0;
    $number_of_averages_above = 0;
    $pdf->Cell(array_sum($w), 0, '', 'T');
    $pdf->Ln();
    $pdf->SetFont('Arial', 'I', 11);

    for ($i = 0; $i < count($unique_dates); $i++) {
        if ($averages[$i] <= 45) {
            $number_of_averages_below++;
        } else if ($averages[$i] > 45 && $averages[$i] <= 65) {
            $number_of_averages_normal++;
        } else if ($averages[$i] > 65) {
            $number_of_averages_above++;
        }
    }

    if ($number_of_averages_below >= count($unique_dates) / 2) {
        $status = "Overall status of plants in the greenhouse (for air humidity): too low";
        $recommendations = "Increase humidity levels.";
        $pdf->SetTextColor(220, 50, 50);
        $pdf->Cell(0, 20, $status, 0, 0, 'J');
        $pdf->Ln(15);
        $pdf->MultiCell(0, 5, $recommendations);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 12);
    } else if ($number_of_averages_above >= count($unique_dates) / 2) {
        $status = "Overall status of plants in the greenhouse (for air humidity): too high";
        $recommendations = "Decrease humidity levels.";
        $pdf->SetTextColor(220, 50, 50);
        $pdf->Cell(0, 20, $status, 0, 0, 'J');
        $pdf->Ln(15);
        $pdf->MultiCell(0, 5, $recommendations);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 12);
    } else if ($number_of_averages_normal >= count($unique_dates) / 2) {
        $status = "Overall status of plants in the greenhouse (for air humidity): normal";
        $recommendations = "Humidity levels are good.";
        $pdf->SetTextColor(140, 16, 185);
        $pdf->Cell(0, 20, $status, 0, 0, 'J');
        $pdf->Ln(15);
        $pdf->MultiCell(0, 5, $recommendations);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 12);
    }

    $pdf->Ln(5);
    $pdf->Image('./imagini/air_humidity_levels_per_luna_curenta.png', null, null, -220, 100);
    $pdf->Ln(15);
}

if ($data_which_sensor == "temperature" || $data_which_sensor == "all_sensors") {
    $pdf->AddPage();
    $pdf->Ln(10);
    $pdf->Cell(5, 20, $temp_title, 0, 0, 'J');
    $pdf->Ln();
    $pdf->Cell(5, -5, $reference_values_for_temperature, 0, 0, 'J');
    $pdf->Ln(6);

    $sql = "SELECT * FROM `senzorasi` WHERE id_senzor = 5 AND `timestamp` BETWEEN '" . $start_date . "' AND '" . $end_date . "' ORDER BY timestamp ASC;";
    $valori = [];
    $timestamps = [];
    $only_dates = [];

    if ($result = mysqli_query($link2, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $timestamp = new DateTime($row['timestamp']);
                $valori[] = $row['valoare'];
                $formatted_timestamp = $timestamp->format('d-m-Y H:i');
                $timestamps[] = $formatted_timestamp;
                $formatted_timestamp = $timestamp->format('d-m-Y');
                $only_dates[] = $formatted_timestamp;
            }
        } else {
            $pdf->SetFont('Arial', 'I', 11);
            $pdf->Cell(5, 20, "No data available for the selected dates", 0, 0, 'J');
            $pdf->Ln();
            $pdf->SetFont('Arial', '', 12);
        }
    }

    if (empty($only_dates)) {
        // If there are no dates, we can't proceed with the calculations
        $pdf->SetFont('Arial', 'I', 11);
        $pdf->Cell(5, 20, "No data available for the selected dates", 0, 0, 'J');
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 12);
        return;
    }

    $index = 0;
    $unique_dates = array_unique($only_dates);
    $total_valori_per_zile = array_fill(0, count($unique_dates), 0);
    $averages_per_days = array_fill(0, count($unique_dates), 0);
    $min = array_fill(0, count($unique_dates), 999999);
    $max = array_fill(0, count($unique_dates), -999999);
    $array_with_dates_only_once = [$only_dates[0]];

    $sql = "SELECT DISTINCT DATE(timestamp) AS unique_dates FROM senzorasi WHERE id_senzor = 5 AND `timestamp` BETWEEN '" . $start_date . "' AND '" . $end_date . "' ORDER BY timestamp ASC;";
    $dates_solo = [];
    if ($result = mysqli_query($link2, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $dates_solo[] = $row['unique_dates'];
            }
        } else {
            $pdf->SetFont('Arial', 'I', 11);
            $pdf->Cell(5, 20, "No data available for the selected dates", 0, 0, 'J');
            $pdf->Ln();
            $pdf->SetFont('Arial', '', 12);
        }
    }

    $old_date = $only_dates[0];
    for ($i = 0; $i < count($only_dates); $i++) {
        if ($only_dates[$i] == $old_date) {
            $averages_per_days[$index] += $valori[$i];
            $total_valori_per_zile[$index]++;
            if ($valori[$i] < $min[$index]) {
                $min[$index] = $valori[$i];
            }
            if ($valori[$i] > $max[$index]) {
                $max[$index] = $valori[$i];
            }
        } else {
            $index++;
            $array_with_dates_only_once[$index] = $only_dates[$i];
            if ($valori[$i] < $min[$index]) {
                $min[$index] = $valori[$i];
            }
            if ($valori[$i] > $max[$index]) {
                $max[$index] = $valori[$i];
            }
        }
        $old_date = $only_dates[$i];
    }

    $averages = [];
    for ($i = 0; $i < count($averages_per_days); $i++) {
        if ($max[$i] == -999999) {
            $max[$i] = 0;
        }
        if ($min[$i] == 999999) {
            $min[$i] = 0;
        }
        if ($averages_per_days[$i] != 0) {
            $averages[] = $averages_per_days[$i] / $total_valori_per_zile[$i];
        } else {
            $averages[] = 0;
        }
    }

    $valori_pe_rows = [];
    for ($i = 0; $i < count($averages); $i++) {
        $valori_pe_rows[$i] = $array_with_dates_only_once[$i] . ", " . $averages[$i] . ", " . $min[$i] . ", " . $max[$i];
    }

    $w = array(25, 50, 50, 50);
    for ($i = 0; $i < count($headers); $i++)
        $pdf->Cell($w[$i], 7, $headers[$i], 1, 0, 'C');
    $pdf->Ln();

    for ($i = 0; $i < count($unique_dates); $i++) {
        $pdf->Cell($w[0], 7, $array_with_dates_only_once[$i] ?? '', 'LR', 0, 'C');
        $pdf->Cell($w[1], 7, $averages[$i] ?? '', 'LR', 0, 'C');
        $pdf->Cell($w[2], 7, $min[$i] ?? '', 'LR', 0, 'C');
        $pdf->Cell($w[3], 7, $max[$i] ?? '', 'LR', 0, 'C');
        $pdf->Ln();
    }

    $number_of_averages_below = 0;
    $number_of_averages_normal = 0;
    $number_of_averages_above = 0;
    $pdf->Cell(array_sum($w), 0, '', 'T');
    $pdf->Ln();
    $pdf->SetFont('Arial', 'I', 11);

    for ($i = 0; $i < count($unique_dates); $i++) {
        if ($averages[$i] <= 18) {
            $number_of_averages_below++;
        } else if ($averages[$i] > 18 && $averages[$i] <= 25) {
            $number_of_averages_normal++;
        } else if ($averages[$i] > 25) {
            $number_of_averages_above++;
        }
    }

    if ($number_of_averages_below >= count($unique_dates) / 2) {
        $status = "Overall status of plants in the greenhouse (for temperature): too low";
        $recommendations = "Increase temperature levels.";
        $pdf->SetTextColor(220, 50, 50);
        $pdf->Cell(0, 20, $status, 0, 0, 'J');
        $pdf->Ln(15);
        $pdf->MultiCell(0, 5, $recommendations);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 12);
    } else if ($number_of_averages_above >= count($unique_dates) / 2) {
        $status = "Overall status of plants in the greenhouse (for temperature): too high";
        $recommendations = "Decrease temperature levels.";
        $pdf->SetTextColor(220, 50, 50);
        $pdf->Cell(0, 20, $status, 0, 0, 'J');
        $pdf->Ln(15);
        $pdf->MultiCell(0, 5, $recommendations);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 12);
    } else if ($number_of_averages_normal >= count($unique_dates) / 2) {
        $status = "Overall status of plants in the greenhouse (for temperature): normal";
        $recommendations = "Temperature levels are good.";
        $pdf->SetTextColor(140, 16, 185);
        $pdf->Cell(0, 20, $status, 0, 0, 'J');
        $pdf->Ln(15);
        $pdf->MultiCell(0, 5, $recommendations);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 12);
    }

    $pdf->Ln(5);
    $pdf->Image('./imagini/temperature_levels_per_luna_curenta.png', null, null, -220, 100);
    $pdf->Ln(15);
}


// ob_end_clean(); 
$pdf->Output();

// $ob_end;
