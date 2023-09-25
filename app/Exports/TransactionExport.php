<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class TransactionExport implements FromCollection, WithHeadings, WithCustomCsvSettings
{
    protected $transactions;

    public function __construct($transactions)
    {
        $this->transactions = $transactions;
    }

    public function headings(): array
    {
        return [
            'merchant_name',
            'outlet_name',
            'date',
            'time',
            'staff',
            'pay_amount',
            'payment_type',
            'customer_name',
            'tax',
            'change_amount',
            'total_amount'
        ];
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ';',
            'use_bom' => false,
            'output_encoding' => 'ISO-8859-1',
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->transactions;
    }
}
