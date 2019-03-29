
<b>Hi {{ $data->toName }},</b>
<br/>
<p>Your Account has been created with {{config('app.name')}} with following credentials: </p>
<br>
<p>Email : {{ $data->toEmail }} </p>
<p>Password : {{ $data->toPassword }} </p>
<br>
Regards,<br>
Team {{config('app.name')}}