<div>
	<p>Hello {!! $data->student_data->nick !!},</p>
	<p>Teacher {!! $data->teacher_data->nick !!} has sent the assesment for your class last {!! date("F j, Y, G:i", strtotime($data->book_class->start_at)) !!}.</p>
	<p></p>

	<p>Class ID: {{!! $data->book_class->class_id !!}}</p>
	<h4>Grammar: </h4>
	<p>{{ $data->book_class->grammar }}</p>
	<h4>Pronunciation: </h4>
	<p>{{ $data->book_class->pronunciation }}</p>
	<h4>Areas for improvement: </h4>
	<p>{{ $data->book_class->areas_for_improvement }}</p>
	<h4>Tips and Suggestions: </h4>
	<p>{{ $data->book_class->tips_and_suggestion_for_student }}</p>
	<h4>Remarks: </h4>
	<p>{{ $data->book_class->class_remarks }}</p>

	<p></p>
	<p></p>
	<p>Learning is a never ending process.</p>
	<p>Louie Speaks</p>
</div>
