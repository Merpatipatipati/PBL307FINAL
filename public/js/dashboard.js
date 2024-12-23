document.addEventListener('DOMContentLoaded', () => {
  // Helper: Create Center Text Plugin
  const createCenterTextPlugin = (chartId, fontSize = 'bold 20px Arial', fontColor = '#000') => ({
    id: `${chartId}CenterText`,
    beforeDraw(chart) {
      const { width, height, ctx } = chart;
      ctx.save();
      const total = chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
      ctx.font = fontSize;
      ctx.fillStyle = fontColor;
      ctx.textAlign = 'center';
      ctx.textBaseline = 'middle';
      ctx.fillText(total, width / 2, height / 2);
      ctx.restore();
    },
  });

  // User Chart
  const userChart = new Chart(document.getElementById('userChart'), {
    type: 'pie', // You can change this to bar, line, etc. as needed
    data: {
      labels: ['Verified', 'Non-Verified', 'Banned'],
      datasets: [{
        label: 'Total Users',
        data: totalUsersData, // Pass the numeric values here
        backgroundColor: ['#66bb6a','#8bc34a', '#f44336'], // Set colors for each category
        borderColor: ['#1e88e5', '#43a047', '#f4511e'],
        borderWidth: 1
      }]
    }
  });

  // Chart for Total Products
  const productChart = new Chart(document.getElementById('productChart'), {
    type: 'pie',
    data: {
      labels: Object.keys(totalProductsData), // Use category names as labels
      datasets: [{
        label: 'Total Products',
        data: totalProductsData, // Pass the numeric values for product categories
        backgroundColor: ['#ff0000', '#ff7f00', '#ffff00', '#00ff00', '#0000ff', '#4b0082', '#00ff7f', '#ff1493', '#ff6347', '#32cd32', '#00bfff', '#ff69b4', '#ff4500'], 
        borderColor: ['#fbc02d', '#ab47bc', '#00acc1', '#ff7043', '#66bb6a', '#5c6bc0', '#c0ca33', '#455a64', '#e57373', '#6d4c41', '#00796b', '#8e24aa', '#c2185b'],
        borderWidth: 1
      }]
    }
  });

  // Chart for Total Posts
  const postChart = new Chart(document.getElementById('postChart'), {
    type: 'pie',
    data: {
      labels: ['With Image', 'Without Image'],
      datasets: [{
        label: 'Total Posts',
        data: totalPostsData, // Pass the numeric values for posts with and without images
        backgroundColor: ['#ffeb3b', '#ff9800'],
        borderColor: ['#4caf50', '#ff5722'],
        borderWidth: 1
      }]
    }
  });
});