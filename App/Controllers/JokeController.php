<?php
/**
 * Joke Management Controller
 *
 * Filename:        JokeController.php
 * Location:        /App/Controllers
 * Project:         LAS-mvc-jokes
 * Date Created:    29/09/2024
 *
 * Author:          Luis Alvarez <20114831@tafe.wa.edu.au>
 *
 */

namespace App\Controllers;
use Framework\Database;

class JokeController
{

    protected $db;

    public function __construct()
    {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }

    // TODO: Create the index method
    public function index()
    {
        //Fetching a random joke
        $sql = "SELECT * FROM jokes ORDER BY RAND() LIMIT 1";

        $jokes = $this->db->query($sql)->fetchAll();


        loadView('staticPages/home', [
            'joke' => $jokes
        ]);
    }


/**
 * Get  number of jokes
 *
 * @return int
 */

 public function numberJokes(){

    //Fetching all Jokes from DB
    $sql = "SELECT COUNT(*) as totalJokes FROM jokes";
    $jokes = $this->db->query($sql)->fetchAll();
    /*In order to have access to the number of jokes, we have to access the firs position of the array $jokes[0], 
    There we have total*/
  return $jokes[0]->totalJokes;
  
 }



    /**
     * Search Jokes by keywords such as joke's name and tags
     *
     * @return void
     */
    public function search()
    {
        $keywords = isset($_GET['keywords']) ? trim($_GET['keywords']) : '';

        $query = "SELECT * FROM jokes 
                  WHERE joke LIKE :keywords 
                     OR tags LIKE :keywords 
                  ORDER BY joke, tags ";

        $params = [
            'keywords' => "%{$keywords}%",
        ];
        //This is returning an array of objects
        $jokes = $this->db->query($query, $params)->fetchAll();

        loadView('/jokes/search', [
            'jokes' => $jokes,
            'keywords' => $keywords,
        ]);
    }





   
    // TODO: Create the index method
    // TODO: Create the show method
    // TODO: Create the create method
    // TODO: Create the store
    // TODO: Create the edit
    // TODO: Create the update
    // TODO: Create the destroy method
}