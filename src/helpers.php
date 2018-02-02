<?php

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