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

if (! function_exists('apiEmpty')) {

    function apiEmpty($status = 200)
    {
        return response(null, $status);
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

    function appUrl(string $subdomain, ?string $path = null, ?mixed $query = null)
    {
        $protocol = $secure ? 'https' : 'http';

        $domain = config('app.url_domain');
        $domain = "{$subdomain}.{$domain}";

        if (!empty($path)) {
            $path = '/' . ltrim($path, '/');
        }

        if (!empty($query)) {
            $query = '?' . http_build_query($query);
        }

        return "{$protocol}://{$domain}{$path}{$query}";
    }
}