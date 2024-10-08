<?php
/**
 * Header template - (HTML 'head')
 *
 * Filename:        header.view.php
 * Location:        App/views/partials
 * Project:         SaaS-FED-Notes
 * Date Created:    DD/MM/YYYY
 *
 * Author:          YOUR NAME <STUDENT_ID@tafe.wa.edu.au>
 *
 */
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $pageTitle ?? "Joker" ?></title>
    <link rel="stylesheet" href="/assets/css/site.css">
        <!-- SimpleMDE CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
    <!-- SimpleMDE JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
    

</head>
<body class="bg-zinc-800 flex flex-col h-screen justify-between">

