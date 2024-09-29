<?php
/**
 * Home Page View for unauthenticated users
 *
 * Filename:        home.view.php
 * Location:        /App/views/staticPages
 * Project:         LAS-PHP-MVC-Jokes
 * Date Created:    27/08/2024
 *
 * Author:          Luis Alvarez<20114831@tafe.wa.edu.au>
 *
 */

loadPartial('header');
loadPartial('navigation');

?>

<main class="container mx-auto bg-zinc-50 py-8 px-4 shadow shadow-black/25 rounded-b-lg">
    <article>
        <header class="bg-zinc-700 text-zinc-200 -mx-4 -mt-8 p-8 text-2xl font-bold mb-8">
            <h1>Welcome Visitor</h1>
        </header>
        

        <section class="my-8 flex flex-wrap gap-8 justify-center">

            <?php
           
            if (!empty($jokes)):
            foreach ($jokes as $joke):
                ?>
                <article class="max-w-96 min-w-64 bg-white shadow rounded p-2 flex flex-col">
                    <header class="-mx-2 bg-zinc-700 text-zinc-200 text-lg p-4 -mt-2 mb-4 rounded-t flex-0">
                        <h4>
                            <?= $joke->joke ?>
                        </h4>
                    </header>
                </article>

            <?php
            endforeach;
            else:
            ?>
            <article class="max-w-96 min-w-64 bg-white shadow rounded p-2 flex flex-col text-center text-xl">
                    <h4>
                        Sorry, no joke this time.
                    </h4>
            </article>
            <?php
            endif;
            ?>
            <form action="/" method="GET">
            <button class="w-full md:w-auto
                           bg-sky-500 hover:bg-sky-600
                           text-black
                           px-4 py-2
                           focus:outline-none transition ease-in-out duration-500">
                <i class="fa fa-search"></i> New Joke
            </button>
            </form>
        </section>

      

    </article>
</main>


<?php
loadPartial('footer');
?>
