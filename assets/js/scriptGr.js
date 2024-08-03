const chart = document.getElementById('chart');
const generarGrafica = document.getElementById('generar-grafica');

generarGrafica.addEventListener('click', async () => {
  const response = await fetch('datos.php');
  const datos = await response.json();

  const labels = datos.map(d => d.nom_art);
  const data = datos.map(d => d.cant_vend);

  const chartData = {
    labels,
    datasets: [{
      label: 'Artículos más vendidos',
      data,
      backgroundColor: 'rgba(255, 99, 132, 0.2)',
      borderColor: 'rgba(255, 99, 132, 1)',
      borderWidth: 1
    }]
  };

  const chartOptions = {
    title: {
      display: true,
      text: 'Artículos más vendidos'
    },
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: true
        }
      }]
    }
  };

  const ctx = chart.getContext('2d');
  const myChart = new Chart(ctx, {
    type: 'bar',
    data: chartData,
    options: chartOptions
  });

  // Generar PDF
  const pdf = new jsPDF();
  pdf.addImage(chart.toDataURL(), 'PNG', 0, 0, 210, 150);
  pdf.save('grafica.pdf');
});