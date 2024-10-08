<?php
/**
 * Utilities for debugging 
 *
 * It provides methods for debugging
 *
 * Filename:        Utilities.php
 * Location:        session-05
 * Project:         LAS-PHP-MVC-Jokes
 * Date Created:    13/08/2024
 *
 * Author:          Luis Alvarez Suarez <20114831@tafe.wa.edu.au>
 *
 */

class Utilities
{
    public static function dump(): void
    {
        echo "<pre class='bg-gray-100 color-black m-2 p-2 rounded shadow flex-grow text-sm'>";
        array_map(function ($x) {
            var_dump($x);
        }, func_get_args());
        echo "</pre>";
    }

    public static function dd(): void
    {
        echo "<pre class='bg-gray-100 color-black m-2 p-2 rounded shadow flex-grow text-sm'>";
        array_map(function ($x) {
            var_dump($x);
        }, func_get_args());
        echo "</pre>";
        die();
    }
}


