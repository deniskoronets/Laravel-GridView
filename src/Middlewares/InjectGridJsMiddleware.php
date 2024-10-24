<?php

namespace Woo\GridView\Middlewares;
use Illuminate\Http\Request;

class InjectGridJsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, \Closure $next)
    {
        $response = $next($request);

        // Check if the response is a valid HTML response
        if ($response instanceof \Illuminate\Http\Response) {
            $content = $response->getContent();

            // Your custom JS code
            $customJs = "<script>" . file_get_contents(__DIR__ . '/../../resources/js/grid-view.js') . "</script>";

            // Replace </body> with your custom JS before it
            $content = str_replace('</body>', $customJs . '</body>', $content);

            // Set the modified content back into the response
            $response->setContent($content);
        }

        return $response;
    }
}
