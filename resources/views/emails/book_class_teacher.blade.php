<div>
	<p>Hello {!! $data->teacher_data->nick !!},</p>
	<p>We are reminding you of your class in <b>{!! date("g:i a", strtotime($data->schedule)) !!} today</b>.</p>
	<p><a href="{{ URL::to('/') }}">Speakable Website.</a></p>
	<p>Student Name: {!! $data->student_data->nick !!}</p>
	<p>Class ID: {!! $data->class_id !!}</p>
	<p>Schedule:</p>
	<p>{!! date("F j, Y, g:i a", strtotime($data->schedule)) !!}</p>
	<p>Teaching is the noblest profession.</p>
	<p>Louie Speaks</p>
</div>
