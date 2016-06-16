<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	 <meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
    	<meta name="_token" content="{{ csrf_token() }}"/>
	<title>Register</title>
	<link href="http://zhcn.web.cdn.cootekservice.com/s/godness/css/reset.css" rel="stylesheet">
   	
</head>
<body>
	<div class="titleContainer">
		<p>welcome to register</p>
	</div>
	@if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>新增失败</strong> 输入不符合要求<br><br>
                            {!! implode('<br>', $errors->all()) !!}
                        </div>
                    @endif

	<div class="operateContainer">
		<form action="{{ url('login') }}" method="POST">
	                    {!! csrf_field() !!}
	                    <input type="hidden" name="open_id" value="{{ $open_id }}">
	                    <div class="form-group">
	                        <label>PhoneNumber</label>
	                        <input  id="phone_number" type="text" name="phone_number" required="required">
	                    </div>
	                     <div class="form-group">
	                       	 <label>Verify Code</label>
	                       	 <input type="text" name="verify_code" required="required">
	                       	 <div id="send" class="sendContainer">
	                       	 	<p>send</p>
	                       	 </div>
	                    </div>
	                    <button type="submit">Submit</button>
                	</form>

	</div>
</body>
<script src="//cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
<script>
	$('#send').click(function(){
		console.log($('#phone_number').val());
		
		$.ajax({
			type: 'POST',
			url: '/ajax/create',
			data: { phone_number :  $('#phone_number').val() },
			dataType: 'json',
			headers: {
			'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			},
			success: function(data){
			console.log(data.status);
			},
			error: function(xhr, type){
				var errors = JSON.parse(xhr.responseText);
				console.log(xhr.status);
				console.log(errors.phone_number[0]);
			}
		});
		/*
		$.post("/ajax/create",{phone_number :  $('#phone_number').val() },function(result){
		   	 alert(result);
		  });
		  */
	})
</script>
</html>