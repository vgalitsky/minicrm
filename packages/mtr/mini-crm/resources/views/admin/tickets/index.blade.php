@extends('minicrm::layouts.admin')
@push('styles')
<style>
</style>
@endpush

@section('content')
<section class="filters">
    <form method="GET" action="{{ route('minicrm.admin.tickets.index') }}" >
        <div>
            <select name="status">
                <option value="">All Statuses</option>
                @foreach($statuses as $status)
                    <option value="{{ $status }}" {{ ($filters['status'] ?? '') === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <input type="date" name="date_from" placeholder="From Date" value="{{ $filters['date_from'] ?? '' }}">
        </div>
        <div>
            <input type="date" name="date_to" placeholder="To Date" value="{{ $filters['date_to'] ?? '' }}">
        </div>
        <div>
            <input type="text" name="customer_name" placeholder="Customer Name" value="{{ $filters['customer_name'] ?? '' }}">
        </div>
        <div>
            <input type="text" name="customer_email" placeholder="Customer Email" value="{{ $filters['customer_email'] ?? '' }}">
        </div>
        <div>
            <input type="text" name="customer_phone" placeholder="Customer Phone" value="{{ $filters['customer_phone'] ?? '' }}">
        </div>
        <div>
            <button type="submit" >Filter</button>
            <button type="reset" onclick="window.location='{{ route('minicrm.admin.tickets.index') }}'">Reset</button>
        </div>
    </form>
</section>

<section class="tickets">
    @if($tickets->isEmpty())
        <p>No tickets found.</p>
    @else
        <h1>Tickets</h1>
        <div>
            @foreach($tickets as $ticket)
                <card class="ticket">
                    <h3>{{ $ticket->subject }}</h3>
                    <field>{{ $ticket->description }}</field>
                    <field>Status: {{ $ticket->status }}</field>
                    <field>Customer: {{ $ticket->customer->name }}</field>
                    <field>Email: {{ $ticket->customer->email }}</field>
                    <field>Phone: {{ $ticket->customer->phone }}</field>
                    <field>Manager: {{ $ticket->manager->name ?? 'Unassigned' }}</field>
                    <field>Created At: {{ $ticket->created_at }}</field>
                </card>
            @endforeach
        </div>
        <div class="pagination">
            {{ $tickets->links() }}
        </div>
    @endif
</section>
@endsection
