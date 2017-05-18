<?php
/**
 * Created by PhpStorm.
 * User: ace
 * Date: 17/05/18
 * Time: 15:16
 */


// argv index
define( 'ARG_INDEX_PHP', 0 );
define( 'ARG_INDEX_CONFIG', 1 );
define( 'ARG_INDEX_CSV', 2 );

if ( isset($argc) && isset($argv) ) {
    main($argv);
}
exit;

/**
 * Program main
 * @param $argv
 */
function main($argv) {
    try {

    } catch( Exception $e) {
        var_dump($e);
    }

}


function encShiftJISToUtf8($str) {
    return mb_convert_encoding($str, 'UTF-8', 'sjis');
}

function encUtf8ToShiftJIS($str) {
    return mb_convert_encoding($str, 'sjis', 'UTF-8');
}