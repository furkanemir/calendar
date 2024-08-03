<?php

namespace App\Http\Controllers;

use App\Models\Event;


use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Routing\Controller;


class PDFController extends Controller
{
    public function downloadPDF()
    {
        $buAy = Carbon::now()->month;
        $buYil = Carbon::now()->year;

        $events = Event::with('userList')->whereMonth('start', $buAy)->whereYear('start', $buYil)->get();

        $pdf = PDF::loadView('pdf', compact('events'));

        return $pdf->download('events.pdf');
    }

}
