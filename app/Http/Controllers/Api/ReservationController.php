<?php

namespace App\Http\Controllers\Api;

use App\Services\PriceService; // استيراد الخدمة
use App\Models\Reservation;
use Illuminate\Support\Str;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ReservationResource;
use Stripe\Stripe;
use Stripe\Charge;
use App\Services\PaymentService; // استيراد خدمة الدفع

class ReservationController extends Controller
{
    protected $priceService;
    protected $paymentService;

    public function __construct(PriceService $priceService , PaymentService $paymentService)
    {
        $this->priceService = $priceService;
        $this->paymentService = $paymentService; 

    }

    public function createReservation(Request $request)
    {
        $request->validate([
            'tour_id' => 'required|exists:tours,id',
            'number_of_people' => 'required|integer',
            'number_of_children' => 'required|integer',
            'reservation_date' => 'required|date',
        ]);

        $reservationNumber = 'RES-' . strtoupper(Str::random(10));
        $userId = Auth::id(); 
        $totalPrice = $this->priceService->totalPrice(
            $request->input('tour_id'),
            $request->input('number_of_people'),
            $request->input('number_of_children')
        );

        $reservation = Reservation::create([
            'reservation_number' => $reservationNumber,
            'user_id' => $userId,
            'tour_id' => $request->input('tour_id'),
            'number_of_people' => $request->input('number_of_people'),
            'number_of_children' => $request->input('number_of_children'),
            'reservation_date' => $request->input('reservation_date'),
            'total_price' => $totalPrice,
        ]);

        return response()->json([
            'message' => 'Reservation created successfully',
            'reservation' => $reservation
        ], 201);
    }


    public function processPayment(Request $request, $id)
    {
        $response = $this->paymentService->processPayment($id, $request->input('stripeToken'));

        if ($response['success']) {
            return response()->json(['message' => $response['message']], 200);
        } else {
            return response()->json(['error' => $response['message']], 400);
        }
    }

    
    public function showPaymentForm($id)
    {
        $reservation = Reservation::findOrFail($id);
    
        return view('tours.payment', compact('reservation'));
    }
    
    
}
