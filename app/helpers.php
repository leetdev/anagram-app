<?php

/**
 * Sort a UTF-8 string by characters.
 *
 * @param string $str
 *
 * @return string
 */
function sort_string(string $str): string {
    $characters = mb_str_split($str, 1, 'UTF-8');
    sort($characters, SORT_STRING);
    return join($characters);
}
