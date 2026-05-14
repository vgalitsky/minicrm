<?php
namespace Mtr\MiniCrm\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
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
            'customer_name' => 'nullable|string|max:120',
            'customer_email' => 'nullable|string|max:190',
            'customer_phone' => 'nullable|string|max:32',
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