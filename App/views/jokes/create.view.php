<?php

/**
 * Create Joke view
 *
 * Displays a Registration Form for new jokes
 * 
 * 
 *
 * Filename:        create.view.php
 * Location:        App/View/jokes
 * Project:         LAS-PHP-MVC-Jokes
 * Date Created:    05/10/2024
 *
 * Author:          Luis Alvarez<20114831@tafe.wa.edu.au>
 *
 */

use Framework\Session;

$pageTitle = "Add | Jokes | LAS-MVC-Jokes";

loadPartial("header", ["pageTitle" => $pageTitle]);
loadPartial('navigation');

?>

<main class="container mx-auto bg-zinc-50 py-8 px-4 shadow shadow-black/25 rounded-b-lg flex flex-col flex-grow">
    <article>
        <header class="bg-zinc-700 text-zinc-200 -mx-4 -mt-8 p-8 mb-8 flex">
            <h1 class="grow text-2xl font-bold ">Jokes - Add</h1>
            <p class="text-md flex-0 px-8 py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded transition ease-in-out duration-500">
                <a href="/jokes/create">Add Joke</a>
            </p>
        </header>

        <section>

            <?= loadPartial('errors', [
                'errors' => $errors ?? []
            ]) ?>



            <form method="POST" action="/jokes" id="jokeCreateForm" novalidate>

                <h2 class="text-2xl font-bold mb-6 text-left text-gray-500">
                    Jokes Information
                </h2>

                <section class="mb-4">
                    <label for="joke" class="mt-4 pb-1">Joke's title</label>
                    <textarea id="joke"
                        name="joke" placeholder="joke"
                        class="w-full px-4 py-2 border border-b-zinc-300 rounded focus:outline-none"
                        required></textarea>
                </section>
                <label for="category_id">Choose a category</label>
                <!--Create a drop-down list with $categories https://www.geeksforgeeks.org/create-a-drop-down-list-that-options-fetched-from-a-mysql-database-in-php/-->
                <select id="category_id" name="category_id" class="w-full px-4 py-2 border rounded focus:outline-none" required>
                    <option value="">Select a category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category->id ?>">
                            <?= $category->name ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <section class="mb-4">
                    <label for="tags" class="mt-4 pb-1">tags:</label>
                    <input type="text" id="tags"
                        name="tags" placeholder="tags"
                        class="w-full px-4 py-2 border border-b-zinc-300 rounded focus:outline-none"
                        value="<?= $joke['tags'] ?? '' ?>" required />
                </section>

                <section class="mb-4">
                    <label for="author_id" class="mt-4 pb-1">Author:</label>
                    <input type="text" id="author_id"
                        name="author_id" placeholder="author"
                        class="w-full px-4 py-2 border border-b-zinc-300 rounded focus:outline-none"
                        value="<?= Session::get('user')['id'] ?? '' ?>" required />
                </section>

                <button type="submit"
                    class="w-full bg-green-500 hover:bg-green-600 text-white px-4 py-2 my-3
                               rounded focus:outline-none">
                    Save
                </button>

                <a href="/jokes"
                    class="block text-center w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded
                      focus:outline-none">
                    Cancel
                </a>

            </form>

        </section>

    </article>
</main>


<script>
    document.addEventListener("DOMContentLoaded", function() {


        // Initialize SimpleMDE
        var simplemde = new SimpleMDE({
            element: document.getElementById("joke"),
            spellChecker: false,
            autofocus: true,
            autosave: {
                enabled: true,
                uniqueId: "joke",
                delay: 1000,
            },
        });

        // Handle form submission
        document.getElementById('jokeCreateForm').addEventListener('submit', function(event) {
            event.preventDefault();
            var jokeMarkdown = simplemde.value();
            // Here you would typically send the jokeMarkdown to your server via AJAX
            console.log(jokeMarkdown);
            var formData = new FormData(this);
            formData.set('joke', jokeMarkdown);
            $.ajax({
                url: '/jokes',
                type: 'POST',
                // https://stackoverflow.com/questions/25390598/append-called-on-an-object-that-does-not-implement-interface-formdata
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    alert('Joke saved successfully');
                },
                error: function(xhr, status, error) {
                    alert('Error saving joke:', error);
                }
            });

        });

    });
</script>



<?php
loadPartial("footer");
