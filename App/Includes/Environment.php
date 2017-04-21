<?php
/* ------------------------------------------------------ *\
 |                      ENVIRONMENT                       |
\* ------------------------------------------------------ */

/**
 * Get Web Server Type
 *
 * @return bool|string
 */
function getWebServerSoftWare()
{
    static $type;

    if (isset($type)) {
        return $type;
    }

    $software = isset($_SERVER['SERVER_SOFTWARE'])
        ? $_SERVER['SERVER_SOFTWARE']
        : null;

    $type = false;

    if (stripos($software, 'lighttpd') !== false) {
        $type = LIGHTTPD_SERVER;
    }

    if (strpos($software, 'Hiawatha') !== false) {
        $type = HIAWATHA_SERVER;
    }

    if (strpos($software, 'Apache') !== false) {
        $type = APACHE_SERVER;
    } elseif (strpos($software, 'Litespeed') !== false) {
        $type = LITESPEED_SERVER;
    }

    if (strpos($software, 'nginx') !== false) {
        $type = NGINX_SERVER;
    }

    if ($type !== APACHE_SERVER && $type !== LITESPEED_SERVER
        && strpos($software, 'Microsoft-IIS') !== false
        && strpos($software, 'ExpressionDevServer') !== false
    ) {
        $type = IIS_SERVER;
        if (intval(substr($software, strpos($software, 'Microsoft-IIS/')+14)) >= 7) {
            $type =  IIS7_SERVER;
        }
    }

    if (! $type
        && (
            function_exists('apache_get_modules')
            || function_exists('apache_get_version')
        )
    ) {
        $type = APACHE_SERVER;
    }

    return $type;
}

/**
 * Check if apache Server Base
 *
 * @return bool
 */
function isApache()
{
    return in_array(getWebServerSoftWare(), [APACHE_SERVER, LITESPEED_SERVER]);
}

/**
 * Check if Litespeed Web Server Base
 *
 * @return bool
 */
function isLitespeed()
{
    return getWebServerSoftWare() === LIGHTTPD_SERVER;
}

/**
 * Check if Nginx Web Server Base
 *
 * @return bool
 */
function isNginx()
{
    return getWebServerSoftWare() === NGINX_SERVER;
}

/**
 * Check if Hiawatha Web Server Base
 *
 * @return bool
 */
function isHiawatha()
{
    return getWebServerSoftWare() === HIAWATHA_SERVER;
}

/**
 * Check if Hiawatha Web Server Base
 *
 * @return bool
 */
function isLighttpd()
{
    return getWebServerSoftWare() === LIGHTTPD_SERVER;
}

/**
 * Check if IIS Web Server Base
 *
 * @return bool
 */
function isIIS()
{
    return in_array(getWebServerSoftWare(), [IIS_SERVER, IIS7_SERVER]);
}

/**
 * Check if IIS7 Web Server Base
 *
 * @return bool
 */
function isIIS7()
{
    return getWebServerSoftWare() === IIS7_SERVER;
}

/**
 * Test if the current browser runs on a mobile device (smart phone, tablet, etc.)
 *
 * @return bool
 */
function isMobile() {
    if (empty($_SERVER['HTTP_USER_AGENT'])) {
        return false;
    }

    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    if ( strpos($userAgent, 'Mobile') !== false // many mobile devices (all iPhone, iPad, etc.)
        || strpos($userAgent, 'Android') !== false
        || strpos($userAgent, 'Silk/') !== false
        || strpos($userAgent, 'Kindle') !== false
        || strpos($userAgent, 'BlackBerry') !== false
        || strpos($userAgent, 'Opera Mini') !== false
        || strpos($userAgent, 'Opera Mobi') !== false
    ) {
        return true;
    }

    return false;
}