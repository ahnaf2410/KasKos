<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('bill')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('tenant.payments.index', compact('payments'));
    }
}