// Load data from PHP using AJAX
function fetchData() {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        var data = JSON.parse(this.responseText);
        createChart(data);
      }
    };
    xhr.open("GET", "data.php", true);
    xhr.send();
  }
  
  // Create a chart using Chart.js
  function createChart(data) {
    var ctx = document.getElementById('subscriptionChart').getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: data.labels,
        datasets: [{
          label: 'Subscription Count',
          data: data.values,
          backgroundColor: 'rgba(75, 192, 192, 0.2)',
          borderColor: 'rgba(75, 192, 192, 1)',
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  }
  
  // Fetch data when the page loads
  document.addEventListener('DOMContentLoaded', fetchData);
  