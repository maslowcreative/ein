@component('mail::message')
    # Following are the claims auto approved today.
    Name: {{strip_tags($name)}}
    Business Name: {{strip_tags($business_name)}}
    New Email: {{$email}}
    OLD Email: {{$old_email}}

    {{ config('app.name') }}
@endcomponent
