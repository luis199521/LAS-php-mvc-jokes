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
      

        loadView('staticPages/home', [
            'jokes' => $jokes
        ]);
        
        //loadView('staticPages/home');
       
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