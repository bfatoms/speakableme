<div>
	<p>Hello {!! $data->student_data->nick !!},</p>
	<p>We are reminding you of your class at <b>{!! date("G:i", strtotime($data->schedule)) !!} today</b>.</p>
	<p><a href="{{ URL::to('/') }}">Speakable Website.</a></p>
	<p>Your teacher's name: Teacher {!! $data->teacher_data->nick !!}</p>
	<p>Class ID: {!! $data->class_id !!}</p>
	<p></p>
	<p>Schedule:</p>
	<p>{!! date("F j, Y, G:i", strtotime($data->schedule)) !!}</p>
	<p>Note: Please make sure that you have already uploaded your book.</p>
	<p>Learning is a never ending process.</p>
	<p>Best regards,<br/>Louie Speaks</p>
</div>