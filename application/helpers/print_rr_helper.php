<?php
/**
 * Print a more web-friendly print_r() output.
 * 
 * @param mixed $content
 * @param bool $return
 * @return mixed
 */
function print_rr($content, $return=false) 
{
    $output = '<div style="border: 1px solid; overflow: auto; font-size: 13px;"><pre>' 
        . print_r($content, true) . '</pre></div>';

    if ($return) {
        return $output;
    } else {
        echo $output;
    }
}
?>