@component('mail::message')
# {{ __('app.your_weekly_writer_summary_for') }} {{ $data['end_date'] }}

{{ __('app.from') }} {{ $data['start_date'] }} {{ __('app.to') }} {{ $data['end_date'] }} {{ __('app.your_posts_received') }}

@component('mail::table')
|                                 |                                  |
|---------------------------------|----------------------------------|
| **+{{ $data['total_views'] }}** | **+{{ $data['total_visits'] }}** |
| {{ __('app.views') }}   | {{ __('app.visits') }}   |
@endcomponent

@component('mail::table')
|                        | {{ __('app.visits') }}            | {{ __('app.views') }}            |
| ---------------------- | ----------------------------------------- | ----------------------------------------:|
@foreach($data['posts'] as $post)
| *{{ $post['title'] }}* | **+{{ number_format($post['visits']) }}** | **+{{ number_format($post['views']) }}** |
@endforeach
@endcomponent

@component('mail::button', ['url' => url(config('custom.path'))])
{{ __('app.see_all_stats') }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
