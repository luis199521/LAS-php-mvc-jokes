<?php
/**
 * Category Management Controller
 *
 * Filename:        CategoryController.php
 * Location:        /App/Controllers
 * Project:         LAS-mvc-jokes
 * Date Created:    06/10/2024
 *
 * Author:          Luis Alvarez Suarez<20114831@tafe.wa.edu.au>
 *
 */

namespace App\Controllers;

use Framework\Database;


class CategoryController
{

    protected $db;

    public function __construct()
    {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }

    
    /**
     * Get all categories to create a dropdown list with this
     * https://www.geeksforgeeks.org/create-a-drop-down-list-that-options-fetched-from-a-mysql-database-in-php/
     *
     * @return void
     */

     public function getCategories()
     {
         //Fetching categories
         $sql = "SELECT * FROM categories";
         $categories = $this->db->query($sql)->fetchAll();
         return $categories;

     }
 
}

