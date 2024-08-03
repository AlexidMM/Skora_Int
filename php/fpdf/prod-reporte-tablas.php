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
include ("../conexion.php");
include("fpdf186/html_table.php");

$pdf = new pdf();
$pdf->AddPage();

$pdf->SetFont('Arial','B',18);
$pdf->Cell(190,10,'Skora',0,0,'C');
$pdf->Ln();
$pdf->SetFont('Arial','',12);
date_default_timezone_set('America/Mexico_City');
$pdf->Cell(190,10,date('d/m/Y'),0,0,'C');
$pdf->Ln();
$pdf->SetFont('Arial','B',11);
$pdf->Cell(190,10,'REPORTE DE ARTICULOS',0,0,'C');
$pdf->Ln();

$miencabeza = "
<table border='1' style='margin: 0 auto;' width='100%'>
<tr>
<td width=20 bgcolor='#91DDCF'>Id</td>
<td width=110 bgcolor='#91DDCF'>Nombre</td>
<td width=75 bgcolor='#91DDCF'>Costo</td>
<td width=75 bgcolor='#91DDCF'>Precio</td>
<td width=109 bgcolor='#91DDCF'>Material</td>
<td width=280 bgcolor='#91DDCF'>Descripcion</td>
<td width=70 bgcolor='#91DDCF'>Categoria</td>
<td width=75 bgcolor='#91DDCF'>Status</td>
</tr>
</table>
";

// Recibir el ID del artículo seleccionado
$id_articulo = $_POST['articulo'];

if ($id_articulo == 'todos') {
    //conección con BD articulos
    $sqla = "SELECT 
      a.id_art,
      a.nom_art,
      a.cost_art,
      a.prec_art,
      a.desc_art,
      a.Status,
      m.nom_mat,
      c.nom_cat
    FROM 
      ARTICULO a
      INNER JOIN MATERIAL m ON a.id_mat = m.id_mat
      INNER JOIN CATEGORIA c ON a.id_cat = c.id_cat";
} else {
    $sqla = "SELECT 
      a.id_art,
      a.nom_art,
      a.cost_art,
      a.prec_art,
      a.desc_art,
      a.Status,
      m.nom_mat,
      c.nom_cat
    FROM 
      ARTICULO a
      INNER JOIN MATERIAL m ON a.id_mat = m.id_mat
      INNER JOIN CATEGORIA c ON a.id_cat = c.id_cat
      WHERE a.id_art = '$id_articulo'";
}

$resa = mysqli_query($conexion,$sqla);
$mitabla = "
<table border='1' style='margin: 0 auto;' width='100%'>
";
while ($fila = mysqli_fetch_array($resa)){
$mitabla.="
<tr>
<td width=20 align='center'>".$fila["id_art"]."</td>
<td width=110 align='center'>".$fila["nom_art"]."</td>
<td width=75 align='center'>".$fila["cost_art"]."</td>
<td width=75 align='center'>".$fila["prec_art"]."</td>
<td width=109 align='center'>".$fila["nom_mat"]."</td>
<td width=280 align='center'>".$fila["desc_art"]."</td>
<td width=70 align='center'>".$fila["nom_cat"]."</td>
<td width=75 align='center'>".$fila["Status"]."</td>
</tr>
";
}
$mitabla.="</table>";
//salida al PDF
$pdf->Ln();
$pdf->SetFont('Arial', '', 8);
$pdf->WriteHTML($miencabeza);
$pdf->WriteHTML($mitabla);
$pdf->Output('Reporte_Articulos_Skora.pdf', 'I');
?>