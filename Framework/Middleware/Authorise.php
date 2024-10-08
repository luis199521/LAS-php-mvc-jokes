<?php
/**
 * Authorise Middleware
 *
 * It manages user authentication and authorization for requests
 *
 * Filename:        Authorise.php
 * Location:        Framework/Middleware
 * Project:         LAS-PHP-MVC-Jokes
 * Date Created:    23/08/2024
 *
 * Author:          Luis Alvarez Suarez <20114831@tafe.wa.edu.au>
 *
 */

namespace Framework\Middleware;

use Framework\Session;

class Authorise
{
    /**
     * Handle the user's request
     *
     * @param string $role
     * @return bool
     */
    public function handle($role)
    {
                if ($role === 'guest' && $this->isAuthenticated()) {
                    return redirect('/');
                }

                if ($role === 'auth' && !$this->isAuthenticated()) {
                    return redirect('/auth/login');
                }
            }

    /**
     * Check if user is authenticated
     *
     * @return bool
     */
    public function isAuthenticated()
    {
        return Session::has('user');
    }
}