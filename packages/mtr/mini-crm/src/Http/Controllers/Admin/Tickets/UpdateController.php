<?php

namespace Mtr\MiniCrm\Http\Controllers\Admin\Tickets;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;
use Mtr\MiniCrm\Models\Ticket;
use Mtr\MiniCrm\Models\Ticket\TicketStatus;

class UpdateController extends Controller
{
    /**
     * Update ticket status
     * 
     * @param Request $request
     * @param Ticket $ticket
     * 
     * @return RedirectResponse
     * 
     * @throws ValidationException
     */
    public function __invoke(Request $request, Ticket $ticket): RedirectResponse
    {
        // when($ticket->isClosed(), function () {
        //     throw ValidationException::withMessages([
        //         'status' => 'Cannot change status of a closed ticket.',
        //     ]);
        // });

        $validated = $request->validate([
            'status' => [
                'required', 
                new Enum(TicketStatus::class)
                ],
        ]);

        $this->checkTicketHasSameStatus($ticket, TicketStatus::from($validated['status']));

        $ticket->update([
            'status' => TicketStatus::from($validated['status']),
        ]);

        return redirect()
            ->route('minicrm.admin.tickets.show', $ticket)
            ->with('success', 'Status updated successfully to "' . $ticket->status->label() . '"');
    }

    /**
     * @param Ticket $ticket
     * @param TicketStatus $newStatus
     * @throws ValidationException
     */
    private function checkTicketHasSameStatus(Ticket $ticket, TicketStatus $newStatus): void
    {
        if ($ticket->status === $newStatus) {
            throw ValidationException::withMessages([
                'status' => 'Ticket already has this status.',
            ]);
        }
    }
}
