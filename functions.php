<?php

add_action('after_setup_theme', 'portfoliopierresoreau_init');

// Appel de `flush_rewrite_rules` suite à l'activation du thème 
//ça permet d'effacer les règles des anciens thèmes activés

add_action('after_switch_theme', function () {
    flush_rewrite_rules();
});

//lorsque l'alarme wp_enqueue_scripts est déclenchée (elle est déclenchée via wp_head dans le header), on lance 
//la fonction register assets qui permet d'activer le style de la page
add_action('wp_enqueue_scripts', 'register_assets');

add_action('customize_register', 'portfoliopierresoreau_customizer');

add_action('after_setup_theme', 'forme_personnalise');

//Fonction qui permet de lancer les paramétrages basiques d'une page que l'on met habituellement dans le head en html 
//(ajout du titre de la page, ajout des menu ...)
function portfoliopierresoreau_init()
{
    //permet d'ajouter le titre de la page dans l'onglet du site 
    //pour le constituer wordpress va prendre le nom du site et le compléter par le nom de la page (ex:mon portfolio - accueil)
    add_theme_support('title-tag');

    // Active la possibilité de mettre un logo en manuel sans code sur wordpress 
    //en allant dans apparence personnaliser identité du site et en ajoutant un logo
    add_theme_support('custom-logo');

    // Crée l'emplacement pour le menu du header
    register_nav_menus(array(
        'menu-navigation' => 'Menu navigation du Portfolio',
    ));

    // 1. Autoriser l'éditeur de WordPress à utiliser du CSS personnalisé
    add_theme_support('editor-styles');

    // 2. Dire à l'éditeur d'aller chercher le fichier typo.css et style.css 
    //pour que je puisse voir l'effet des écritures sur le texte quand j'écris sur wordpress
    add_editor_style(array('assets/typo.css', 'style.css'));
}

//Fonction qui permet d'activer le css sur les pages, c'est le link en html classique
function register_assets()
{
    // Enregistrement des styles
    //Quand WordPress exécute la fonction get_template_directory_uri(), il la remplace par l'adresse web réelle.
    //Ce qu'il faut écrire en PHP :
    //get_template_directory_uri() . '/style.css'
    // Ce que WordPress génère pour le navigateur :
    //https://ton-site.local/wp-content/themes/portfolio/style.css
    wp_register_style('style', get_template_directory_uri() . '/style.css');
    wp_register_style('typo', get_template_directory_uri() . '/assets/typo.css');
    wp_register_style('page-qui-suis-je', get_template_directory_uri() . '/assets/qui-suis-je.css');
    wp_register_style('page-mes-projets', get_template_directory_uri() . '/assets/mes-projets.css');
    wp_register_style('page-contact', get_template_directory_uri() . '/assets/contact.css');

    // Envoi des styles et scripts
    //false veut dire envoit le script dans le head, array() 
    //et null veut dire pas de spécificité particulière 
    wp_enqueue_script('font-awesome', 'https://kit.fontawesome.com/22a319c99e.js', array(), null, false);
    wp_enqueue_style('devicon', "https://cdn.jsdelivr.net/gh/devicons/devicon@latest/devicon.min.css");

    //true veut dire que c'est dans le footer le script
    wp_enqueue_script('mon-script-js', get_template_directory_uri() . '/assets/script.js', array(), null, true);
    wp_enqueue_style('style');
    wp_enqueue_style('typo');


    if (is_page('qui-suis-je')) {
        wp_enqueue_style('page-qui-suis-je');
    } elseif (is_page('mes-projets')) {
        wp_enqueue_style('page-mes-projets');
    } elseif (is_page('contact')) {
        wp_enqueue_style('page-contact');
    }
}

