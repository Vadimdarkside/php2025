<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PaymentController extends Controller
{
    public function read(Request $request)
    {
        if($request->get('filter'))
        {
            $client_id = $request->get('client_id');
            $amount = $request->get('amount');
            $payment_date = $request->get('payment_date');
            $method = $request->get('method');
            $payments = Payment::query();
            if ($method) {
                $payments->where('method', $method);
            }
            if ($amount) {
                $payments->where('amount', '>=', $amount);
            }
            if ($payment_date) {
                $payments->whereDate('payment_date', $payment_date);
            }
            if ($client_id) {
                $payments->where('client_id', $client_id );
            }
            $payments = $payments->get(); 

            return view('payments/payments', ['payments' => $payments]);
        }
        $payments = Payment::all();
        return view('payments/payments', ['payments' => $payments]);
    }
    public function create(Request $request)
    {
        $incomeFields = $request->validate([
            "client_id"=>'required',
            "amount"=>'required',
            "payment_date"=>'required',
            "method" => 'required'
        ]);
        Payment::create($incomeFields);
        return redirect('/payments');
    }   
    public function showUpdateForm($id)
    {
        $payment = Payment::findOrFail($id);
        return view('payments/payment-edit', ['payment' => $payment]);
    }   
    public function update($id, Request $request)
    {
        $payment = Payment::findOrFail($id);
        $incomeFields = $request->validate([
           "client_id"=>'required',
            "amount"=>'required',
            "payment_date"=>'required',
            "method" => 'required'
        ]);
        $payment->update($incomeFields);
        return redirect('/payments');
    }   

    public function delete($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();
        return redirect('/payments');
    } 
}
