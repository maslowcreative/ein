@component('mail::message')
    # {{$role}} has updated its email.
    Name: {{$name}}
    Business Name: {{$business_name}}
    New Email: {{$email}}
    OLD Email: {{$old_email}}

    {{ config('app.name') }}
@endcomponent
