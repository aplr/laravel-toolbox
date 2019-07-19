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

if (! function_exists('str_random_safe')) {

    /**
     * Creates a random string which does not
     * contain vowels to avoid creating words.
     *
     * @param int $length
     * @return string
     */
    function str_random_safe(int $length)
    {
        $alphabet = "bcdfghjklmnpqrstvwxyz0123456789";
        $random = "";

        while (strlen($random) < $length) {
            $rand = random_int(0, strlen($alphabet) - 1);
            $random .= $alphabet[$rand];
        }

        return $random;
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

    function apiEmpty($status = 204)
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

if (! function_exists('appDomain')) {

    function appDomain(string $name)
    {
        $domain = config('app.url_domain');

        $prefixes = config('app.url_prefixes');

        if (!empty($subdomain = $prefixes[$name])) {
            return "{$subdomain}.{$domain}";
        }

        return $domain;
    }

}

if (! function_exists('appUrl')) {

    function appUrl(string $name, ?string $path = null, $query = null)
    {
        $protocol = config('app.secure') ? 'https' : 'http';

        $domain = appDomain($name);

        $queryString = null;

        if (!empty($path)) {
            $path = '/' . ltrim($path, '/');
        }

        if (is_array($query)) {
            $queryString = '?' . http_build_query($query);
        }

        if (is_string($query)) {
            $queryString = '?' . $query;
        }

        return "{$protocol}://{$domain}{$path}{$queryString}";
    }
}

if (! function_exists('uniq')) {

    function uniq(int $length = 10)
    {
        return app('uniq')->generate($length);
    }
}

if (! function_exists('sanitize_markdown')) {

    function sanitize_markdown(string $text)
    {
        return preg_replace("/(#.+)(\R|\R{2,})(.+)/", "$1\n\n$3", $text);
    }
}

if (! function_exists('validate_username')) {

    function validate_username(string $username)
    {
        return !collect(config('toolbox.username_blacklist'))->contains($username);
    }
}

if (! function_exists('properize')) {

    function properize(string $string)
    {
        return "{$string}'" . (ends_with($string, 's') ? '' : 's');
    }
}
