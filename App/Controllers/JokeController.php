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

use Framework\Authorisation;
use Framework\Middleware\Authorise;
use Framework\Session;
use Framework\Database;
use Framework\Validation;
use App\Controllers\CategoryController;
use Parsedown;



class JokeController
{

    protected $db;

    public function __construct()
    {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }


    /**
     *Get jokes and convert them from Markdown to HTML.
     * @return void
     */

    public function index()
    {
        $sql = "SELECT *  FROM jokes";
        $jokes = $this->db->query($sql)->fetchAll();

        $parsedown = new Parsedown();

        foreach ($jokes as $joke) {

            $joke->joke = $parsedown->text($joke->joke);
        }

        loadView('/jokes/index', [
            'jokes' => $jokes
        ]);
    }


    /**
     * Get a random joke
     *
     * @return array
     */

    public function randomJoke()
    {
        //Fetching a random joke
        //https://www.geeksforgeeks.org/how-to-select-random-row-in-mysql/
        $sql = "SELECT * FROM jokes ORDER BY RAND() LIMIT 1";

        $jokes = $this->db->query($sql)->fetchAll();


        return $jokes[0];
    }



    /**
     * Get  number of jokes
     *
     * @return int
     */

    public function numberJokes()
    {

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

        /*If user is authenticted we redirect to private search
        otherwise we go to public search*/
        $authenticated = new Authorise();
        if ($authenticated->isAuthenticated()) {

            loadView('/jokes/index', [
                'jokes' => $jokes,
                'keywords' => $keywords,
            ]);
        } else {
            loadView('/jokes/search', [
                'jokes' => $jokes,
                'keywords' => $keywords,
            ]);
        }
    }


    /**
     * Show a single joke
     *
     * @param array $params
     * @return void
     */
    public function show($params)
    {
        $id = $params['id'] ?? '';

        $params = [
            'id' => $id
        ];


        $sql = "SELECT jokes.id,jokes.joke AS title, 
               categories.name AS category, 
               jokes.tags, 
               CONCAT(users.given_name, ' ', users.family_name) AS author,
               author_id
        FROM jokes
        INNER JOIN categories ON jokes.category_id = categories.id
        INNER JOIN users ON jokes.author_id = users.id
        WHERE jokes.id = :id;";

        $joke = $this->db->query($sql, $params)->fetch();

        // Check if user exists
        if (!$joke) {
            ErrorController::notFound('Joke not found');
            return;
        }


        $parsedown = new Parsedown();

        $joke->title = $parsedown->text($joke->title);

        loadView('jokes/show', [
            'joke' => $joke
        ]);
    }

    /**
     * Displays create form
     *
     * @return void
     */
    public function create()
    {

        //Fetching categories to populate select on create view
        //fetching number of jokes
        $category = new CategoryController();
        $categories = $category->getCategories();

        //Fecthing jokes
        $sql = "SELECT *  FROM jokes";
        $jokes = $this->db->query($sql)->fetchAll();


        loadView('jokes/create', [
            'categories' => $categories,
            'jokes' => $jokes
        ]);
    }



    /**
     * Store data in database
     *
     * @return void
     */
    public function store()
    {
        var_dump($_POST['joke']);
        $allowedFields = ['joke', 'category_id', 'tags', 'author_id'];

        $newJokeData = array_intersect_key($_POST, array_flip($allowedFields));
        //$newJokeData['user_id'] = Session::get('user')['id'];
        $newJokeData = array_map('sanitize', $newJokeData);


        $requiredFields = ['joke', 'category_id', 'tags', 'author_id'];

        $errors = [];

        foreach ($requiredFields as $field) {
            if (empty($newJokeData[$field]) || !Validation::string($newJokeData[$field])) {
                $errors[$field] = ucfirst(str_replace("_", " ", $field)) . ' <em>is required</em>';
            }
        }

        if (!empty($errors)) {
            // Reload view with errors
            loadView('jokes/create', [
                'errors' => $errors,
                'user' => $newJokeData
            ]);
            exit();
        }




        // Save the submitted data
        $fields = [];

        foreach ($newJokeData as $field => $value) {
            $fields[] = $field;
        }

        $fields = implode(', ', $fields);
        $values = [];


        foreach ($newJokeData as $field => $value) {
            // Convert empty strings to null
            if ($value === '') {
                $newJokeData[$field] = null;
            }
            $values[] = ':' . $field;
        }


        $values = implode(', ', $values);

        $insertQuery = "INSERT INTO jokes({$fields}) VALUES ({$values})";

        $this->db->query($insertQuery, $newJokeData);

        Session::setFlashMessage('success_message', 'Joke created successfully');

        redirect('/jokes');
    }



