@component('mail::message')
    # New Leave Request

    A new leave request has been submitted.

    @component('mail::button', ['url' => route('leave-requests.index')])
        View Leave Requests
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
