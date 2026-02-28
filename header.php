<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?> <!-- Appel des fonctions Wordpress -->
</head>

<body>
    <header>

        <button class="menu-burger" aria-label="Ouvrir le menu">
            <i class="<?php echo esc_html(get_theme_mod('logo_menu_burger', 'fa-solid fa-bars fa-2xl')); ?>"></i>
            <i class="<?php echo esc_html(get_theme_mod('logo_fermeture_menu', 'fa-solid fa-xmark fa-2xl')); ?>"></i>
        </button>


        <div class="portfolio-container">
            <a href="<?php echo home_url(); ?>" class="titre-site">
                <!--bloginfo c'est la fonction qui permet d'afficher le titre du site-->
                <?php bloginfo('name'); ?>
            </a>
            <div class="photo-profil">
                <?php the_custom_logo();     ?>
            </div>
        </div>



        <?php wp_nav_menu(array(
            //dis de placer le menu de navigation à l'emplacement menu-navigation
            'theme_location' => 'menu-navigation',
            //dis de ne pas ajouter de div dans le menu nav
            'container' => false,
            //ajoute la class menu-liste au <ul class=menu-liste">
            'menu_class' => "menu-liste"
        )); ?>

        <div class="download">
            <a href="<?php echo esc_url(get_theme_mod('fichier_cv', get_template_directory_uri() . '/assets/cv-pierre-soreau.pdf')) ?>" class="download-cv" target="_blank">
                <!--esc_html évite de l'injection de code dans le champ, get theme mod permet d'afficher ce que l'utilisateur a mis dans la case-->
                <?php echo esc_html(get_theme_mod('texte_bouton_cv', 'Télécharger mon CV')); ?>
            </a>
        </div>
    </header>