<div>
	<p>您好！尊敬的 {!! $data->student_data->nick !!},</p>
	<p>温馨提示，您预约了今天 <b>{!! date("G:i", strtotime($data->schedule)) !!} 的课程。</b></p>
	<p>网址: <a href="{{ URL::to('/') }}">www.speakableme.com</a></p>
	<p>外教：老师 {!! $data->teacher_data->nick !!}</p>
	<p>课程ID: {!! $data->class_id !!}</p>
	<p></p>
	<p>请确认您已将教材上传至网站。</p>
	<p>祝您学习进步、生活愉快！</p>
	<p>感谢您关注欢言英语。喜欢英语，就发言！</p>
</div>
