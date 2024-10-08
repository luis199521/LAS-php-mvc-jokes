<?php
/**
 * FILE TITLE GOES HERE
 *
 * It manages 404 and 403 Error responses.
 *
 * Filename:        ErrorController.php
 * Location:        App/Controllers
 * Project:         LAS-PHP-MVC-Jokes
 * Date Created:    08/10/2024
 *
 * Author:          Luis Alvarez Suarez <20114831@tafe.wa.edu.au>
 *
 */

namespace App\Controllers;

class ErrorController
{
    /*
       * 404 not found error
       *
       * @return void
       */
    public static function notFound($message = 'Resource not found')
    {
        http_response_code(404);

        loadView('error', [
            'status' => '404',
            'message' => $message
        ]);
    }

    /*
     * 403 unauthorized error
     *
     * @return void
     */
    public static function unauthorized($message = 'You are not authorized to view this resource')
    {
        http_response_code(403);

        loadView('error', [
            'status' => '403',
            'message' => $message
        ]);
    }
}