<?php

namespace Paymenter\Extensions\Others\RemoveBranding\Middleware;

use Closure;

class RemoveBrandingMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        
        if ($response instanceof \Illuminate\Http\Response && 
            str_contains($response->headers->get('Content-Type', ''), 'text/html')) {
            
            try {
                $content = $response->getContent();
                
                $pattern = '/<a[^>]*href=["\']https?:\/\/paymenter\.org["\'][^>]*>[\s\S]*?<\/a>/i';
                $content = preg_replace($pattern, '', $content);
                
                $content = preg_replace('/\{\{--\s*Paymenter is free and opensource[^}]*--\}\}/i', '', $content);
                
                $content = preg_replace('/Powered by\s+Paymenter/i', '', $content);
                
                $content = preg_replace('/\s*\n\s*\n\s*/', "\n", $content);
                
                $response->setContent($content);
            } catch (\Exception $e) {
            }
        }
        
        return $response;
    }
}
