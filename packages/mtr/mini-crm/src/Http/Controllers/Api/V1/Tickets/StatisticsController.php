<?php

namespace Mtr\MiniCrm\Http\Controllers\Api\V1\Tickets;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Mtr\MiniCrm\Http\Resources\Api\V1\StatisticsResource;

class StatisticsController extends Controller
{
    /**
     * Aggregate statistics for tickets.
     * 
     * @return StatisticsResource
     */
    public function index(): StatisticsResource
    {
        return new StatisticsResource(null);
    }
}