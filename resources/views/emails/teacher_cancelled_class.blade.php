<div>
	<p>Hello {!! $data->student_data->nick !!},</p>
	<p>Teacher {!! $data->teacher_data->nick !!} has cancelled your class on {!! date("F j, Y, G:i a", strtotime($data->schedule)) !!} with Class ID {!! $data->class_id !!}.</p>

	<p>Don't worry as a compensation to you, this class is now immortal, meaning you can book a class using your immortal reservation.</p>
	
	<p>Don't stop learning.</p>
	<p>Louie Speaks</p>
	<p><a href="{{ URL::to('/') }}">Speakable Website.</a></p>
</div>
