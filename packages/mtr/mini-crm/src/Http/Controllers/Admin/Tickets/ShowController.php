<?php
namespace Mtr\MiniCrm\Http\Controllers\Admin\Tickets;

use Illuminate\Routing\Controller;
use Mtr\MiniCrm\Models\Ticket;
use Mtr\MiniCrm\Models\Ticket\TicketStatus;

class ShowController extends Controller
{
    /**
     * @InheritDoc
     */
    public function __invoke(Ticket $ticket)
    {
        $ticket->loadMissing(['customer', 'manager']);

        return view('minicrm::admin.tickets.show', [
            'ticket'   => $ticket,
            'statuses' => TicketStatus::cases(),
        ]);
    }
}