function portfoliopierresoreau_customizer($wp_customize)
{
    //===========
    //HEADER
    //===========

    // 1. On crée une section "En-tête du site" dans l'administration
    $wp_customize->add_section('portfolio_header_section', array(
        //nom de l'onglet
        'title'    => 'En-tête du site (Header)',
        //position dans la liste des sections de l'onglet personnaliser de apparence->thèmes. 
        //PLus le chiffre est élevé plus il est bas dans la liste des onglets
        'priority' => 30,
    ));

    //CONTENU ECRIT BOUTON TELECHARGER CV

    // 2. On prépare la base de données pour sauvegarder le texte du BOUTON TELECHARGER CV
    $wp_customize->add_setting('texte_bouton_cv', array(
        //par défaut le texte marqué dans le a sera Telécharger mon CV
        'default'           => 'Télécharger mon CV', // Le texte par défaut
        //évite les injections de code dans le champ du texte donc indispensable
        'sanitize_callback' => 'sanitize_text_field',
    ));

    // 3. On crée la case pour écrire le texte dans l'interface
    $wp_customize->add_control('controle_texte_cv', array(
        //nom du champ
        'label'    => 'Texte du bouton d\'action',
        //on demande de ranger ce champ dans la section que l'on vient de créer 
        //(portfolio_header_section que l'on voit dans wordpress sous le nom en-tête du site)        
        'section'  => 'portfolio_header_section',
        //ajoute ce que l'utilisateur aura noté dans le champ à la zone dans la base de données "texte_bouton_cv"
        'settings' => 'texte_bouton_cv',
        // On précise que c'est un champ de texte
        'type'     => 'text',
    ));

    //LOGO BURGER

    //On prépare la base de données pour accueillir le contenu que l'on va renseigner pour le LOGO BURGER
    $wp_customize->add_setting('logo_menu_burger', array(
        'default'           => 'fa-solid fa-bars fa-2xl',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('controle_menu_burger', array(
        'label'    => 'Code de l\'icône Menu (Font Awesome)',
        'section'  => 'portfolio_header_section',
        'settings' => 'logo_menu_burger',
        'type'     => 'text',
    ));

    //LOGO FERMETURE MENU BURGER

    $wp_customize->add_setting('logo_fermeture_menu', array(
        'default'           => 'fa-solid fa-xmark fa-2xl',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('controle_fermeture_menu', array(
        'label'    => 'Code de l\'icône fermeture Menu (Font Awesome)',
        'section'  => 'portfolio_header_section',
        'settings' => 'logo_fermeture_menu',
        'type'     => 'text',
    ));

    //STOCKAGE DU CV

    // 1. Le réglage pour stocker l'URL du fichier
    $wp_customize->add_setting('fichier_cv', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    // 2. Le contrôle spécial "Upload de média"
    $wp_customize->add_control(new WP_Customize_Upload_Control($wp_customize, 'controle_cv', array(
        'label'    => 'Votre fichier CV (PDF)',
        'section'  => 'portfolio_header_section',
        'settings' => 'fichier_cv',
    )));

    //===========
    //FOOTER
    //===========

    $wp_customize->add_section('portfolio_footer_section', array(

        'title'    => 'Bas de page du site (Footer)',
        'priority' => 31,
    ));

    //LOGO LINKEDIN

    $wp_customize->add_setting('logo_linkedin', array(
        'default'           => 'devicon-linkedin-plain',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('controle_logo_linkedin', array(
        'label'    => 'Code de l\'icône linkedin',
        'section'  => 'portfolio_footer_section',
        'settings' => 'logo_linkedin',
        'type'     => 'text',
    ));

    //LOGO GITHUB

    $wp_customize->add_setting('logo_github', array(
        'default'           => 'devicon-github-original',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('controle_logo_github', array(
        'label'    => 'Code de l\'icône github',
        'section'  => 'portfolio_footer_section',
        'settings' => 'logo_github',
        'type'     => 'text',
    ));

    //STOCKAGE LOGO CV


    $wp_customize->add_setting('logo_cv', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    // 2. Le contrôle spécial "Upload de média"
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'controle_logo_cv', array(
        'label'    => 'Votre logo CV',
        'section'  => 'portfolio_footer_section',
        'settings' => 'logo_cv',
    )));
}

function forme_personnalise()
{
    /* --- 1. GESTION PALETTE COULEUR --- */
    // Permet de désactiver la palette de couleur existante par défaut
    add_theme_support('disable-custom-colors');
    // 1. Désactive le choix de la couleur d'arrière-plan (Background Color)
    add_theme_support('disable-custom-gradients'); // Bloque les dégradés
    add_theme_support('editor-gradient-presets', array()); // Vide les dégradés par défaut

    // Création de ma propre palette restreinte attention on est obligé de garder editor-color-palette comme commande 
    //On peut pas mettre un autre c'est seulement ce mot que wordpress reconnaît
    add_theme_support('editor-color-palette', array(
        array(
            'name'  => __('Noir Titre', 'portfoliopierresoreau'),
            'slug'  => 'noir-titre',
            'color' => '#0f172a',
        ),
        array(
            'name'  => __('Gris Texte', 'portfoliopierresoreau'),
            'slug'  => 'gris-texte',
            'color' => '#5f646c',
        ),
    ));
}
