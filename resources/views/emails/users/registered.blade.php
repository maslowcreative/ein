@component('mail::message')
# Introduction
Name: {{$name}}
Password: {{$password}}
@component('mail::button', ['url' => route('login')])
Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
