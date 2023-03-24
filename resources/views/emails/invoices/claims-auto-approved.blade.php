@component('mail::message')
    # Following are auto approve claims  stats.

    @foreach ($data as $item)
      {{$item['claim_reference']}} | {{$item['reason']}}
    @endforeach

    Thanks,
    {{ config('app.name') }}
@endcomponent
