@component('mail::message')
# Confirm your email account

Click the button below to confirm your account

@component('mail::button', ['url' => $url])
Confirm
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
