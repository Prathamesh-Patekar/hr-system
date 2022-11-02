<!DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="utf-8" />
</head>
<body>

@if($test_message['post'] == "")
<h2>Invite Email</h2>
<p>You are invited for Training Program.</p>
<p>Program name: {{$test_message['program_name']}}</p>
<p>Schedule on given dates {{$test_message['date_from']}} to {{$test_message['date_to']}} On time {{$test_message['program_time']}}</p>

@else
<h2>Changes in Training Schedule</h2>
<p>we have little bit change in your Training Program.</p>
<p>Program name: {{$test_message['program_name']}}</p>
<p>Schedule on given dates {{$test_message['date_from']}} to {{$test_message['date_to']}} On time {{$test_message['program_time']}}</p>

@endif


</body>
</html>
