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
          backgroundColor: ['transparent'],
          borderColor: ['rgb(30,144,255)'],
          borderWidth: 2,
          cubicInterpolationMode: "monotone",
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
          backgroundColor: ['transparent'],
          borderColor: ['green'],
          borderWidth: 3,
          cubicInterpolationMode: "monotone"
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
          backgroundColor: ['transparent'],
          borderColor: ['red'],
          borderWidth: 3,
          cubicInterpolationMode: "monotone"
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
          backgroundColor: ['transparent'],
          borderColor: ['black'],
          borderWidth: 3,
          cubicInterpolationMode: "monotone"
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