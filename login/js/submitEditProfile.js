$("#frmEditProfile").submit(function(e){
	e.preventDefault();
	$("#btnEditProfile").html('<img src="/nwh/images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Updating...');
	$('#btnEditProfile').attr('disabled', true);
	$("#lblDisplayErrorEditProfile").html('');
  $.ajax({
    type : 'POST',
    url  : '/nwh/login/checkEditProfile.php',
    data : $(this).serialize()+"&profilePic="+document.getElementById("imgProfilePic").files.length,
    success :  function(response)
    {
      if(response=="ok")
      {
				if(document.getElementById("imgProfilePic").files.length != 0)
				{
					var file_data = $('#imgProfilePic').prop('files')[0];   
					var form_data = new FormData();                  
					form_data.append('file', file_data);
					if(file_data.size > 2097152)
					{
						$("#btnEditProfile").html('Update');
						$('#btnEditProfile').attr('disabled', false);
						$("#lblDisplayErrorEditProfile").html('<div class="alert alert-danger fade in"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;The file size must under 2MB.</div>');
					}
					else
					{
						$.ajax({
							url: '/nwh/login/uploadPicture.php',
							dataType: 'text',
							cache: false,
							contentType: false,
							processData: false,
							data: form_data,                         
							type: 'POST',
							success: function(responseUpload)
							{
								if(responseUpload=="ok")
								{
									$('#modalEditProfile').modal('hide');
									alertNotif("success","Updated Successfully!",true);
								}
								else
								{
									$("#btnEditProfile").html('Update');
									$('#btnEditProfile').attr('disabled', false);
									$("#lblDisplayErrorEditProfileEditProfile").html('<div class="alert alert-danger fade in"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;'+responseUpload+'</div>');
								}
							}
						});
					}
				}
				else
				{
					$('#modalEditProfile').modal('hide');
					$('#frmEditProfile').trigger('reset');
					$('#btnEditProfile').attr('disabled', false);
					alertNotif("success","Updated Successfully!");
				}
      }
      else
      {
				$("#btnEditProfile").html('Update');
				$('#btnEditProfile').attr('disabled', false);
        $("#lblDisplayErrorEditProfileEditProfile").html('<div class="alert alert-danger fade in"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;'+response+'</div>')
      }
    }
  });
});

var _validFileExtensions = [".jpg", ".jpeg", ".bmp", ".gif", ".png"]; 

function ValidateSingleInput(oInput) {
	var file_data = $('#imgProfilePic').prop('files')[0];
	if(file_data.size > 2097152)
	{
		$('#btnEditProfile').attr('disabled', true);
		$("#lblDisplayErrorEditProfileEditProfile").html('<div class="alert alert-danger fade in"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;The file size must be under 2MB.</div>');
		return false;
	}
	if (oInput.type == "file") {
		var sFileName = oInput.value;
		if (sFileName.length > 0) {
			var blnValid = false;
			for (var j = 0; j < _validFileExtensions.length; j++) {
				var sCurExtension = _validFileExtensions[j];
				if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
					$("#lblDisplayErrorEditProfileEditProfile").html('');
					$('#btnEditProfile').attr('disabled', false);
					blnValid = true;
					break;
				}
			}
			if (!blnValid) {
				$("#lblDisplayErrorEditProfileEditProfile").html('<div class="alert alert-danger fade in"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;Sorry, your file is invalid, allowed extensions are:' + _validFileExtensions.join(", ")+'</div>');
				$('#btnEditProfile').attr('disabled', true);
				oInput.value = "";
				return false;
			}
		}
	}
	return true;
}