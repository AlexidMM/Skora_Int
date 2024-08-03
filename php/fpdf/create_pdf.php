<?php
    session_start();
    require '../conexion.php';
    // Verificar si el usuario ha iniciado sesión y si es administrador
    if (!isset($_SESSION['nom_us']) || $_SESSION['tipo_us'] != '1') {
        echo '
            <script>
                alert("Acceso denegado. Solo los administradores pueden acceder a esta página.");
                window.location = "../../../login.php";
            </script>
        ';
        exit;
    }
?>


<?php
include("fpdf186/html_table.php");

$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetFont('Arial','B',18);
$pdf->Cell(190,10,'Skora',0,0,'C');
$pdf->Ln();
$pdf->SetFont('Arial','',12);
date_default_timezone_set('America/Mexico_City');
$pdf->Cell(190,10,date('d/m/Y'),0,0,'C');
$pdf->Ln();
$pdf->SetFont('Arial','B',11);
$pdf->Cell(190,10,'GRÁFICA DE PRODUCTOS MÁS VENDIDOS',0,0,'C');
$pdf->Ln();

// Get the chart image from the URL parameter
$chartImg = $_GET['chartImg'];

// Add the chart image to the PDF
$pdf->Image($chartImg, 10, 50, 180);

$pdf->Output('Grafica_Productos_Vendidos.pdf', 'I');
?>