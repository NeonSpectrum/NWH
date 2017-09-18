function submitDeleteForm()
{		
  var email = $('#emailcombobox option:selected').val();
  $.ajax({
    type : 'POST',
    url  : 'deleteAccount.php',
    data : "email=" + email,
    success :  function(response)
    {
      if(response=="ok")
      {
        $("#delete").html('<img src="../../images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Deleting ...');
        $("#delete").prop('disabled',true);
        setTimeout('alert("Records Deleted Successfully!");location.reload();',2000);
      }
      else
      {
        $("#errorLogin").fadeIn(1000, function(){
            $("#errorLogin").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+response+'</div>')
        });
      }
    }
  });
  return false;
}