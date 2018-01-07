$.ajax({
  type: 'POST',
  url: root + "ajax/getRoomChart.php",
  dataType: 'json',
  success: function(response) {
    var roomChart = new Chart($("#roomChart"), {
      type: 'line',
      data: {
        labels: response[0],
        datasets: [{
          label: '# of Used',
          data: response[1],
          backgroundColor: ['lightblue'],
          borderColor: ['blue'],
          borderWidth: 1
        }]
      },
      options: {
        maintainAspectRatio: false,
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true
            }
          }]
        }
      }
    });
  }
});
$.ajax({
  type: 'POST',
  url: root + "ajax/getBookingChart.php",
  dataType: 'json',
  success: function(response) {
    var roomChart = new Chart($("#bookingChart"), {
      type: 'line',
      data: {
        labels: response[0],
        datasets: [{
          label: '# of Users',
          data: response[1],
          backgroundColor: ['lightgreen'],
          borderColor: ['green'],
          borderWidth: 1
        }]
      },
      options: {
        maintainAspectRatio: false,
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true
            }
          }]
        }
      }
    });
  }
});
$.ajax({
  type: 'POST',
  url: root + "ajax/getWalkInChart.php",
  dataType: 'json',
  success: function(response) {
    var roomChart = new Chart($("#walkInChart"), {
      type: 'line',
      data: {
        labels: response[0],
        datasets: [{
          label: '# of Users',
          data: response[1],
          backgroundColor: ['rgb(255, 77, 77)'],
          borderColor: ['red'],
          borderWidth: 1
        }]
      },
      options: {
        maintainAspectRatio: false,
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true
            }
          }]
        }
      }
    });
  }
});
$.ajax({
  type: 'POST',
  url: root + "ajax/getVisitorChart.php",
  dataType: 'json',
  success: function(response) {
    var roomChart = new Chart($("#visitorChart"), {
      type: 'line',
      data: {
        labels: response[0],
        datasets: [{
          label: '# of Users',
          data: response[1],
          backgroundColor: ['gray'],
          borderColor: ['black'],
          borderWidth: 1
        }]
      },
      options: {
        maintainAspectRatio: false,
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true
            }
          }]
        }
      }
    });
  }
});