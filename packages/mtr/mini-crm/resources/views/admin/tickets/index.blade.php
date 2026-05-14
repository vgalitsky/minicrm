@extends('minicrm::layouts.admin')
@push('styles')
    <link
        rel="stylesheet"
        href="{{ asset('vendor/minicrm/admin/css/tickets.css') }}"
    >

    <link
        rel="stylesheet"
        href="{{ asset('vendor/minicrm/admin/css/pagination.css') }}"
    >
@endpush

@section('title', 'Tickets')

@section('content')
<section class="filters">
    <form method="GET" action="{{ route('minicrm.admin.tickets.index') }}" class="form">

        <div class="field">
            <label for="f-status">Status</label>
            <select id="f-status" name="status">
                <option value="">All</option>
                @foreach($statuses as $status)
                    <option value="{{ $status->value }}" {{ ($filters['status'] ?? '') === $status->value ? 'selected' : '' }}>
                        {{ $status->label() }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="field">
            <label for="f-date-from">From</label>
            <input id="f-date-from" type="date" name="date_from" value="{{ $filters['date_from'] ?? '' }}">
        </div>

        <div class="field">
            <label for="f-date-to">To</label>
            <input id="f-date-to" type="date" name="date_to" value="{{ $filters['date_to'] ?? '' }}">
        </div>

        <div class="field">
            <label for="f-customer">Customer</label>
            <input id="f-customer" type="text" name="customer_name" placeholder="Name" value="{{ $filters['customer_name'] ?? '' }}">
        </div>

        <div class="field">
            <label for="f-email">Email</label>
            <input id="f-email" type="text" name="customer_email" placeholder="email@…" value="{{ $filters['customer_email'] ?? '' }}">
        </div>

        <div class="field">
            <label for="f-phone">Phone</label>
            <input id="f-phone" type="text" name="customer_phone" placeholder="+…" value="{{ $filters['customer_phone'] ?? '' }}">
        </div>

        <div class="actions">
            <button type="submit">Search</button>
            <button type="reset" onclick="window.location='{{ route('minicrm.admin.tickets.index') }}'">Reset</button>
        </div>

    </form>
</section>

<section class="tickets">

    @if($tickets->isEmpty())

        <div class="empty-state">No tickets match your filters.</div>

    @else

        <div class="list-header">
            <h1>Tickets</h1>
            <span class="count">{{ $tickets->total() }} total</span>
        </div>

        <div class="cards">
            @foreach($tickets as $ticket)

                <article class="card" data-status="{{ $ticket->status }}">
                    <div class="accent"></div>

                    <div class="content">
                        <div class="top">
                            <h3 class="subject">{{ $ticket->subject }}</h3>
                            <span class="badge badge--{{ $ticket->status }}">
                                {{ $ticket->status }}
                            </span>
                        </div>

                        <div class="meta">
                            <div class="meta-row">
                                <strong class="label">Customer</strong>
                                <span>{{ $ticket->customer->name }}</span>
                            </div>
                            <div class="meta-row">
                                <strong class="label">Manager</strong>
                                <span>{{ $ticket->manager->name ?? '— unassigned' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="footer">
                        <span class="date">{{ $ticket->created_at->diffForHumans() }}</span>
                        
                        <a href="{{ route('minicrm.admin.tickets.show', ['ticket' => $ticket, 'back' => request()->fullUrl()]) }}" class="details-link">Details &#8594;</a>
                    </div>
                </article>

            @endforeach
        </div>

        <div class="pagination">
            {{ $tickets->links('minicrm::admin.pagination.default') }}
        </div>

    @endif

</section>
@endsection