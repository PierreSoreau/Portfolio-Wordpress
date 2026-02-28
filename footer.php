<footer>

    <div class="photo-profil size">
        <a href="<?php echo home_url(); ?>"><?php the_custom_logo(); ?></a>
    </div>

    <button class="social-network size" aria-label="Aller sur le linkedin de Pierre Soreau">
        <a href="https://www.linkedin.com/in/pierre-soreau/" target="_blank"><i class="<?php echo esc_html(get_theme_mod('logo_linkedin', 'devicon-linkedin-plain')); ?>"></i></a>
    </button>

    <button class="social-network size" aria-label="Aller sur le github de Pierre Soreau">
        <a href="https://github.com/PierreSoreau" target="_blank"><i class="<?php echo esc_html(get_theme_mod('logo_github', 'devicon-github-original')); ?>"></i></a>
    </button>



    <a href="<?php echo esc_url(get_theme_mod('fichier_cv', get_template_directory_uri() . '/assets/cv-pierre-soreau.pdf')) ?>" target="_blank" class="size">
        <img src="<?php echo esc_url(get_theme_mod('logo_cv', get_template_directory_uri() . '/assets/cv.png')) ?>" alt="logo cv" class="size">
    </a>




</footer>
<?php wp_footer(); ?>
</body>

</html>