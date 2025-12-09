<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings; // <-- Import this

class CustomersExport implements FromCollection, WithHeadings // <-- Implement WithHeadings
{
    public function collection()
    {
        // Select only the columns needed for the report
        return Customer::select('id', 'name', 'email', 'phone', 'address', 'created_at')
                       ->get();
    }

    public function headings(): array
    {
        // Define the column headers for the export file
        return [
            'ID',
            'Name',
            'Email',
            'Phone',
            'Address',
            'Joined Date',
        ];
    }
}