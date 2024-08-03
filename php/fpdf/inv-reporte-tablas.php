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

$pdf = new pdf();
$pdf->AddPage();

$pdf->SetFont('Arial','B',18);
$pdf->Cell(190,10,'Skora',0,0,'C');
$pdf->Ln();
$pdf->SetFont('Arial','',12);
$pdf->Cell(190,10,date('d/m/Y'),0,0,'C');
$pdf->Ln();
$pdf->SetFont('Arial','B',11);
$pdf->Cell(190,10,'REPORTE DE INVENTARIO',0,0,'C');
$pdf->Ln();

$miencabeza = "
<table border='1' style='margin: 0 auto;' width='100%'>
<tr>
<td width=150 bgcolor='#91DDCF'>Numero</td>
<td width=150 bgcolor='#91DDCF'>Existencia</td>
<td width=150 bgcolor='#91DDCF'>Sucursal</td>
<td width=150 bgcolor='#91DDCF'>Articulo</td>
<td width=80 bgcolor='#91DDCF'>Status</td>
</tr>
</table>
";

//conección con BD inventario
$sqla = "SELECT 
  i.no_inv,
  i.exist_inv,
  s.nom_suc,
  a.nom_art,
  i.Status
FROM 
  INVENTARIO i
  INNER JOIN SUCURSAL s ON i.no_suc = s.no_suc
  INNER JOIN ARTICULO a ON i.id_art = a.id_art
  ORDER BY i.no_inv";
$resa = mysqli_query($conexion,$sqla);
$mitabla = "
<table border='1' style='margin: 0 auto;' width='100%'>
";
while ($fila = mysqli_fetch_array($resa)){
$mitabla.="
<tr>
<td width=150 align='center'>".$fila["no_inv"]."</td>
<td width=150 align='center'>".$fila["exist_inv"]."</td>
<td width=150 align='center'>".$fila["nom_suc"]."</td>
<td width=150 align='center'>".$fila["nom_art"]."</td>
<td width=80 align='center'>".$fila["Status"]."</td>
</tr>
";
}
$mitabla.="</table>";
//salida al PDF
$pdf->Ln();
$pdf->SetFont('Arial', '', 9);
$pdf->WriteHTML($miencabeza);
$pdf->WriteHTML($mitabla);
$pdf->Output('Reporte_Inventario_Skora.pdf', 'I');
?>
