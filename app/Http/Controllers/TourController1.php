<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use App\Models\TourImage;
use Illuminate\Http\Request;
use Stichoza\GoogleTranslate\GoogleTranslate;
use App\Traits\UploadsImages;
use App\Traits\TranslationTrait;
class TourController extends Controller
{

    use UploadsImages, TranslationTrait;

    /**
     * Display a listing of the tours.
     */
    public function index(Request $request)
    {
        // Get the selected language from the request (default to 'en' if not provided)
        $locale = app()->getLocale(); // Get the current locale
        
        // Fetch all tours with translations
        $tours = Tour::with('translations')->get();
    
        // Pass the data to the view
        return view('tours.index', compact('tours', 'locale'));
    }
    

    /**
     * Store a newly created tour with translations.
     */

     public function store(Request $request)
     {
         // Get the selected locale from the request, default to 'ar' (Arabic) if not provided
         $selectedLocale = $request->get('locale', 'ar');
     
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
         return redirect()->route('tours.index')->with('success', 'Tour created successfully with translations and images');
     }
     


    /**
     * Display the specified tour by ID.
     */
    public function show($id, Request $request)
    {
        $locale = app()->getLocale(); // Get the current locale
    
        // Fetch the tour with translations
        $tour = Tour::with('translations')->findOrFail($id);
    
        // Pass the tour and locale to the view
        return view('tours.show', compact('tour', 'locale'));
    }
    public function create()
{
    return view('tours.create'); // Display the form view
}
}
