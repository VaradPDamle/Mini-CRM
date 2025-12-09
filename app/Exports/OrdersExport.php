<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrdersExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        // Select order details and the related customer name
        return Order::with('customer')
            ->get()
            ->map(function ($order) {
                return [
                    'Order ID' => $order->id,
                    'Order Number' => $order->order_number,
                    'Customer Name' => $order->customer->name ?? 'N/A', // Access related customer name
                    'Amount' => $order->amount,
                    'Status' => $order->status,
                    'Order Date' => $order->order_date,
                    'Created At' => $order->created_at,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Order ID',
            'Order Number',
            'Customer Name',
            'Amount',
            'Status',
            'Order Date',
            'Created At',
        ];
    }
}