<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use Carbon\Carbon;

class ExpiryAlertController extends Controller
{
    public function index()
    {
        // Define the date range
        $today = Carbon::today();
        $nextWeek = Carbon::today()->addDays(7);

        // Query products expiring soon
        $products = Product::whereDate('expiry_date', '>=', $today)
                           ->whereDate('expiry_date', '<=', $nextWeek)
                           ->get();

        // Pass to the view
        return view('expiry_alerts.index', compact('products'));
    }
}
