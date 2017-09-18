function submitChangeForm()
{
  var pass = $('#newpass').val();
  var vpass = $('#verifynewpass').val();
  if(pass!=vpass)
  {
    $("#errorChange").html('<div class="alert alert-danger fade in"><span class="glyphicon glyphicon-info-sign"></span>&nbsp; Password is incorrect!</div>');
    return false;
  }
  $("#errorChange").html('');
  var data = $("#changeform").serialize();
  console.log(data);
  $.ajax({
    type : 'POST',
    url  : '/nwh/login/check_change.php',
    data : data,
    success :  function(response)
    {
      if(response=="ok")
      {
        $("#changepass").html('<img src="/nwh/images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Updating...');
        $('#changepass').attr('disabled', true);
        $("#errorChange").html('');
        setTimeout("alert('Updated Successfully!');location.reload();",2000);
      }
      else
      {
        $("#errorChange").html('<div class="alert alert-danger fade in"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;'+response+'</div>')
      }
    }
  });
  return false;
}