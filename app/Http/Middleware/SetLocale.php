<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user has explicitly set a locale (via language switcher)
        if (session()->has('locale_set_by_user') && session('locale_set_by_user') === true) {
            $locale = session('locale', 'en');
        } elseif (!session()->has('locale_detected')) {
            // First visit - detect locale based on IP
            $locale = $this->detectLocaleFromIp($request);
            session(['locale' => $locale, 'locale_detected' => true]);
        } else {
            $locale = session('locale', 'en');
        }

        if (in_array($locale, ['en', 'mk'])) {
            app()->setLocale($locale);
        }

        return $next($request);
    }

    protected function detectLocaleFromIp(Request $request): string
    {
        // Try to get real IP from various headers (for proxies/load balancers)
        $ip = $request->header('CF-Connecting-IP') // Cloudflare
            ?? $request->header('X-Real-IP')
            ?? $request->header('X-Forwarded-For')
            ?? $request->ip();
        
        // If X-Forwarded-For contains multiple IPs, get the first one
        if (str_contains($ip, ',')) {
            $ip = trim(explode(',', $ip)[0]);
        }
        
        // For localhost, try to detect using external service with our public IP
        if (in_array($ip, ['127.0.0.1', '::1', 'localhost'])) {
            // Get public IP for local development
            $ip = $this->getPublicIp();
            if (!$ip) {
                return config('app.locale', 'en');
            }
        }

        // Cache the result for this IP for 24 hours
        $cacheKey = 'ip_country_' . md5($ip);
        
        $countryCode = Cache::remember($cacheKey, 86400, function () use ($ip) {
            return $this->getCountryFromIp($ip);
        });

        // If Macedonian IP, return 'mk', otherwise 'en'
        return $countryCode === 'MK' ? 'mk' : 'en';
    }

    protected function getPublicIp(): ?string
    {
        try {
            $response = @file_get_contents('https://api.ipify.org?format=json', false, stream_context_create([
                'http' => ['timeout' => 2]
            ]));
            
            if ($response) {
                $data = json_decode($response, true);
                return $data['ip'] ?? null;
            }
        } catch (\Exception $e) {
            // Silently fail
        }
        
        return null;
    }

    protected function getCountryFromIp(string $ip): ?string
    {
        try {
            // Using ip-api.com (free, no API key needed, 45 requests/minute limit)
            $response = @file_get_contents("http://ip-api.com/json/{$ip}?fields=countryCode", false, stream_context_create([
                'http' => ['timeout' => 2]
            ]));
            
            if ($response) {
                $data = json_decode($response, true);
                return $data['countryCode'] ?? null;
            }
        } catch (\Exception $e) {
            // Silently fail and return null
        }

        return null;
    }
}
