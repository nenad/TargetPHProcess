<?php
function substr_startswith($haystack, $needle) {
    return substr($haystack, 0, strlen($needle)) === $needle;
}

function preg_match_startswith($haystack, $needle) {
    return preg_match('~'.preg_quote($needle,'~').'~A', $haystack) > 0;
}

function substr_compare_startswith($haystack, $needle) {
    return substr_compare($haystack, $needle, 0, strlen($needle)) === 0;
}

function strpos_startswith($haystack, $needle) {
    return strpos($haystack, $needle) === 0;
}

function strncmp_startswith($haystack, $needle) {
    return strncmp($haystack, $needle, strlen($needle)) === 0;
}

function strncmp_startswith2($haystack, $needle) {
    return $haystack[0] === $needle[0]
        ? strncmp($haystack, $needle, strlen($needle)) === 0
        : false;
}
