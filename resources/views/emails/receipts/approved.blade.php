@component('mail::message')
# {{$heading}}

**Claim Reference:** {{$claimReference}}

This claim has been approved against the above claim reference.

Please double-check this receipt matches your payment. If you have any questions or concerns, please email the EIN team at admin@ein.net.au or call us on 02 8484 0301 :)

Thanks,
{{ config('app.name') }}
@endcomponent
