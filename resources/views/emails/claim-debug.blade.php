@component('mail::message')
    # Following Claim is the issue.
    Name: {{strip_tags($name)}}
    Email: {{strip_tags($email)}}
    URL: {{strip_tags($url)}}

    Plan_budget_id: {{strip_tags($plan_budget_id)}}

     Amount:  {{$amount}},
     Balance:   {{$balance}},
     Pending:  {{$pending}},
     Spent:  {{$spent}},
     Amount_old:  {{$amount_old}},
     Balance_old:  {{$balance_old}},
     Pending_old:  {{$pending_old}},
     Spent_old:  {{$spent_old}},

    {{ config('app.name') }}
@endcomponent