    /**
     * Show the joke edit form
     *
     * @param array $params
     * @return null
     * @throws \Exception
     */
    public function edit($params): null
    {
        $id = $params['id'] ?? '';

        $params = [
            'id' => $id
        ];

        $joke = $this->db->query('SELECT * FROM jokes WHERE id = :id', $params)->fetch();

        // Check if user exists
        if (!$joke) {
            ErrorController::notFound('Joke not found');
            exit();
        }

        // Authorisation
        if (!Authorisation::isOwner($joke->author_id) && !Authorisation::isUser(Session::get('user')['id'])) {
            Session::setFlashMessage(
                'error_message',
                'You are not authorized to update this Joke'
            );
            return redirect('/jokes/' . $joke->id);
        }

        $category = new CategoryController();
        $categories = $category->getCategories();




        loadView('jokes/edit', [
            'joke' => $joke,
            'categories' => $categories
        ]);
    }


    /**
     * Update a jpke
     *
     * @param array $params
     * @return null
     */
    public function update($params): null
    {
        var_dump($_POST);
        $id = $params['id'] ?? '';

        $params = [
            'id' => $id
        ];

        $joke = $this->db->query('SELECT * FROM jokes WHERE id = :id', $params)->fetch();

        // Check if user exists
        if (!$joke) {
            ErrorController::notFound('Joke not found');
            exit();
        }

        // Authorisation
        if (!Authorisation::isOwner($joke->author_id) && !Authorisation::isUser(Session::get('user')['id'])) {
            Session::setFlashMessage(
                'error_message',
                'You are not authorised to update this user'
            );
            return redirect('/jokes/' . $joke->id);
        }

        $allowedFields = ['joke', 'category_id', 'tags', 'author_id'];


        $updateValues = array_intersect_key($_POST, array_flip($allowedFields)) ?? [];

        $updateValues = array_map('sanitize', $updateValues);

        $parsedown = new Parsedown();

        //$updateValues['joke'] = $parsedown->text($updateValues['joke']);




        $requiredFields = ['joke', 'category_id', 'tags', 'author_id'];

        $errors = [];

        foreach ($requiredFields as $field) {
            if (empty($updateValues[$field]) || !Validation::string($updateValues[$field])) {
                $errors[$field] = ucfirst($field) . ' is required';
            }
        }



        if (!empty($errors)) {
            loadView('jokes/edit', [
                'joke' => $joke,
                'errors' => $errors
            ]);
            exit();
        }

        // Submit to database
        $updateFields = [];



        $updateValues['updated_at'] = date('Y-m-d H:i:s');

        foreach (array_keys($updateValues) as $field) {
            $updateFields[] = "{$field} = :{$field}";
        }

        $updateFields = implode(', ', $updateFields);

        $updateQuery = "UPDATE jokes SET $updateFields WHERE id = :id";

        $updateValues['id'] = $id;
        $this->db->query($updateQuery, $updateValues);

        // Set flash message
        Session::setFlashMessage('success_message', 'Joke updated');

        redirect('/jokes/' . $id);
    }


    /**
     * Delete a joke
     *
     * @param array $params
     * @return void|null
     * @throws \Exception
     */
    public function destroy($params)
    {
        $id = $params['id'];

        $params = [
            'id' => $id
        ];

        $joke = $this->db->query('SELECT * FROM jokes WHERE id = :id', $params)->fetch();

        // Check if user exists
        if (!$joke) {
            ErrorController::notFound('Joke not found');
            exit();
        }

        // Authorisation
        if (!Authorisation::isOwner($joke->author_id)) {
            Session::setFlashMessage('error_message', 'You are not authoirzed to delete this Joke');
            return redirect('/jokes/' . $joke->id);
        }

        $this->db->query('DELETE FROM jokes WHERE id = :id', $params);

        // Set flash message
        Session::setFlashMessage('success_message', 'Joke deleted successfully');

        redirect('/jokes');
    }
}
