<div>
	<p>Hello Admins,</p>
	<p>A new student has been referred to our system, please take time to click the link below, to approve his 5 immortal class. <a href="{{ URL::to('/referred') }}/{{ $data->student_data->id }}/redeem/">Speakable Website.</a></p>
	<p>Student Name: {!! $data->student_data->nick !!}</p>
	@if( ($data->student_data->qq == "") || ($data->student_data->qq == null))
		<p>WeChat: {!! $data->student_data->wechat !!}</p>
	@else
		<p>QQ: {!! $data->student_data->qq !!}</p>
	@endif
	<p>Email: {!! $data->student_data->email !!}</p>
	
	<p>Learning is a never ending process.</p>
</div>
