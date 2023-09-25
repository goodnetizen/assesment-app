<?php

namespace App\Http\Controllers;

use App\Exports\TransactionExport;
use App\Models\Merchant;
use App\Models\Outlet;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class TransactionController extends Controller
{
    // show transaction list
    public function index(Request $request) {
        $list = Transaction::query()
            ->when($request->input('merchant'), function ($query, $merchant) {
                $query->where('merchant_id', $merchant);
            })
            ->when($request->input('outlet'), function ($query, $outlet) {
                $query->where('outlet_id', $outlet);
            })
            ->when($request->input('paymentStatus'), function ($query, $paymentStatus) {
                $query->where('payment_status', $paymentStatus);
            })
            ->when($request->input('date'), function ($query, $date) {
                $query->whereRaw("DATE_FORMAT(transaction_time, '%Y-%m-%d') = '{$date}'");
            })
            ->when($request->input('search'), function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->orWhere('total_amount', 'like', "%{$search}%")
                    ->orWhere('staff', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%");
                });
            })
            ->with('merchant:id,code,name','outlet:id,code,name')
            ->orderBy('transaction_time', 'desc')
            ->paginate(10)
            ->onEachSide(3)
            ->withQueryString()
            ->through(fn($value) => [
                'merchant_name' => $value->merchant->name,
                'outlet_name' => $value->outlet->name,
                'date' => Carbon::parse($value->transaction_time)->format('d-m-Y'),
                'time' => Carbon::parse($value->transaction_time)->format('H:i:s'),
                'staff' => $value->staff,
                'pay_amount' => number_format($value->pay_amount),
                'payment_type' => $value->payment_type,
                'customer_name' => $value->customer_name,
                'tax' => number_format($value->tax),
                'change_amount' => number_format($value->change_amount),
                'total_amount' => number_format($value->total_amount),
        ]);

        $merchants = Merchant::select('id','name')->orderBy('name')->get();
        $outlets = Outlet::select('id','name')->orderBy('name')->get();
        $paymentStatus = ['Paid','Not Paid'];

        return Inertia::render('TransactionView', [
            'transactionList' => $list,
            'merchantList' => $merchants,
            'outletList' => $outlets,
            'paymentStatus' => $paymentStatus,
            'filters' => $request->only('search')
        ]);
    }

    public function export(Request $request) {
        $transactions = Transaction::query()
            ->where('payment_status', 'Paid')
            ->when($request->input('merchant'), function ($query, $merchant) {
                $query->where('merchant_id', $merchant);
            })
            ->when($request->input('outlet'), function ($query, $outlet) {
                $query->where('outlet_id', $outlet);
            })
            ->when($request->input('date'), function ($query, $date) {
                $query->whereRaw("DATE_FORMAT(transaction_time, '%Y-%m-%d') = '{$date}'");
            })
            ->when($request->input('search'), function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->orWhere('total_amount', 'like', "%{$search}%")
                    ->orWhere('staff', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%");
                });
            })
            ->with('merchant:id,code,name','outlet:id,code,name')
            ->orderBy('transaction_time', 'desc')
            ->get()
            ->transform(function ($row) {
                return [
                    'merchant_name' => $row->merchant->name,
                    'outlet_name' => $row->outlet->name,
                    'date' => Carbon::parse($row->transaction_time)->format('d-m-Y'),
                    'time' => Carbon::parse($row->transaction_time)->format('H:i:s'),
                    'staff' => $row->staff,
                    'pay_amount' => $row->pay_amount,
                    'payment_type' => $row->payment_type,
                    'customer_name' => $row->customer_name,
                    'tax' => $row->tax,
                    'change_amount' => $row->change_amount,
                    'total_amount' => $row->total_amount,
            ];
        });

        return Excel::download(new TransactionExport($transactions), 'transaction-list.csv', \Maatwebsite\Excel\Excel::CSV, [
            'Content-Type' => 'text/csv',
      ]);
    }
}
