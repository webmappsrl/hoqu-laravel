{{ $mail_data['member'] }}
<br>
Title: Hoqu[ {{ $mail_data['error']['id'] }} ] ({{$mail_data['error']['instance']}})
<br>
Description:

ID: {{ $mail_data['error']['id'] }}
<br>
ID SERVER: {{ $mail_data['error']['id_server'] }}<br/>
<br>
INSTANCE: {{ $mail_data['error']['instance'] }}
<br>
JOB: {{ $mail_data['error']['job'] }}
<br>
PARAMETERS: {{ $mail_data['error']['parameters'] }}
<br>
PROCESS_STATUS: {{ $mail_data['error']['process_status'] }}<br>
<br>
PROCESS LOG: {{ $mail_data['error']['process_log'] }}
<br>
LINK: {{request()->getHost()."/".$mail_data['error']['id']."/show"}}

