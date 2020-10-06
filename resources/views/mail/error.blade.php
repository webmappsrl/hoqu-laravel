@component('mail::message')
Error ID: $mail_data['id']

e stato generato un errore

@component('mail::button', ['url' => 'http://hoqu-laravel.test/error'])
View Error
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent



