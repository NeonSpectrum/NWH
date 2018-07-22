$.ajax({
  type: "POST",
  url: root + "ajax/getRoomChart.php",
  dataType: "json",
  success: function(response) {
    new Chart($("#roomChart"), {
      type: "line",
      data: {
        labels: response[0],
        datasets: [
          {
            label: "# of Used",
            data: response[1],
            backgroundColor: ["transparent"],
            borderColor: ["rgb(30,144,255)"],
            borderWidth: 2,
            cubicInterpolationMode: "monotone"
          }
        ]
      },
      options: {
        maintainAspectRatio: false,
        scales: {
          yAxes: [
            {
              ticks: {
                beginAtZero: true
              }
            }
          ]
        }
      }
    })
  }
})
$.ajax({
  type: "POST",
  url: root + "ajax/getBookingChart.php",
  dataType: "json",
  success: function(response) {
    new Chart($("#bookingChart"), {
      type: "line",
      data: {
        labels: response[0],
        datasets: [
          {
            label: "# of Guests",
            data: response[1],
            backgroundColor: ["transparent"],
            borderColor: ["green"],
            borderWidth: 3,
            cubicInterpolationMode: "monotone"
          }
        ]
      },
      options: {
        maintainAspectRatio: false,
        scales: {
          yAxes: [
            {
              ticks: {
                beginAtZero: true
              }
            }
          ]
        }
      }
    })
  }
})
$.ajax({
  type: "POST",
  url: root + "ajax/getWalkInChart.php",
  dataType: "json",
  success: function(response) {
    new Chart($("#walkInChart"), {
      type: "line",
      data: {
        labels: response[0],
        datasets: [
          {
            label: "# of Guests",
            data: response[1],
            backgroundColor: ["transparent"],
            borderColor: ["red"],
            borderWidth: 3,
            cubicInterpolationMode: "monotone"
          }
        ]
      },
      options: {
        maintainAspectRatio: false,
        scales: {
          yAxes: [
            {
              ticks: {
                beginAtZero: true
              }
            }
          ]
        }
      }
    })
  }
})
$.ajax({
  type: "POST",
  url: root + "ajax/getVisitorChart.php",
  dataType: "json",
  success: function(response) {
    new Chart($("#visitorChart"), {
      type: "line",
      data: {
        labels: response[0],
        datasets: [
          {
            label: "# of Guests",
            data: response[1],
            backgroundColor: ["transparent"],
            borderColor: ["black"],
            borderWidth: 3,
            cubicInterpolationMode: "monotone"
          }
        ]
      },
      options: {
        maintainAspectRatio: false,
        scales: {
          yAxes: [
            {
              ticks: {
                beginAtZero: true
              }
            }
          ]
        }
      }
    })
  }
})
$.ajax({
  type: "POST",
  url: root + "ajax/getRoomTypeChart.php",
  dataType: "json",
  success: function(response) {
    var dynamicColors = function() {
      var r = Math.floor(Math.random() * 255)
      var g = Math.floor(Math.random() * 255)
      var b = Math.floor(Math.random() * 255)
      return "rgb(" + r + "," + g + "," + b + ")"
    }
    var colors = []
    for (var i = 0; i < response[1].length; i++) {
      colors.push(dynamicColors())
    }
    new Chart($("#roomTypesChart"), {
      type: "pie",
      data: {
        labels: response[0],
        datasets: [
          {
            data: response[1],
            backgroundColor: colors
          }
        ]
      },
      options: {
        tooltips: {
          callbacks: {
            label: function(tooltipItem, data) {
              var dataset = data.datasets[tooltipItem.datasetIndex]
              var total = dataset.data.reduce(function(previousValue, currentValue, currentIndex, array) {
                return previousValue + currentValue
              })
              var currentValue = dataset.data[tooltipItem.index]
              var percentage = Math.floor((currentValue / total) * 100 + 0.5)

              return percentage + "%"
            }
          }
        }
      }
    })
  }
})

$.ajax({
  type: "POST",
  url: root + "ajax/getBookingVsWalkinChart.php",
  dataType: "json",
  success: function(response) {
    var dynamicColors = function() {
      var r = Math.floor(Math.random() * 255)
      var g = Math.floor(Math.random() * 255)
      var b = Math.floor(Math.random() * 255)
      return "rgb(" + r + "," + g + "," + b + ")"
    }
    var colors = []
    for (var i = 0; i < 2; i++) {
      colors.push(dynamicColors())
    }
    new Chart($("#bookingVsWalkinChart"), {
      type: "pie",
      data: {
        labels: ["Booking", "Walk-in"],
        datasets: [
          {
            data: response,
            backgroundColor: colors
          }
        ]
      },
      options: {
        tooltips: {
          callbacks: {
            label: function(tooltipItem, data) {
              var dataset = data.datasets[tooltipItem.datasetIndex]
              var total = dataset.data.reduce(function(previousValue, currentValue, currentIndex, array) {
                return previousValue + currentValue
              })
              var currentValue = dataset.data[tooltipItem.index]
              var percentage = Math.floor((currentValue / total) * 100 + 0.5)

              return percentage + "%"
            }
          }
        }
      }
    })
  }
})
