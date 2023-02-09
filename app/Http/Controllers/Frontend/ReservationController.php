<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\TableStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReservationStoreRequest;
use App\Models\Reservation;
use App\Models\Table;
use App\Rules\DateBetween;
use App\Rules\TimeBetween;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function stepOne(Request $request)
    {
        $tables = Table::where('status', TableStatus::Available)->get();
        $reservation = $request->session()->get('reservation');
        $min_date = Carbon::today();
        $max_date = Carbon::now()->addWeek();
        $reservation = $request->session()->get('reservation');
        
        return view('reservations.step-one', compact('reservation', 'min_date', 'max_date', 'tables'));
    }

    public function storeStepOne(Request $request1, ReservationStoreRequest $request)
    {
        
        $table = Table::find($request->table_id);
        if ($request->guest_number > $table->guest_number) {
            return back()->with(['warning' => 'Tolong pilih Meja yang sesuai dengan jumlah tamu']);
        }
        $request_date = Carbon::parse($request->res_date);
        foreach ($table->reservations as $res) {
            if ($res->res_date->format('Y-m-d') == $request_date->format('Y-m-d'))
            return back()->with(['warning' => 'Meja sudah dipesan pada tanggal tersebut']);
        }
        Reservation::create($request->validated());

        return view('thankyou')->with((['success' => 'Reservasi berhasil dibuat']));
    }

}