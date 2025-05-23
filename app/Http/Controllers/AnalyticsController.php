<?php



namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        //  New Users:
        $usersLast7 = User::select(
                DB::raw("DATE(created_at) as date"),

            DB::raw("count(*) as count")
            )
            ->where('created_at', '>=', now()->subDays(6)->startOfDay()->setTimezone('UTC'))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count','date');

        //  Sales: daily sum for last 7 days
 //  Total Users
    $totalUsers = User::count();

    // Total Revenue (only from completed/shipping orders)
    $totalRevenue = Order::whereIn('status', ['completed', 'shipping_in_progress'])
        ->sum('total');

    // Average Order Value
    $avgOrder = Order::whereIn('status', ['completed', 'shipping_in_progress'])
        ->avg('total');

    // Conversion Rate (simple placeholder logic, e.g. orders / users)
    $totalOrders = Order::count();
    $conversionRate = $totalUsers > 0 ? round(($totalOrders / $totalUsers) * 100, 2) : 0;
$salesLast7 = DB::table('orders')
    ->select(
        DB::raw("DATE(created_at) as date"),
        DB::raw("CAST(SUM(total) AS DECIMAL(10,2)) as daily_total")
    )
    ->where('created_at', '>=', now()->subDays(6)->startOfDay()->setTimezone('UTC'))
    ->where('status', 'shipping_in_progress')
    ->groupBy(DB::raw("DATE(created_at)"))
    ->orderBy('date')
    ->get()
    ->mapWithKeys(function ($row) {
        return [$row->date => (float) $row->daily_total];
    });  


        //  Shipping Rate: shipped vs pending (last 30 days)
        $shipping = Order::select('status', DB::raw("count(*) as count"))
            ->where('created_at','>=', now()->subDays(29)->startOfDay())
            ->groupBy('status')
            ->get()
            ->pluck('count','status');

        // Top Products by units sold (last 30 days)
        $topProducts = OrderItem::select('product_id', DB::raw("SUM(quantity) as units"))
            ->where('created_at','>=', now()->subDays(29)->startOfDay())
            ->groupBy('product_id')
            ->orderByDesc('units')
            ->take(5)
            ->get()
            ->mapWithKeys(function($row) {
                $name = Product::find($row->product_id)->name;
                return [$name => $row->units];
            });

        return view('admin.Analytics', [
                    'usersLast7'      => $usersLast7,
                    'salesLast7'      => $salesLast7,
                    'shipping'        => $shipping,
                    'topProducts'     => $topProducts,
                    'totalUsers'      => $totalUsers,
                    'totalRevenue'    => $totalRevenue,
                    'avgOrder'        => $avgOrder,
                    'conversionRate'  => $conversionRate,
        ]);
    }
}
