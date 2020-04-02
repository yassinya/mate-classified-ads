@component('mail::message')
# Confirm your ad

Click the below button to confirm your ad
@component('mail::button', ['url' => route('confirm.ad', ['token' => $token])])
Confirm
@endcomponent

@endcomponent
