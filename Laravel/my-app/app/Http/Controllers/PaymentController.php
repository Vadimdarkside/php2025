<?php

namespace App\Http\Controllers\Api;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api'); 
        $this->middleware('role:admin'); 
    }

    /**
     * 
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function read(Request $request)
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
            $payments->where('client_id', $client_id);
        }

        $payments = $payments->get();

        return response()->json(['payments' => $payments]);
    }

    /**
     * 
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $incomeFields = $request->validate([
            "client_id" => 'required',
            "amount" => 'required',
            "payment_date" => 'required',
            "method" => 'required',
        ]);

        $payment = Payment::create($incomeFields);

        return response()->json(['message' => 'Payment created successfully', 'payment' => $payment], 201);
    }

    /**
     * 
     *
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, Request $request)
    {
        $payment = Payment::findOrFail($id);

        $incomeFields = $request->validate([
            "client_id" => 'required',
            "amount" => 'required',
            "payment_date" => 'required',
            "method" => 'required',
        ]);

        $payment->update($incomeFields);

        return response()->json(['message' => 'Payment updated successfully', 'payment' => $payment]);
    }

    /**
     * Видалити платіж
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();

        return response()->json(['message' => 'Payment deleted successfully']);
    }
}
