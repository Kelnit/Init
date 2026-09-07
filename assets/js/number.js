const lineCharts = [
  {
    id: 'trendRegisChart', 
    tab: 'tab-regis', 
    panel: 'tabpanel-regis', 
    border: '#0E6B63', 
    point: '#0E6B63', 
    label: 'Registrasi Baru', 
    satuan: 'Pasien' 
  },
  { 
    id: 'trendMasaTinggalChart', 
    tab: 'tab-masatinggal', 
    panel: 'tabpanel-masatinggal', 
    border: '#2f6690', 
    point: '#1c4a68', 
    label: 'Masa Tinggal Diluar Ranap', 
    satuan: 'Hari' 
  }
];

function hexToRgba(hex, alpha) {
  const r = parseInt(hex.slice(1, 3), 16);
  const g = parseInt(hex.slice(3, 5), 16);
  const b = parseInt(hex.slice(5, 7), 16);
  return `rgba(${r}, ${g}, ${b}, ${alpha})`;
}

function renderLineChart(config) {
  // ?
  const chartElement = document.getElementById(config.id);
  if (!chartElement) return null;
  // ?
  const ctx = chartElement.getContext('2d');
  const valueData = JSON.parse(chartElement.getAttribute('data-value'));
  const gradient = ctx.createLinearGradient(0, 0, 0, 300);
  gradient.addColorStop(0, hexToRgba(config.border, 0.15));
  gradient.addColorStop(1, hexToRgba(config.border, 0));
  // ?
  return new Chart(ctx, {
    type: 'line',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
      datasets: [{
        label: config.label + ' (' + config.satuan + ')',
        data: valueData,
        fill: true,
        backgroundColor: gradient,
        borderColor: config.border,
        borderWidth: 2,
        tension: 0.35,
        pointRadius: 4,
        pointHoverRadius: 6,
        pointBackgroundColor: '#ffffff',
        pointBorderColor: config.point,
        pointBorderWidth: 2
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false }
      },
      scales: {
        y: {
          beginAtZero: true,
          grid: { color: '#eceef1' }
        },
        x: {
          grid: { display: false }
        }
      }
    }
  });
}

const lineChartInstances = {};

lineCharts.forEach(config => { lineChartInstances[config.id] = renderLineChart(config); });

lineCharts.forEach(config => {
  const tabInput = document.getElementById(config.tab);
  const panelElement = document.getElementById(config.panel);
  if (!tabInput || !panelElement) return;
  tabInput.addEventListener('change', () => {
    document.querySelectorAll('.trend-panel').forEach(panel => panel.classList.remove('active'));
    panelElement.classList.add('active');
    const chart = lineChartInstances[config.id];
    if (chart) chart.resize();
  });
});