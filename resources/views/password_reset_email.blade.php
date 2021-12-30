@component('mail::message')
# Your password has been reset

## New password : {{$url}}

Use this new password to login to your account.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
