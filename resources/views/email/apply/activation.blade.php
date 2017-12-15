您已经报名 {{ $activity->title }} ，<br>
请点击链接完成报名: <a href="http://softorg.com/apply/activation?email={{ $email }}&activity={{ $activity_id }}&apply={{ $apply_id }}">点击链接确认报名</a> <br>
@if($activity->is_sign == 1) 签到密码为：{{ $password }}。 @endif