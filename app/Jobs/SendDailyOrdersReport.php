<?php

namespace App\Jobs;

use App\Mail\DailyOrdersReport;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrdersExport;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendDailyOrdersReport implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
        
    }

    public function handle()
    {
        $orders = Order::with(['items','paymentMethod','address','items.product:name'])->whereDate('created_at',Carbon::yesterday())->get();
        $filename = 'daily_orders_' . Carbon::now()->format('Y-m-d') . '.xlsx';
        $filePath = storage_path('app/reports/' . $filename);
        Log::info('Orders:', ['orders' => $orders]);
        if (!file_exists(dirname($filePath))) {
            mkdir(dirname($filePath), 0755, true);
        }
        Excel::store(new OrdersExport($orders), 'reports/' . $filename);
        Mail::to('karim.moeissa@gmail.com')
            ->send(new DailyOrdersReport($filename));
    }
}
