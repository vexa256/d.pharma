@component('mail::message')
    {{ $details['Title'] }}
    Your message body.

    {{ $details['body'] }}
    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
