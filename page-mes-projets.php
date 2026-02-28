<?php get_header(); ?>
<main>
    <h1 class="titre-page-projets">
        <?php the_title(); ?>
    </h1>
    <section class="contenu-mes-projets">
        <div class="liste-projets">
            <?php
            //On demande à WordPress d'aller chercher tous les "projets"
            $mes_projets = new WP_Query(array(
                'post_type' => 'projet', // Le nom de votre type de publication
                'posts_per_page' => -1 // -1 veut dire "Affiche les tous"
            ));

            // Tant qu'il y a des projets trouvés..."
            while ($mes_projets->have_posts()) : $mes_projets->the_post();

                // get_field permet d'obtenir le contenu du champ renseigné
                $image = get_field('project_image');
                $title = get_field('project_title');
                $date = get_field('project_date');
                $description = get_field('project_description');
                $stacks = get_field('stacks');
                $button_github = get_field('button_github');
                $button_web = get_field('button_web');
                $github_logo = get_field('github_logo');
                $web_logo = get_field('web_logo');
                $url_github = get_field('url_github');
                $url_site_web = get_field('url_site_web');


            ?>

                <div class="project-card">
                    <a href="
                    <?php
                    if ($url_site_web) { // Si le site web existe
                        echo esc_url($url_site_web);
                    } else { // Sinon, on utilise GitHub
                        echo esc_url($url_github);
                    }
                    ?>" target="_blank">
                        <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']);  ?>">
                    </a>

                    <div class="project-text-content">
                        <h2><?php echo esc_html($title) ?></h2>
                        <h3><?php echo esc_html($date) ?></h3>
                        <p class="description"><?php echo esc_html($description) ?></p>
                        <div class="stacks-content">
                            <?php foreach ($stacks as $stack): ?>
                                <span class="stack-badge"><?php echo esc_html($stack); ?></span>
                            <?php endforeach; ?>
                        </div>
                        <div class="button-link">
                            <a href="<?php echo esc_url($url_github); ?>" target="_blank">
                                <div class="button-link-project">
                                    <i class="<?php echo esc_html($github_logo) ?>"></i>
                                    <p><?php echo esc_html($button_github) ?></p>
                                </div>
                            </a>
                            <?php if ($url_site_web) { ?>
                                <a href="<?php echo esc_url($url_site_web); ?>" target="_blank">
                                    <div class="button-link-project">
                                        <i class="<?php echo esc_html($web_logo) ?>"></i>
                                        <p><?php echo esc_html($button_web) ?></p>
                                    </div>
                                </a>

                            <?php } ?>
                        </div>
                    </div>

                </div>

            <?php
            endwhile;
            wp_reset_postdata();
            ?>


    </section>
</main>


<?php get_footer(); ?>