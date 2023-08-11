@component('mail::message')
    # {{$providerName}} has uploaded an invoice for you to accept or reject.

    Please remember each invoice can have several claims associated with it due to different services, different service delivery methods, and different areas of funding. This means you can accept some claims but reject others.
    For example, if you disagree with a cancellation charge due to sufficient notice. If you have any questions or concerns, please email the EIN team at admin@ein.net.au or call us on 02 8484 0301 :)

    Thanks,
    {{ config('app.name') }}
@endcomponent
