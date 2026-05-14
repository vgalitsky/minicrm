@extends('minicrm::layouts.admin')
@section('title', 'Ticket #' . $ticket->id)
@push('styles')
    <link rel="stylesheet" href="{{ asset('vendor/minicrm/admin/css/ticket.css') }}">
@endpush
@section('content')
@php
    $indexUrl = route('minicrm.admin.tickets.index');
    $backUrl = request()->query('back');
    $backUrl = is_string($backUrl) && str_starts_with($backUrl, $indexUrl) ? $backUrl : $indexUrl;
@endphp

<article class="ticket-article">

    <header class="header">
        <a href="{{ $backUrl }}" class="back">&#8592; Back</a>
        <div class="title-row">
            <h1 class="title">{{ $ticket->subject }}</h1>
            <span class="badge badge--{{ $ticket->status->value }}">{{ $ticket->status->label() }}</span>
            <span class="id">#{{ $ticket->id }}</span>
        </div>
    </header>

    @if(session('success'))
        <div class="alert alert--success">{{ session('success') }}</div>
    @endif

    <div class="ticket-body">
        <div class="main">
            <div class="card card--details">
                    <div class="details-heading">
                        <p class="details-created">Created {{ $ticket->created_at->format('d M Y, H:i') }}</p>
                    </div>

                    <div class="detail-grid">
                        <div class="detail-item">
                            
                            <span class="detail-value">{{ $ticket->customer?->name ?? '—' }}</span>
                        </div>
                        <div class="detail-item">
                            
                            <span class="detail-value">{{ $ticket->customer?->phone ?? '—' }}</span>
                        </div>
                        <div class="detail-item">
                            
                            <span class="detail-value">{{ $ticket->customer?->email ?? '—' }}</span>
                        </div>
                    </div>

                    <div class="description">
                        <p>{{ $ticket->description ?? '—' }}</p>
                    </div>
            </div>
        </div>

        <aside class="sidebar">

                <div class="card card--meta">
                    <div class="row">
                        <span>Manager</span>
                        <span>{{ $ticket->manager?->name ?? 'Unassigned' }}</span>
                    </div>
                    @if($ticket->answered_at)
                    <div class="row">
                        <span>Answered</span>
                        <span>{{ $ticket->answered_at->format('d M Y, H:i') }}</span>
                    </div>
                    @endif
            </div>

            <div class="card card--status">
                <form
                    method="POST"
                    action="{{ route('minicrm.admin.tickets.update', $ticket) }}"
                    class="status-form"
                    id="status-form"
                >
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="back" value="{{ $backUrl }}">

                    <div class="status-options">
                        @foreach($statuses as $status)
                            <label class="status-option status-option--{{ $status->value }} {{ $ticket->status === $status ? 'is-active' : '' }}">
                                <input
                                    type="radio"
                                    name="status"
                                    value="{{ $status->value }}"
                                    {{ $ticket->status === $status ? 'checked' : '' }}
                                >
                                {{ $status->label() }}
                            </label>
                        @endforeach
                    </div>

                    @error('status')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </form>
            </div>

        </aside>
    </div>
</article>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('status-form');

            if (!form) {
                return;
            }

            const radios = form.querySelectorAll('input[name="status"]');
            let currentStatus = form.querySelector('input[name="status"]:checked');

            radios.forEach(function (radio) {
                radio.addEventListener('change', function (event) {
                    if (!currentStatus || event.target.value === currentStatus.value) {
                        return;
                    }

                    const nextLabel = event.target.closest('label')?.textContent?.trim() || event.target.value;
                    const confirmed = window.confirm('Change ticket status to "' + nextLabel + '"?');

                    if (!confirmed) {
                        currentStatus.checked = true;
                        event.target.checked = false;
                        return;
                    }

                    currentStatus = event.target;
                    form.submit();
                });
            });
        });
    </script>
@endpush

@endsection
