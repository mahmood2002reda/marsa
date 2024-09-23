<?php

namespace App\Http\Controllers\Api;

use App\Models\Tour;
use App\Models\User;
use App\Models\TourImage;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Traits\UploadsImages;
use App\Models\TourTranslation;
use App\Services\FirebaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\TourResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\OfferResource;
use App\Http\Resources\SearchResource;
use App\Notifications\SendPushNotification;
use Illuminate\Support\Facades\Notification;
use Stichoza\GoogleTranslate\GoogleTranslate;

class TourController extends Controller
{
    use UploadsImages;
//////////////////////////////////////////////////////////////////////////////////////////////////////
// setlocale by session
    public function setLocale2(Request $request)
{
    $locale = $request->input('locale');
    $availableLocales = config('app.supported_locales', ['en']);

    if (in_array($locale, $availableLocales)) {
        App::setLocale($locale);
        session(['locale' => $locale]);
        return response()->json([
            'success' => true,
            'message' => 'Locale set successfully',
            'locale' => $locale
        ]);
    } else {
        return response()->json([
            'success' => false,
            'message' => 'Invalid locale'
        ], 400);
    }
}
    /**
     * Get the current application locale.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLocale2()
    {
        $currentLocale = app()->getLocale();
        return response()->json([
            'locale' => $currentLocale,
            'message' => __('messages.welcome') // This will use a translated message
        ]);
    }

//////////////////////////////////////////////////////////////////////////////////////////////////////
    


public function setLocale1(Request $request)
    {
        // Locale is already set by the middleware, just return a success message
        $locale = App::getLocale();
        $dashUrl = route('dash');
        return response()->json([
            'success' => true,
            'message' => 'Locale set successfully',
            'locale' => $locale,
            'get' => $dashUrl ,
        ]);
       

    }
    
    public function getLocale1()
    {
     /*            $locale = App::getLocale();
        
      return response()->json([
            'current_locale' => $locale,
            'message' => __('messages.welcome') // This message will be translated based on the locale
        ]);*/
    }
    public function index()
{
    // Retrieve all tours and return them (for example, in a paginated format or as a list)
    $tours = Tour::all(); // يمكنك استخدام `paginate()` إذا كنت ترغب في التصفية على صفحات

    // إذا كنت تستخدم واجهة API، يمكنك استخدام `TourResource` لتحويل النماذج إلى JSON:
    return TourResource::collection($tours);
}


    public function store(Request $request)
    {
        // Get the selected locale from the request, default to 'ar' (Arabic) if not provided
        $selectedLocale = app()->getLocale();
    
        // Validate the request data
        $request->validate([
            'start_date' => 'required|date',
            'price' => 'required|numeric',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'TourImages.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'translations.' . $selectedLocale . '.tour_duration' => 'required|string',
            'translations.' . $selectedLocale . '.must_know' => 'required|string',
            'translations.' . $selectedLocale . '.location' => 'required|string',
            'translations.' . $selectedLocale . '.type' => 'required|string',
            'translations.' . $selectedLocale . '.governorate' => 'required|string',
            'translations.' . $selectedLocale . '.name' => 'required|string',
            'translations.' . $selectedLocale . '.description' => 'required|string',
            'translations.' . $selectedLocale . '.services' => 'required|string',
        ]);
    
        // Create a new tour in the 'tours' table
        $tour = new Tour();
        $tour->start_date = $request->start_date;
        $tour->price = $request->price;
        $tour->latitude = $request->latitude;
        $tour->longitude = $request->longitude;
        $tour->save();
    
        // Fetch the translation data for the selected locale
        $translationData = $request->translations[$selectedLocale];
    
        // Translate and save the content based on the selected locale
        if ($selectedLocale === 'ar') {
            // Use Google Translate to translate Arabic to English
            $tr = new GoogleTranslate('en'); // Target language is English
    
            // Translate all fields from Arabic to English
            $translatedToEnglish = [
                'tour_duration' => $tr->translate($translationData['tour_duration']),
                'must_know' => $tr->translate($translationData['must_know']),
                'location' => $tr->translate($translationData['location']),
                'type' => $tr->translate($translationData['type']),
                'governorate' => $tr->translate($translationData['governorate']),
                'name' => $tr->translate($translationData['name']),
                'description' => $tr->translate($translationData['description']),
                'services' => $tr->translate($translationData['services']),
            ];
    
            // Save Arabic translations
            $tour->translateOrNew('ar')->tour_duration = $translationData['tour_duration'];
            $tour->translateOrNew('ar')->must_know = $translationData['must_know'];
            $tour->translateOrNew('ar')->location = $translationData['location'];
            $tour->translateOrNew('ar')->type = $translationData['type'];
            $tour->translateOrNew('ar')->governorate = $translationData['governorate'];
            $tour->translateOrNew('ar')->name = $translationData['name'];
            $tour->translateOrNew('ar')->description = $translationData['description'];
            $tour->translateOrNew('ar')->services = $translationData['services'];
    
            // Save the automatically translated English content
            $tour->translateOrNew('en')->tour_duration = $translatedToEnglish['tour_duration'];
            $tour->translateOrNew('en')->must_know = $translatedToEnglish['must_know'];
            $tour->translateOrNew('en')->location = $translatedToEnglish['location'];
            $tour->translateOrNew('en')->type = $translatedToEnglish['type'];
            $tour->translateOrNew('en')->governorate = $translatedToEnglish['governorate'];
            $tour->translateOrNew('en')->name = $translatedToEnglish['name'];
            $tour->translateOrNew('en')->description = $translatedToEnglish['description'];
            $tour->translateOrNew('en')->services = $translatedToEnglish['services'];
    
        } else if ($selectedLocale === 'en') {
            // Use Google Translate to translate English to Arabic
            $tr = new GoogleTranslate('ar'); // Target language is Arabic
    
            // Translate all fields from English to Arabic
            $translatedToArabic = [
                'tour_duration' => $tr->translate($translationData['tour_duration']),
                'must_know' => $tr->translate($translationData['must_know']),
                'location' => $tr->translate($translationData['location']),
                'type' => $tr->translate($translationData['type']),
                'governorate' => $tr->translate($translationData['governorate']),
                'name' => $tr->translate($translationData['name']),
                'description' => $tr->translate($translationData['description']),
                'services' => $tr->translate($translationData['services']),
            ];
    
            // Save English translations
            $tour->translateOrNew('en')->tour_duration = $translationData['tour_duration'];
            $tour->translateOrNew('en')->must_know = $translationData['must_know'];
            $tour->translateOrNew('en')->location = $translationData['location'];
            $tour->translateOrNew('en')->type = $translationData['type'];
            $tour->translateOrNew('en')->governorate = $translationData['governorate'];
            $tour->translateOrNew('en')->name = $translationData['name'];
            $tour->translateOrNew('en')->description = $translationData['description'];
            $tour->translateOrNew('en')->services = $translationData['services'];
    
            // Save the automatically translated Arabic content
            $tour->translateOrNew('ar')->tour_duration = $translatedToArabic['tour_duration'];
            $tour->translateOrNew('ar')->must_know = $translatedToArabic['must_know'];
            $tour->translateOrNew('ar')->location = $translatedToArabic['location'];
            $tour->translateOrNew('ar')->type = $translatedToArabic['type'];
            $tour->translateOrNew('ar')->governorate = $translatedToArabic['governorate'];
            $tour->translateOrNew('ar')->name = $translatedToArabic['name'];
            $tour->translateOrNew('ar')->description = $translatedToArabic['description'];
            $tour->translateOrNew('ar')->services = $translatedToArabic['services'];
        }
    
        // Save the tour with translations
        $tour->save();
    
        // Handle multiple image uploads using the trait
        if ($request->hasFile('TourImages')) {
            $imagePaths = $this->uploadMultipleImages($request->file('TourImages'));
    
            foreach ($imagePaths as $imagePath) {
                // Save each image in the tour_images table
                $tourImage = new TourImage();
                $tourImage->tour_id = $tour->id;
                $tourImage->image = $imagePath;
                $tourImage->save();
            }
        }
    
        // Redirect to the tour index page with a success message

        return ApiResponse::sendResponse(201, 'new tour is add ',[]);
    }
    
    public function show($id)
{
    // Retrieve the tour by its ID along with translations
    $tour = Tour::with('translations')->findOrFail($id);

    // Get the translated version of the tour based on the locale set in the middleware
    $currentLocale = app()->getLocale();

    // Return the translated tour details along with the locale in the response
    return ApiResponse::sendResponse(200, 'Tour details', [
        'tour' => new TourResource($tour)  ,// Return the original tour resource
        'locale'=>$currentLocale
    ]);
}

    
    public function updateToken(Request $request){
        try{
            $request->user()->update(['fcm_token'=>$request->token]);
            return response()->json([
                'success'=>true
            ]);
        }catch(\Exception $e){
            report($e);
            return response()->json([
                'success'=>false
            ],500);
        }
    }
    public function notification(Request $request){
        $request->validate([
            'title'=>'required',
            'message'=>'required'
        ]);
    
        try{
            $fcmTokens = User::whereNotNull('fcm_token')->pluck('fcm_token')->toArray();
    
            Notification::send(null,new SendPushNotification($request->title,$request->message,$fcmTokens));
    
            /* or */
    
            //auth()->user()->notify(new SendPushNotification($title,$message,$fcmTokens));
    
            /* or */
    
        /*    Larafirebase::withTitle($request->title)
                ->withBody($request->message)
                ->sendMessage($fcmTokens);*/
    
            return redirect()->back()->with('success','Notification Sent Successfully!!');
    
        }catch(\Exception $e){
            report($e);
            return redirect()->back()->with('error','Something goes wrong while sending notification.');
        }
    }


    public function MakeOffer(Request $request, $id) {
        $tour = Tour::findOrFail($id);
    
        $tour->has_offer = $request->input('has_offer');
    
        $tour->save();
        return ApiResponse::sendResponse(201, 'hasOoffer is update successfly  ',new TourResource($tour));

       
    }

    public function GetAllTypes(Request $request ) {
        $types = Tour::distinct()->pluck('type');
    

        return ApiResponse::sendResponse(201, 'hasOoffer is update successfly  ',$types);

       
    }

        // جلب جميع الأنواع المميزة
    public function getTypes()
    {
        $types = Tour::distinct()->pluck('type'); // جلب الأنواع المتاحة
        return response()->json($types, 200);
    }

    // جلب الرحلات حسب النوع المختار، وجلب المناطق المتاحة لهذا النوع
    public function getToursByType(Request $request)
    {
        $type=$request->$request->input('typy');
        $tours = Tour::where('type', $type)->get();
        $governorates = Tour::where('type', $type)->distinct()->pluck('governorate'); // جلب المناطق المرتبطة بالنوع

        if ($tours->isEmpty()) {
            return response()->json(['message' => 'No tours found for this type'], 404);
        }

        return response()->json([
            'tours' => $tours,
            'governorates' => $governorates
        ], 200);
    }

    // جلب الرحلات حسب النوع والمنطقة المختارة
    public function getToursByTypeAndGovernorate($type,$governorate)
    {
        $type = request()->route('type'); // استخراج النوع من المسار
    
        // فحص القيم التي يتم استقبالها من الطلب

        $tours = Tour::where('type', $type)
                     ->where('governorate', $governorate)
                     ->get();
    
        // إذا لم يتم العثور على جولات، إرجاع رسالة خطأ
        if ($tours->isEmpty()) {
            return response()->json(['message' => 'No tours found for this type and governorate'], 404);
        }
    
        // إرجاع الجولات في استجابة JSON
        return response()->json($tours, 200);
    }
    

    public function create()
    {
        return view('index'); // Display the form view
    }

    public function searchTours(Request $request)
    {
        // الحصول على المدخلات من المستخدم
        $word = $request->input('searchName') ?? null;
        $governorate = $request->input('tourGavarnment') ?? null;
        $MinPrice = $request->input('MinPrice') ?? null;
        $MaxPrice = $request->input('MaxPrice') ?? null;
    
        // تعيين اللغة الحالية
        $locale = app()->getLocale(); 
    
        // بدء استعلام البحث من نموذج TourTranslation
        $query = TourTranslation::query()
            ->with('images') // تحميل الصور باستخدام علاقة hasManyThrough
            ->join('tours', 'tour_translations.tour_id', '=', 'tours.id') // التأكد من أن اسم الجدول هو "tours"
            ->where('tour_translations.locale', $locale);
    
        // البحث بناءً على الاسم إذا كان متاحًا
        if (!empty($word)) {
            $query->where('tour_translations.name', 'like', '%' . $word . '%');
        }
    
        // البحث بناءً على المحافظة (governorate) إذا كانت متاحة
        if (!empty($governorate)) {
            $query->where('tour_translations.governorate', 'like', '%' . $governorate . '%');
        }
    
        // إضافة شرط السعر (إذا تم تحديد الحد الأدنى والأقصى)
        if (!empty($MinPrice) && !empty($MaxPrice)) {
            $query->whereBetween('tours.price', [$MinPrice, $MaxPrice]);
        } elseif (!empty($MinPrice)) {
            $query->where('tours.price', '>=', $MinPrice);
        } elseif (!empty($MaxPrice)) {
            $query->where('tours.price', '<=', $MaxPrice);
        }
    
        // الحصول على جميع النتائج
        $tours = $query->select('tour_translations.*', 'tours.price', 'tours.start_date', 'tours.latitude', 'tours.longitude', 'tours.has_offer')->get();
    
        // التحقق من وجود نتائج
        if ($tours->count() > 0) {
            $data = [
                'records' => SearchResource::collection($tours), // استخدام الـ Resource لتهيئة النتائج
            ];
            return ApiResponse::sendResponse(200, 'Tours retrieved successfully', $data);
        } else {
            return ApiResponse::sendResponse(200, 'No tours available', []);
        }
    }
    
    
    
    public function setLocale(Request $request)
    {
        $locale = $request->input('locale');
        $availableLocales = config('app.supported_locales', ['en']);

        if (in_array($locale, $availableLocales)) {
            $user = Auth::user();
            if (!$user) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            // حفظ اللغة المفضلة في قاعدة البيانات
            $user->preferred_locale = $locale;
            
/** @var \App\Models\User $user **/

            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Locale set successfully',
                'locale' => $locale
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Invalid locale'
            ], 400);
        }
    }

    /**
     * Get the current application locale.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLocale(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $currentLocale = app()->getLocale();
        return response()->json([
            'locale' => $currentLocale,
            'message' => __('messages.welcome') // This will use a translated message
        ]);
    }

}
