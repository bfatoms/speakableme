<div>
	<p>Hello {!! $data->teacher_data->first_name." ".$data->teacher_data->last_name !!},</p>
	<p>A student has cancelled a class, The slot has been opened for others to get.</p>
	<p><a href="{{ URL::to('/') }}">Speakable Website.</a></p>
	<p>Student Name: {!! $data->student_data->first_name." ".$data->student_data->last_name !!}</p>
	<p>QQ: {!! $data->student_data->qq !!}</p>
	<p>Email: {!! $data->student_data->email !!}</p>
	<p></p>
	<p>Schedule:</p>
	<p>{!! date("F j, Y, g:i a", strtotime($data->sched)) !!}</p>
	<p>Teaching is the noblest profession.</p>
	<p>Louie Speaks</p>
</div>
