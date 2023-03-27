@component('mail::message')
# Introduction
Name: {{strip_tags($name)}}
Password: {{$password}}
@component('mail::button', ['url' => route('login')])
Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
