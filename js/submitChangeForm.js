function submitChangeForm()
{
  $('.dropdown').hide();
  var pass = $('#txtNewPass').val();
  var vpass = $('#txtVerifyNewPass').val();
  if(pass!=vpass)
  {
    $("#lblErrorDisplayChange").html('<div class="alert alert-danger fade in"><span class="glyphicon glyphicon-info-sign"></span>&nbsp; Password is incorrect!</div>');
    return false;
  }
  $("#lblErrorDisplayChange").html('');
  var data = $("#frmChange").serialize();
  console.log(data);
  $.ajax({
    type : 'POST',
    url  : '/nwh/login/checkChange.php',
    data : data,
    success :  function(response)
    {
      if(response=="ok")
      {
        $("#btnUpdate").html('<img src="/nwh/images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Updating...');
        $('#btnUpdate').attr('disabled', true);
        $("#lblErrorDisplayChange").html('');
        setTimeout("alert('Updated Successfully!');location.reload();",2000);
      }
      else
      {
        $("#lblErrorDisplayChange").html('<div class="alert alert-danger fade in"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;'+response+'</div>')
      }
    }
  });
  return false;
}