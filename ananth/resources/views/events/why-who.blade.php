@extends('layouts.front')

@section('styles')
@include('events.partials.styles')
@endsection

@section('content')
<main class="event-page">
    @include('events.partials.hero', [
        'eyebrow'  => $event->why_who_eyebrow ?: 'Why LogiSphere',
        'title'    => $event->why_who_heading ?: 'Why now? Why Bengaluru?',
        'subtitle' => $event->why_who_subheading ?: ($event->why_now ?: 'Bengaluru is the natural birthplace for Chapter 1.'),
    ])
    @include('events.partials.nav')

    <section class="event-section">
        <div class="event-container">
            <div class="event-eyebrow">Different by Design</div>
            <h2 class="event-title">Not another noisy summit.</h2>
            <table class="event-table" style="margin-top:28px">
                <thead>
                    <tr>
                        <th scope="col">Traditional Summits</th>
                        <th scope="col">LogiSphere</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(($event->comparison_rows ?: []) as $row)
                        <tr>
                            <td><span class="event-table__dash">—</span> {{ $row['traditional'] ?? '' }}</td>
                            <td><span class="event-table__check">&#10003;</span> {{ $row['logisphere'] ?? '' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <section class="event-section event-section--soft">
        <div class="event-container event-grid">
            <div>
                <div class="event-eyebrow">Who Should Attend?</div>
                <h2 class="event-title">Built for people who shape execution.</h2>
                <p class="event-lead">Attendance is limited to protect the quality of interaction and keep the room relevant.</p>
                <div class="event-actions">
                    <a class="event-btn event-btn--primary" href="{{ route('events.register') }}">Register Interest</a>
                </div>
            </div>
            <div class="event-card">
                <ul class="event-list">
                    @foreach(($event->attendee_profiles ?: []) as $profile)
                        <li>{{ $profile }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>
</main>
@endsection
