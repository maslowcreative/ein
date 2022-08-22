@component('mail::message')
    # {{$role}} has upated its email.
    Name: {{$name}}
    New Email: {{$email}}
    OLD Email: {{$old_email}}

    {{ config('app.name') }}
@endcomponent
