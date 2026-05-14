<?php
namespace Mtr\MiniCrm\Http\Controllers;

use Illuminate\Routing\Controller;

class WidgetController extends Controller
{
    public function __invoke()
    {
        return view('minicrm::widget');
    }
}