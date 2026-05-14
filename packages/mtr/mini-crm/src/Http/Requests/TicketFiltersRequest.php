<?php
namespace Mtr\MiniCrm\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Mtr\MiniCrm\Models\Ticket\TicketStatus;

class TicketFiltersRequest extends FormRequest
{
    /**
     * @inheritDoc
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        $statusRules = [
            'nullable',
            'string',
            'in:' . implode(',', TicketStatus::values()),
        ];

        return [
            'status' => $statusRules,
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
            'customer_name' => 'nullable|string',
            'customer_email' => 'nullable|string',
            'customer_phone' => 'nullable|string',
        ];
    }

    /**
     * @inheritDoc
     */
    public function messages(): array
    {
        return [
            'status.in' => 'Status must be one of: ' . implode(', ', TicketStatus::values()),
            'date_to.after_or_equal' => 'The end date must be after or equal to the start date.',
        ];
    }
}