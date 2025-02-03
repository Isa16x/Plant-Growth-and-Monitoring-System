<?php
require('./fpdf/fpdf.php');

class PDF extends FPDF
{
// Load data
function LoadData($file)
{
    // Read file lines
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "db_dummy";

    $conn = mysqli_connect($servername, $username, $password, $database);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql_humidity = "SELECT id_senzor.denumire as denumire_senzor, senzorasi.valoare, senzorasi.timestamp, unitati_masura.denumire as unitate_masura 
    FROM `senzorasi` 
    JOIN id_senzor ON id_senzor.id_senzor = senzorasi.id_senzor 
    JOIN unitati_masura ON unitati_masura.id_unitate = senzorasi.id_unitate 
    WHERE senzorasi.id_senzor = '2';";
    $result_humidity = mysqli_query($conn, $sql_humidity);

    $dataPoints_humidity = array();

    if (mysqli_num_rows($result_humidity) > 0) {
        while ($row = mysqli_fetch_assoc($result_humidity)) {
            $timestamp_ms = strtotime($row['timestamp']) * 1000;
            array_push($dataPoints_humidity, array("x" => $timestamp_ms, "y" => $row['valoare']));
        }
    }

    $data = array();
    foreach($lines as $line)
        $data[] = explode(';',trim($line));
    return $data;
}

// Better table
function ImprovedTable($header, $data)
{
    // Column widths
    $w = array(40, 35, 40, 45);
    // Header
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C');
    $this->Ln();
    // Data
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR');
        $this->Cell($w[1],6,$row[1],'LR');
        $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R');
        $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R');
        $this->Ln();
    }
    // Closing line
    $this->Cell(array_sum($w),0,'','T');
}


}

$pdf = new PDF();
// Column headings
$header = array('Country', 'Capital', 'Area (sq km)', 'Pop. (thousands)');
// Data loading
$data = $pdf->LoadData('countries.txt');
$pdf->SetFont('Arial','',14);
$pdf->AddPage();
$pdf->BasicTable($header,$data);
$pdf->AddPage();
$pdf->ImprovedTable($header,$data);
$pdf->AddPage();
$pdf->FancyTable($header,$data);
$pdf->Output();

// class PDF extends FPDF
// {
// // Page header
// function Header()
// {
//     // Logo
//     $this->Image('./imagini/cucumber-flowers-need-know.jpg.jpg',10,6,30);
//     // Arial bold 15
//     $this->SetFont('Arial','B',15);
//     // Move to the right
//     $this->Cell(80);
//     // Title
//     $this->Cell(30,10,'Title',1,0,'C');
//     // Line break
//     $this->Ln(20);
// }

// // Page footer
// function Footer()
// {
//     // Position at 1.5 cm from bottom
//     $this->SetY(-15);
//     // Arial italic 8
//     $this->SetFont('Arial','I',8);
//     // Page number
//     $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
// }
// }

// // Instanciation of inherited class
// $pdf = new PDF();
// $pdf->AliasNbPages();
// $pdf->AddPage();
// $pdf->SetFont('Times','',12);
// for($i=1;$i<=40;$i++)
//     $pdf->Cell(0,10,'Printing line number '.$i,0,1);
// $pdf->Output();

// $pdf->Output('D','filename.pdf');
?>