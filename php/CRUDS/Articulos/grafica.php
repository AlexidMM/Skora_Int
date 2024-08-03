<?php
    session_start();
    require '../../conexion.php';
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
$query = "SELECT nom_art, cant_vend FROM articulos_vendidos";
$result = $conexion->query($query);

$data = array();
foreach ($result as $row) {
    $data[] = array($row['nom_art'], (int) $row['cant_vend']);
}

?>

<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Producto', 'Ventas'],
          <?php foreach ($data as $row) {?>
            ['<?= $row[0]?>', <?= $row[1]?>],
          <?php }?>
        ]);

        var options = {
          title: 'Productos más vendidos',
          legend: 'none'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);

        // Generate the chart image
        var chartImg = chart.getImageURI();

        // Create a PNG image from the URI
        var pngImg = '<img src="' + chartImg + '">';

        // Create a link to download the PNG image
        var downloadLink = document.createElement('a');
        downloadLink.href = chartImg;
        downloadLink.download = 'productos_mas_vendidos.png';
        downloadLink.innerHTML = 'Descargar imagen';

        // Add the link to the page
        var returnButton = document.createElement('button');
        returnButton.innerHTML = 'Regresar';
        returnButton.onclick = function() {
            window.location.href = 'articulos.php';
        }

        document.getElementById('download-link').appendChild(downloadLink);
        document.getElementById('download-link').appendChild(returnButton);

      }
    </script>
  </head>
  <body>
    <div id="piechart" style="width: 100%; max-width:900px; height: 500px;"></div>
    <div id="download-link"></div>
  </body>
</html>