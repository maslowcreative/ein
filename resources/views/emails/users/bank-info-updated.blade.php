@component('mail::message')
    # {{$role}} has updated its banking information.
    Name: {{strip_tags( $name )}}
    Account Name: {{strip_tags( $account_name)}}
    Account Number: {{strip_tags($account_number)}}
    BSB: {{$bsb}}
@if($is_provider)
ABN: {{$abn}}
@endif

    {{ config('app.name') }}
@endcomponent
