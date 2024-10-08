<?php

/**
 * Show Jokes view
 *
 * Shows details of an specific joke
 *
 * Filename:        index.view.php
 * Location:        Views/users/jokes
 * Project:         LAS-PHP-MVC-Jokes
 * Date Created:    30/09/2024
 *
 * Author:          Luis Alvarez<20114831@tafe.wa.edu.au>
 *
 */
use Framework\Session;

$pageTitle = "Show | Jokes | LAS-MVC-Jokes";

loadPartial("header", ["pageTitle" => $pageTitle]);
loadPartial('navigation');

?>

<main class="container mx-auto bg-zinc-50 py-8 px-4 shadow shadow-black/25 rounded-b-lg flex flex-col flex-grow">
    <article>
        <header class="bg-zinc-700 text-zinc-200 -mx-4 -mt-8 p-8 mb-8 flex">

            <h1 class="grow text-2xl font-bold ">Jokes - Detail</h1>

            <p class="text-md flex-0 px-8 py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded transition ease-in-out duration-500">
                <a href="/users/create">Add Jokes</a>
            </p>

            <form method="GET" action="/jokes/search" class="block mx-5">
                <input type="text" name="keywords" placeholder="User search..."
                    class="w-full md:w-auto px-4 py-2 focus:outline-none" />
                <button class="w-full md:w-auto
                           bg-sky-500 hover:bg-sky-600
                           text-white
                           px-4 py-2
                           focus:outline-none transition ease-in-out duration-500">
                    <i class="fa fa-search"></i> Search
                </button>
            </form>

        </header>

        <?= loadPartial('message') ?>

        <section class="w-1/2 mx-auto bg-white shadow rounded p-4 flex flex-col">

            

            <section class="flex-grow flex flex-row">

                <section class="grow">
                    <h5 class="text-lg font-bold">
                        Joke Title:
                    </h5>
                    <p class="grow text-lg text-zinc-600 mb-4">
                        <?= $joke->title ?>
                    </p>

                    <h5 class="text-lg font-bold">
                        Category:
                    </h5>
                    <p class="grow text-lg text-zinc-600 mb-4">
                        <?= $joke->category ?>
                    </p>

                    <h5 class="text-lg font-bold">
                        Tags:
                    </h5>
                    <p class="grow text-lg text-zinc-600 mb-4">
                        <?= $joke->tags ?>
                    </p>

                    <h5 class="text-lg font-bold">
                        Author:
                    </h5>
                    <p class="grow text-lg text-zinc-600 mb-4">
                        <?= $joke->author ?>
                    </p>

                    <?php
                   //var_dump($joke->author_id);
                   //var_dump(Session::get('user')['id']);
                         //current user is the owner of the joke                    current user ID in session 
                    if (Framework\Authorisation::isOwner($joke->author_id) && Framework\Authorisation::isUser(Session::get('user')['id'])) :
                    ?>
                        <form method="POST"
                            class="border-0 border-t-1 border-zinc-300 text-lg flex flex-row">
                            <a href="/jokes/edit/<?= $joke->id ?>"
                                class="px-16 py-2 bg-sky-500 hover:bg-sky-600 text-white rounded transition ease-in-out duration-500">
                                Edit
                            </a>

                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit"
                                class="ml-8 px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded transition ease-in-out duration-500">
                                Delete
                            </button>
                        </form>

                    <?php
                    endif;
                    ?>
                </section>

                <img class="object-cover"
                    src="https://dummyimage.com/200x200/a1a1aa/fff&text=Image+Here"
                    alt="">

            </section>




        </section>

    </article>
</main>


<?php
require_once basePath("App/views/partials/footer.view.php");
?>