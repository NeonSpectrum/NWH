function submitEditForm()
{		
  var data = $("#editAccountForm").serialize();
  var email = $('#emailcombobox option:selected').val();
  var accounttype = $('#accounttypecombobox option:selected').val();
  $.ajax({
    type : 'POST',
    url  : 'editAccount.php',
    data : "email=" + email +"&" + "accounttype=" + accounttype +"&"+ data,
    success :  function(response)
    {
      if(response=="ok")
      {
        $("#edit").html('<img src="../../images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Editing ...');
        $("#edit").prop('disabled',true);
        setTimeout('alert("Records Updated Succesfully!");location.reload();',2000);
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