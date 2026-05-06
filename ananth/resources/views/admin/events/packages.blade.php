<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css?v=') . time() }}">
    <title>LogiSphere Sponsor Packages</title>
    @include('admin.events.partials.styles')
</head>
<body>
@include('admin.adminHeader')
<section class="main_section">
    <div class="container-fluid">
        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        @if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif

        <div class="event-admin-hero">
            <div>
                <h2>Sponsor Packages</h2>
                <p>Manage paid sponsor tiers. Public pricing uses the event active currency: <strong>{{ $event->activeCurrency() }}</strong>.</p>
            </div>
            <div class="event-admin-actions">
                <a class="event-admin-btn" href="{{ route('admin.events.edit') }}">Event Content</a>
                <a class="event-admin-btn" href="{{ route('events.sponsorship') }}" target="_blank">View Sponsor Page</a>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.events.packages.update') }}">
            @csrf
            <div data-package-list>
                @foreach($packages as $index => $package)
                    @include('admin.events.partials.package-row', ['index' => $index, 'package' => $package])
                @endforeach
            </div>
            <button type="button" class="event-admin-btn primary" data-add-package>Add Package</button>
            <div class="save-bar"><button type="submit">Update Packages</button></div>
        </form>
    </div>
</section>
<template id="package-template">@include('admin.events.partials.package-row', ['index' => '__INDEX__', 'package' => null])</template>
<script>
document.addEventListener('click', function (event) {
    if (event.target.matches('[data-add-package]')) {
        document.querySelector('[data-package-list]').insertAdjacentHTML('beforeend', document.getElementById('package-template').innerHTML.replaceAll('__INDEX__', Date.now()));
    }
    if (event.target.matches('[data-remove-row]')) {
        const row = event.target.closest('.event-admin-card');
        const del = row.querySelector('[data-delete-input]');
        if (del) { del.value = '1'; row.style.display = 'none'; } else { row.remove(); }
    }
});
</script>
@include('admin.adminFooter')
</body>
</html>
