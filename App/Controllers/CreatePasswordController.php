<?php
/**
 * CreatePasswordController
 *
 * It manages passwords creation.
 *
 * Filename:        CreatePasswordController.php
 * Location:        App/Controllers
 * Project:         LAS-PHP-MVC-Jokes
 * Date Created:    08/10/2024
 *
 * Author:          Luis Alvarez Suarez <20114831@tafe.wa.edu.au>
 *
 */

namespace App\Controllers;


use Framework\Database;
use Framework\Validation;

class CreatePasswordController
{
    protected $db;

    public function __construct()
    {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }

    /*
     * Show the latest jokes
     *
     * @return void
     */
    public function index()
    {

        if (!isset($_POST['password']))        {
            loadView('create-password', [
            ]);

        } else {
            $password = trim($_POST['password']);

            $errors = [];

            // Validation
            if (!Validation::string($password, 6, 255)) {
                $errors['password'] = 'Password must be at least 6 characters';
            }

            // Check for errors
            if (!empty($errors)) {
                loadView('create-password', [
                    'errors' => $errors,
                    'password' => $password,

                ]);
                exit;
            }

            $hashOptions = [
                'cost' => 12,
            ];
            $passwordHash = password_hash($password, PASSWORD_BCRYPT, $hashOptions);

            loadView('create-password', [
                'password' => $password,
                'passwordHash' => $passwordHash,
            ]);
        }
    }
}