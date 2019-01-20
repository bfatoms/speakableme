<div>
	<p>您好！尊敬的 {!! $data->student_data->nick !!},</p>
	<p>外教 {!! $data->teacher_data->nick !!} 由于突发状态， 取消了于 {!! date("F j, Y, G:i", strtotime($data->schedule)) !!} w课程 ID为 {!! $data->class_id !!} 的课程..</p>

	<p>请不必担心，本节课程将会存入您的“补课课程”中，并不受有效期限限制。</p>
	<p>为此给您带来的不便深表歉意！</p>
	
	<p>祝您学习进步、生活愉快！</p>
	<p>感谢您关注欢言英语。喜欢英语，就发言！</p>
	<p><a href="{{ URL::to('/') }}">Speakable Website.</a></p>
</div>