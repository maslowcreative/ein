@component('mail::message')
    # Following are the claims auto approved today.
    Name: {{$name}}
    Business Name: {{$business_name}}
    New Email: {{$email}}
    OLD Email: {{$old_email}}

    {{ config('app.name') }}
@endcomponent
