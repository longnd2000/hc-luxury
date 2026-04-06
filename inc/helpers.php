<?php

/**
 * Debug Helpers
 *
 * @package Child_Theme
 */

/**
 * Write debug log to wp-content/debug.log.
 *
 * Usage:
 *   write_log($variable);
 *   write_log($array, 'My Label');
 *
 * @param mixed  $log   Value to log (string, array, object).
 * @param string $title Label prefix in the log line.
 */
function write_log($log = null, $title = 'Debug')
{
    if ($log) {
        if (is_array($log) || is_object($log)) {
            $log = print_r($log, true);
        }

        $timestamp = date('Y-m-d H:i:s');
        $text = '[' . $timestamp . '] : ' . $title . ' - Log: ' . $log . "\n";
        $log_file = WP_CONTENT_DIR . '/debug.log';
        $file_handle = fopen($log_file, 'a');
        fwrite($file_handle, $text);
        fclose($file_handle);
    }
}
