<?php
/**
 * Authorisation Class
 *
 * It manages user ownership for resource access
 * Filename:        Authorisation.php
 * Location:        Framework/
 * Project:         LAS-PHP-MVC-Jokes
 * Date Created:    23/08/2024
 *
 * Author:          Luis Alvarez Suarez <20114831@tafe.wa.edu.au>
 *
 */

namespace Framework;

class Authorisation
{
    /**
     * Check if current logged-in user owns a resource
     *
     * @param int $resourceId
     * @return bool
     */
    public static function isOwner(int $resourceId): bool
    {
        $sessionUser = Session::get('user');

        if ($sessionUser !== null && isset($sessionUser['id'])) {
            $sessionUserId = (int)$sessionUser['id'];
            return $sessionUserId === $resourceId;
        }

        return false;
    }


    /**
     * Check if current logged-in is the user being requested
     *
     * @param int $resourceId
     * @return bool
     */
    public static function isUser(int $resourceId): bool
    {
        $sessionUser = Session::get('user');

        if ($sessionUser !== null && isset($sessionUser['id'])) {
            $sessionUserId = (int)$sessionUser['id'];
            return $sessionUserId === $resourceId;
        }

        return false;
    }
}