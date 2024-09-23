<?php

namespace App\Http\Controllers\Api;

use App\Models\Tour;
use App\Models\User;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index(){
        $tour=Tour::all();
        return response()->json($tour);

    }
    public function ueserInfo(){
        $UserID=Auth::id();
        $User=User::where('id',$UserID)->get();
        return response()->json(ApiResponse::sendResponse(200, 'this is all tour', $User));

    }
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['string', 'max:255'],
            'phone' => ['string', 'max:255', 'unique:users,phone,' . Auth::id()],
            'UserImage' => ['file', 'mimes:jpg,jpeg,png,gif', 'max:2048'],
            'email' => ['email', 'max:255', 'unique:users,email,' . Auth::id()],
            'notation' => ['nullable', 'string'],
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ], [], [
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'UserImage' => 'User Image',
            'password' => 'Password',
        ]);
    
        if ($validator->fails()) {
            return ApiResponse::sendResponse(422, 'Validation errors', $validator->messages()->all());
        }
    
        $user = Auth::user();
    
        if (!$user) {
            return ApiResponse::sendResponse(404, 'User not found', null);
        }
    
        if ($request->hasFile('UserImage')) {
            $oldImagePath = public_path('images/user/' . $user->image);
            if ($user->image && file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
    
            $image = $request->file('UserImage');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/user'), $imageName);
            $user->image = $imageName;
        }
    
        $user->name = $request->input('name', $user->name);
        $user->phone = $request->input('phone', $user->phone);
        $user->notation = $request->input('notation', $user->notation);
        $user->email = $request->input('email', $user->email);
    
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }
    
        $user->save();
    
        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'notation' => $user->notation,
            'image' => $user->image,
        ];
    
        return ApiResponse::sendResponse(200, 'User updated successfully', $data);
    }
    

}
