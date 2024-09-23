<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    
    public function handle(Request $request, Closure $next)
    {
        // الحصول على المستخدم المصادق عليه
      /*  $user = $request->user();
    
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    */
        // استخدام اللغة المخزنة في قاعدة البيانات أو اللغة الافتراضية
        $locale = $user->preferred_locale ?? config('app.locale');
        
        // التحقق من أن اللغة المختارة هي إما 'ar' أو 'en'، وإلا سيتم استخدام اللغة الافتراضية
        if (!in_array($locale, ['ar', 'en'])) {
            $locale = config('app.locale');
        }
        
        // تعيين اللغة للتطبيق
        App::setLocale($locale);
    
        return $next($request);
    }
}
