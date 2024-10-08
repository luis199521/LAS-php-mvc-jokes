<?php
/**
 * Static Pages Managment
 *
 * Provides access to static pages such as home, contact and about pages.
 *
 * Filename:        StaticPageController.php
 * Location:        App/Controllers
 * Project:         LAS-PHP-MVC-Jokes
 * Date Created:    27/09/2024
 *
 * Author:          Luis Alvarez Suarez <20114831@tafe.wa.edu.au>
 *
 */

namespace App\Controllers;


use Framework\Database;
use App\Controllers\JokeController;
use App\Controllers\UserController;
use Parsedown;

class StaticPageController
{
    protected $db;

    public function __construct()
    {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }

    /*
     * Show the home page
     *
     * @return void
     */
    public function index()
    {
        //Fetching a random joke
        $sql = "SELECT * FROM jokes ORDER BY RAND() LIMIT 1";

        $jokes = $this->db->query($sql)->fetchAll();


        $parsedown = new Parsedown();

        foreach ($jokes as $joke) {

            $joke->joke = $parsedown->text($joke->joke);
        }

      

        loadView('staticPages/home', [
            'jokes' => $jokes
        ]);
        
       
    }


    /*
     * Show the home static page when user logs in,  statistics  of number of users and jokes can be seen.
     *
     * @return void
     */
    public function home()
    {

        //fetching number of jokes
        $jokes = new JokeController();
        
        $countJokes = $jokes->numberJokes();

        //fetching number of users
        $users = new UserController();
        
        $countUsers = $users->numberUsers();

         loadView('/home', [
            'totalJokes' => $countJokes,
            'totalUsers'=> $countUsers
        ]);
        
    }



    /*
     * Show the about static page
     *
     * @return void
     */
    public function about()
    {
        loadView('staticPages/about');
        
    }
}