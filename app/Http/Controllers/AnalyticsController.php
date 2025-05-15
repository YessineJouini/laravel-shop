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
        // 1) New Users: daily counts for the last 7 days
        $usersLast7 = User::select(
                DB::raw("DATE(created_at) as date"),

            DB::raw("count(*) as count")
            )
            ->where('created_at', '>=', now()->subDays(6)->startOfDay()->setTimezone('UTC'))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count','date');

        // 2) Sales: daily sum for last 7 days

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
    });  // Remove the ->toArray()


        // 3) Shipping Rate: shipped vs pending (last 30 days)
        $shipping = Order::select('status', DB::raw("count(*) as count"))
            ->where('created_at','>=', now()->subDays(29)->startOfDay())
            ->groupBy('status')
            ->get()
            ->pluck('count','status');

        // 4) Top Products by units sold (last 30 days)
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
            'usersLast7'  => $usersLast7,
            'salesLast7'  => $salesLast7,
            'shipping'    => $shipping,
            'topProducts' => $topProducts,
        ]);
    }
}
