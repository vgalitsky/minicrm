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
    <form method="GET" action="{{ route('minicrm.admin.tickets.index') }}">

        <div class="filter-field">
            <label for="f-status">Status</label>
            <select id="f-status" name="status">
                <option value="">All</option>
                @foreach($statuses as $status)
                    <option value="{{ $status }}" {{ ($filters['status'] ?? '') === $status ? 'selected' : '' }}>
                        {{ $status }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="filter-field">
            <label for="f-date-from">From</label>
            <input id="f-date-from" type="date" name="date_from" value="{{ $filters['date_from'] ?? '' }}">
        </div>

        <div class="filter-field">
            <label for="f-date-to">To</label>
            <input id="f-date-to" type="date" name="date_to" value="{{ $filters['date_to'] ?? '' }}">
        </div>

        <div class="filter-field">
            <label for="f-customer">Customer</label>
            <input id="f-customer" type="text" name="customer_name" placeholder="Name" value="{{ $filters['customer_name'] ?? '' }}">
        </div>

        <div class="filter-field">
            <label for="f-email">Email</label>
            <input id="f-email" type="text" name="customer_email" placeholder="email@…" value="{{ $filters['customer_email'] ?? '' }}">
        </div>

        <div class="filter-field">
            <label for="f-phone">Phone</label>
            <input id="f-phone" type="text" name="customer_phone" placeholder="+…" value="{{ $filters['customer_phone'] ?? '' }}">
        </div>

        <div class="filter-actions">
            <button type="submit">Filter</button>
            <button type="reset" onclick="window.location='{{ route('minicrm.admin.tickets.index') }}'">Reset</button>
        </div>

    </form>
</section>

<section class="tickets">

    @if($tickets->isEmpty())

        <div class="tickets__empty">No tickets match your filters.</div>

    @else

        <div class="tickets__header">
            <h1>Tickets</h1>
            <span class="tickets__count">{{ $tickets->total() }} total</span>
        </div>

        <div class="tickets__grid">
            @foreach($tickets as $ticket)

                <article class="ticket" data-status="{{ $ticket->status }}">
                    <div class="ticket__accent"></div>

                    <div class="ticket__body">
                        <div class="ticket__top">
                            <h3 class="ticket__subject">{{ $ticket->subject }}</h3>
                            <span class="ticket__badge badge--{{ $ticket->status }}">
                                {{ $ticket->status }}
                            </span>
                        </div>

                        <div class="ticket__meta">
                            <div class="ticket__row">
                                <strong>Customer</strong>
                                {{ $ticket->customer->name }}
                            </div>
                            <div class="ticket__row">
                                <strong>Manager</strong>
                                {{ $ticket->manager->name ?? '— unassigned' }}
                            </div>
                        </div>
                    </div>

                    <div class="ticket__footer">
                        <span class="ticket__date">{{ $ticket->created_at->diffForHumans() }}</span>
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