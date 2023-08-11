@component('mail::message')
    # Automatically Accepted Claims:

    @foreach ($data as $item)
      {{$item['claim_reference']}} | {{$item['reason']}}
    @endforeach

    {{ config('app.name') }}
@endcomponent
