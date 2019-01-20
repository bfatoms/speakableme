<div>
	<p>Hello {!! $data->teacher_data->nick !!},</p>
	<p>A student has booked your opened class.</p>
	<p>Student Name: <a href="{{ URL::to('/') }}">{!! $data->student_data->nick !!}</a></p>
	<p></p>
	<p>Schedules:</p>
	@foreach($data->schedule as $sched)
		<p>{!! date("F j, Y, g:i a", strtotime($sched)) !!}</p>
	@endforeach
	<p>Teaching is the noblest profession.</p>
</div>
