$(document).ready(function() {
  $("#emailcombobox").change(function(){
    var data = $('#emailcombobox option:selected').val();
    $.ajax({
      url: "displayAccount.php",
      type: "POST",
      dataType: "json",
      data: "email=" + data,
      success: function(data) {
        document.getElementById("accounttypecombobox").value = data[0];
        document.getElementById("profilepicture").value = data[1];
        document.getElementById("firstname").value = data[2];
        document.getElementById("lastname").value = data[3];
        document.getElementById("islogged").value = data[4];
        if(data[0] == 'error'){
          document.getElementById("accounttypecombobox").value = '';
          document.getElementById("profilepicture").value = '';
          document.getElementById("firstname").value = '';
          document.getElementById("lastname").value = '';
          document.getElementById("islogged").value = '';
        }
      }
    }); 
  });
});