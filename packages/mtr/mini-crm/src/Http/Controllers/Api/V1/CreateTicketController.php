<?php

namespace Mtr\MiniCrm\Http\Controllers\Api\V1;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Mtr\MiniCrm\Exceptions\CustomerConflictException;
use Mtr\MiniCrm\Http\Requests\Api\V1\StoreTicketRequest;
use Mtr\MiniCrm\Models\Ticket;
use Mtr\MiniCrm\Models\Ticket\TicketStatus;
use Mtr\MiniCrm\Models\Customer;
use Mtr\MiniCrm\Repositories\Customer\CustomerRepository;

class CreateTicketController extends Controller
{
    public function __construct(private CustomerRepository $customers) {}

    /**
     * @param StoreTicketRequest $request
     * 
     * @return JsonResponse
     * 
     * @throws CustomerConflictException
     */
    public function store(StoreTicketRequest $request): JsonResponse
    {
        $data = $request->validated();
        
        /** @var Customer $resolved */
        $resolved = DB::transaction(
            fn () => $this->customers->resolveCustomer($data),
            attempts: 3,
        );

        $ticket = Ticket::create([
            'customer_id' => $resolved->id,
            'subject'     => $data['subject'],
            'description' => $data['description'],
            'status'      => TicketStatus::New,
        ]);

        $this->processAttachments($request, $ticket);

        return response()->json([
            'message' => 'Ticket created successfully.',
            'data'    => [
                'id'     => $ticket->id,
                'status' => $ticket->status,
            ],
        ], Response::HTTP_CREATED);
    }

    /**
     * @param StoreTicketRequest $request
     * @param Ticket $ticket
     * 
     * @return void
     */
    private function processAttachments(StoreTicketRequest $request, Ticket $ticket): void
    {
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $attachment) {
                $ticket
                    ->addMedia($attachment)
                    ->toMediaCollection(Ticket::MEDIA_ATTACHMENTS);
            }
        }
    }
}
