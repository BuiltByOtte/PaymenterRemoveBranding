<?php

namespace Paymenter\Extensions\Others\RemoveBranding;

use App\Classes\Extension\Extension;
use Illuminate\Support\HtmlString;
use Exception;

class RemoveBranding extends Extension
{
    public function getConfig($values = [])
    {
        try {
            return [
                [
                    'name' => 'Notice',
                    'type' => 'placeholder',
                    'label' => new HtmlString(
                        'This extension removes the "Powered by Paymenter" text from the footer of your website. ' .
                        'Simply enable this extension to hide the branding.'
                    ),
                ],
            ];
        } catch (Exception $e) {
            return [
                [
                    'name' => 'Notice',
                    'type' => 'placeholder',
                    'label' => new HtmlString(
                        'Enable the Remove Branding extension to hide the "Powered by Paymenter" branding from the footer.'
                    ),
                ],
            ];
        }
    }

    public function boot()
    {
        $this->registerMiddleware();
    }

    protected function registerMiddleware()
    {
        try {
            $router = app('router');
            if ($router && method_exists($router, 'pushMiddlewareToGroup')) {
                $router->pushMiddlewareToGroup('web', \Paymenter\Extensions\Others\RemoveBranding\Middleware\RemoveBrandingMiddleware::class);
            }
        } catch (\Exception $e) {
        }
    }
}
