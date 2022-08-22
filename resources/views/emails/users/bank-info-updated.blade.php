@component('mail::message')
    # {{$role}} has upated its banking information.
    Name: {{$name}}
    Account Name: {{$account_name}}
    Account Number: {{$account_number}}
    BSB: {{$bsb}}
@if($is_provider)
ABN: {{$abn}}
@endif

    {{ config('app.name') }}
@endcomponent
