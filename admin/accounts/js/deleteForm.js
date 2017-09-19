function submitDeleteForm()
{		
  //var email = $('#cmbEmail option:selected').val();
  var data = $('#frmAccount').serialize();
  $.ajax({
    type : 'POST',
    url  : 'deleteAccount.php',
    data : data,
    success :  function(response)
    {
      if(response=="ok")
      {
        $("#btnDelete").html('<img src="/nwh/images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Deleting ...');
        $("#btnDelete").prop('disabled',true);
        setTimeout('alert("Records Deleted Successfully!");location.reload();',500);
      }
      else
      {
        $("#lblErrorDisplayAccount").fadeIn(1000, function(){
            $("#lblErrorDisplayAccount").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+response+'</div>')
        });
      }
    }
  });
  return false;
}