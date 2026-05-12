<?php
namespace Mtr\MiniCrm\Models\Ticket;

enum TicketStatus: string
{
    case New = 'new';
    case InProgress = 'in_progress';
    case Closed = 'closed';

    /**
     * @return string
     */
    public function __invoke(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::New => 'New',
            self::InProgress => 'In Progress',
            self::Closed => 'Closed',
        };
    }

    /**
     * @return string[]
     */
    public static function values(): array
    {
        return array_map(fn($status) => $status->value, self::cases());
    }
}