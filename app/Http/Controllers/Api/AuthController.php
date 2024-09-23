<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Services\Twilio;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Notifications\EmailVerification;
use Laravel\Socialite\Facades\Socialite;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
     public function register(Request $request)
     {
         // قواعد التحقق من صحة البيانات
         $validator = Validator::make($request->all(), [
             'name' => ['required', 'string', 'max:255'],
             'phone' => ['required', 'string', 'max:255', 'unique:users'],
             'UserImage' => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif', 'max:2048'],
             'email' => ['required', 'email', 'max:255', 'unique:users'],
             'notation' => ['required'],
             'password' => ['required', Password::defaults()],
         ], [], [
             'name' => 'Name',
             'email' => 'Email',
             'phone' => 'Phone',
             'UserImage' => 'User Image',
             'password' => 'Password',
         ]);
     
         if ($validator->fails()) {
             return ApiResponse::sendResponse(422, 'Register validation errors', $validator->messages()->all());
         }
     
         // إذا تم تقديم صورة، قم بمعالجتها
         $imageName = null;
         if ($request->hasFile('UserImage')) {
             $image = $request->file('UserImage');
             $imageName = time() . '.' . $image->getClientOriginalExtension();
             $image->move(public_path('images/user'), $imageName);
         }
     
         // إنشاء المستخدم
         $user = User::create([
             'name' => $request->name,
             'email' => $request->email,
             'phone' => $request->phone,
             'image' => $imageName,
             'notation' => $request->notation,
             'password' => Hash::make($request->password),
         ]);
     
         // الحصول على التوكن للمستخدم الجديد
         $data = [
             'token' => $user->createToken('api')->plainTextToken,
             'name' => $user->name,
             'email' => $user->email,
             'phone' => $user->phone,
             'notation' => $user->notation,
         ];
     
         return ApiResponse::sendResponse(201, 'User created successfully', $data);
     }
     
     public function login(Request $request)
     {
         $validator = Validator::make($request->all(), [
             'phone' => ['required', 'string', 'max:255'],
             'password' => ['required'],
         ], [], [
             'phone' => 'phone',
             'password' => 'Password',
         ]);
     
         if ($validator->fails()) {
             return ApiResponse::sendResponse(422, 'Login validation errors', $validator->messages()->all());
         }
     
         // تحقق من صحة رقم الهاتف وكلمة المرور
         $user = User::where('phone', $request->phone)->first();
     
         if ($user && Hash::check($request->password, $user->password)) {
             // توليد OTP وإرساله إلى الهاتف
             $otp = mt_rand(100000, 999999);
             $user->otp = $otp;
             $user->otp_till = now()->addMinutes(10); // تحديد فترة انتهاء صلاحية OTP
             $user->save();
     
             // إرسال OTP عبر Twilio
             $twilioService = new Twilio();
             $twilioService->send($user);
     
             return ApiResponse::sendResponse(200, 'OTP sent successfully', null);
         } else {
             return ApiResponse::sendResponse(401, 'Login credentials are invalid', null);
         }
     }
     
     public function verifyOtp(Request $request)
     {
         $validator = Validator::make($request->all(), [
             'phone' => ['required', 'string', 'max:255'],
             'otp' => ['required', 'numeric'],
         ], [], [
             'phone' => 'phone',
             'otp' => 'OTP',
         ]);
     
         if ($validator->fails()) {
             return ApiResponse::sendResponse(422, 'Verification validation errors', $validator->messages()->all());
         }
     
         $user = User::where('phone', $request->phone)->first();
     
         if ($user && $user->otp === $request->otp && $user->otp_till > now()) {
             // حذف OTP بعد التحقق
             $user->otp = null;
             $user->otp_till = null;
             $user->save();
     
             // إنشاء توكن للمستخدم
             $data['token'] = $user->createToken('api')->plainTextToken;
             $data['name'] = $user->name;
             $data['phone'] = $user->phone;
     
             return ApiResponse::sendResponse(200, 'User authenticated successfully', $data);
         } else {
             return ApiResponse::sendResponse(400, 'Invalid or expired OTP', null);
         }
     }
     
    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return ApiResponse::sendResponse(200, 'Loged out successfully ', []);

    }
    

    
    
    // ...
    
    
    
 
    
   
}