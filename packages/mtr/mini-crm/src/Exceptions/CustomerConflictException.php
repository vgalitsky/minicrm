<?php

namespace Mtr\MiniCrm\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CustomerConflictException extends Exception
{
    /**
     * @param string $message
     */
    public function __construct(string $message = 'Customer conflict.')
    {
        parent::__construct($message);
    }

    /**
     * @inheritDoc
     */
    public function render(): JsonResponse
    {
        return response()->json(
            ['message' => $this->getMessage()],
            Response::HTTP_CONFLICT,
        );
    }
}
