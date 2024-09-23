<?php

namespace App\Http\Controllers\Api;

use App\Models\Offer;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\OfferResource;
use Illuminate\Support\Facades\Validator;

class OfferController extends Controller
{
    public function AllOffers(Request $request){
$offers=Offer::all();

return ApiResponse::sendResponse(201, 'get all offers  ',OfferResource::collection($offers));


    }

    public function OfferUpdate(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'new_price' => 'sometimes|required|numeric',
            'offer_end_date' => 'sometimes|required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $offer = Offer::find($id);

        if (!$offer) {
            return response()->json([
                'message' => 'Offer not found'
            ], 404);
        }

        $offer->update($request->only(['new_price', 'offer_end_date']));

        return response()->json([
            'message' => 'Offer updated successfully',
            'data' => new OfferResource($offer)
        ], 200);
    }
}
