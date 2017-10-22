$('#btnGitUpdate').click(function(){
	$.ajax({
		url  : '/nwh/files/gitUpdate.php',
		success :  function(response)
		{
			alertNotif("success",response,true,3000);
		}
	});
})