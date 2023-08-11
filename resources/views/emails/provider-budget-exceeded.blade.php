@component('mail::message')
# Participant Budget Exceeded from 80%

Name: {{strip_tags($name)}}

Category Name: {{strip_tags($cateogry_name)}}

Percentage Spent: {{$percentage_exceeded}}

@component('mail::button', ['url' => $url])
View Plan
@endcomponent

{{ config('app.name') }}
@endcomponent
