<?php
if (!function_exists('dd')) {
	function dd ($value)
    {
        echo "<pre>";
        print_r ($value);
        echo "</pre>";
        die();
    }
}