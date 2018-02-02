<?php

use Aplr\Toolbox\Exceptions\ApiException;

if (! function_exists('urlify')) {

    /**
     * Returns the domain as url.
     *
     * @param string $url
     * @param bool $secure
     * @return string
     */
    function urlify(string $domain, bool $secure = true)
    {
        $protocol = $secure ? 'https' : 'http';

        return "{$protocol}://{$domain}";
    }

}

if (! function_exists('apiError')) {

    function apiError(string $message, int $code)
    {
        throw new ApiException($message, $code);
    }
}

if (! function_exists('api')) {

    function api(string $message, $data = null)
    {
        $response = [
            'message' => $message,
        ];

        if ($data) {
            $response['data'] = $data;
        }

        return response()->json($response);
    }
}

if (! function_exists('mail_random')) {

    function mail_random($tld = 'com')
    {
        $address = str_random(8);
        $host = str_random(8);

        return "{$address}@{$host}.{$tld}";
    }
}

if (! function_exists('appUrl')) {

    function appUrl(string $subdomain, string $path, bool $secure = true)
    {
        $protocol = $secure ? 'https' : 'http';

        $domain = config('app.domain');
        $domain = "{$subdomain}.{$domain}";

        $path = ltrim($path, '/');

        return "{$protocol}://{$domain}/{$path}";
    }
}