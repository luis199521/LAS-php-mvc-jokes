<?php
/**
 * Search Joke View
 *
 * Display jokes when user uses the search box
 *
 * Filename:        search.view.php
 * Location:        Views/Jokes
 * Project:         LAS-PHP-MVC-Jokes
 * Date Created:    29/09/2024
 *
 * Author:          Luis Alvarez <20114831@tafe.wa.edu.au>
 *
 */

/* Load HTML header and navigation areas */
$pageTitle = "Serch Jokes | LAS-MVC-Jokes";

loadPartial("header", ["pageTitle"=>$pageTitle]);loadPartial('navigation');

?>

<main class="container mx-auto bg-zinc-50 py-8 px-4 shadow shadow-black/25 rounded-b-lg flex flex-col flex-grow">
    <article>
        <header class="bg-sky-500 text-zinc-200 -mx-4 -mt-8 p-8 mb-8 flex">
            <h1 class="grow text-2xl font-bold ">Results</h1>
        </header>

        <section class="text-xl text-zinc-500 my-8">
            <?php if (isset($keywords) && $keywords>"") : ?>
                <p>Search Results for: <?= htmlspecialchars($keywords) ?> [<?= count($jokes ?? []) ?> Jokes(s) found]</p>
              
                <?php foreach ($jokes as $joke): ?>
            <p><?= ('Joke:   '. $joke->joke) ?></p>
            <p><?= ('Tag:    ' . $joke->tags) ?></p>     
        <?php endforeach; ?>
            <?php else : ?>
                <p>All Jokes</p>
            <?php endif; ?>

            <?= loadPartial('message') ?>
        </section>

        <section class="flex flex-col gap-8 ">
            <?php
            foreach ($users ?? [] as $user):
                ?>
                <!--            article>(header>h4{Name})+(section>p{Description})+(footer>p{Price})-->
                <article class="w-full bg-white shadow rounded grid grid-cols-12">
                    <header class="col-span-4 bg-zinc-700 text-zinc-200 text-lg p-4 rounded-l flex-0">
                        <h4>
                            <?= $user->given_name ?> <?= $user->family_name ?>
                        </h4>
                    </header>
                    <section class="col-span-6 flex flex-row py-4 gap-4 text-zinc-600 justify-items-start">
                        <p class="mr-4 -my-4">
                            <img class="w-16 h-16 " src="https://dummyimage.com/200x200/c11111/fff&text=Image+Here"
                                 alt="Avatar for <?= $user->given_name ?> <?= $user->family_name ?>">
                        </p>
                        <p class="align-middle">Added: <?= $user->created_at ?></p>
                        <p class="align-middle">Last Update: <?= $user->updated_at ?? 'n/a' ?></p>
                    </section>
                    <a href="/users/<?= $user->id ?>"
                       class="col-span-2 text-center text-zinc-900 font-medium
                        bg-zinc-200 hover:bg-zinc-300 block
                        py-4 rounded-r
                        transition ease-in-out duration-500">
                        Details...
                    </a>
                </article>
            <?php
            endforeach
            ?>
        </section>

    </article>
</main>


<?php
loadPartial("footer");

