<div>
	@if($data->role == "student")
		<h4>Hello {{ $data->nick }},</h4>
	@elseif($data->role == "teacher")
		<h4>Hello Teacher {{ $data->nick }},</h4>
	@elseif($data->role == "client")
		<h4>Hello {{ $data->first_name }},</h4>
	@else
		<h4>Hello {{ $data->first_name }},</h4>
	@endif
	<p>You can now Logon to: <a href="{{ URL::to('/') }}">Speakable Website.</a> using the credentials below.</p>
	<p>Your Username: {{ $data->username }}</p>
	<p>Your Password: {{ $data->password }}</p>

	@if($data->role == "student")
		<p>As soon as you login, you will be asked to change your password. Then you can either book a free-trial class or buy a package directly.</p>
	@elseif($data->role == "teacher")
		<p>As soon as you login, you will be asked to change your password. You can now plot your schedule.</p>
	@elseif($data->role == "client")
		<p>Change your password as soon as you login.</p>
		<p>Please note that the first thing you need to do is to create a package for your school. Then, you can now create student profiles.</p>
	@endif

	<p></p>
	<p></p>

	@if($data->role == "student")
		<p><b>Happy Learning!</b></p>
	@elseif($data->role == "teacher")
		<p><b>Happy Teaching!</b></p>
	@elseif($data->role == "client")
		<p><b>Have a great day!</b></p>
	@else
		<p><b>Cheers!</b></p>
	@endif
	<p>Louie Speaks</p>
</div>