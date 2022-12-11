<x-mail::message>
# {{config('trackable_drivers.tracked_pairs.' . $user->pair . '.crypto')}} Price

    The price of BTC has exceeded the limit of {{ $user->price }} {{config('trackable_drivers.tracked_pairs.' . $user->pair . '.fiat')}}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
