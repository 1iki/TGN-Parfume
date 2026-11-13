<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\Message;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPendings = Order::where('payment_status', 'Pending')->sum('total_price');
        $totalCompletes = Order::where('payment_status', 'Completed')->sum('total_price');
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalUsers = User::where('level', 'consument')->count();
        $totalAdmins = User::whereIn('level', ['Super Admin', 'Admin', 'Customer Service', 'Marketing', 'Executive'])->count();
        $totalMessages = Message::count();

        return view('admin.dashboard', compact(
            'totalPendings',
            'totalCompletes',
            'totalOrders',
            'totalProducts',
            'totalUsers',
            'totalAdmins',
            'totalMessages'
        ));
    }
}
