<?php
namespace Mtr\MiniCrm\Http\Controllers\Admin\Tickets;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Mtr\MiniCrm\Models\Ticket;
use Mtr\MiniCrm\Models\Ticket\TicketStatus;

class ShowController extends Controller
{
    /**
     * @InheritDoc
     */
    public function __invoke(Request $request, Ticket $ticket)
    {
        $ticket->loadMissing(['customer', 'manager']);

        $indexUrl = route('minicrm.admin.tickets.index');
        $backUrl = $request->session()->get('minicrm.admin.tickets.index_url', $indexUrl);

        if (!is_string($backUrl) || !str_starts_with($backUrl, $indexUrl)) {
            $backUrl = $indexUrl;
        }

        return view('minicrm::admin.tickets.show', [
            'ticket'   => $ticket,
            'statuses' => TicketStatus::cases(),
            'backUrl'  => $backUrl,
        ]);
    }
}