<?php
/*
Template Name: Projetos
*/
?>
<?php get_header() ?>

<?php
    
    $post_per_page = 9;
    $btpgid=get_queried_object_id();
    $btmetanm=get_post_meta( $btpgid, 'WP_Catid', 'true' );
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    
    $args = array(
        'posts_per_page' => $post_per_page,
        'category_name' => $btmetanm,
        'paged' => $paged,
        'post_type' => 'post'
    );
    $postslist = new WP_Query( $args );
    $numMaxPages = $postslist->max_num_pages; //Número máximo de páginas
?>

<?php
while ($postslist->have_posts()) :
    $categories = wp_get_object_terms( $postslist->posts[$contador]->ID, 'category' );
    $postslist->the_post();
endwhile;
?>


<nav aria-label="Page navigation example">
                                    <ul class="pagination">
                                        <li class="page-item">
                                            <a class="page-link" href="
                                            <?php $url = bloginfo('url');
                                            $urlFinal = $url . "/projetos";
                                            echo $urlFinal  ?>" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                        </li>
                                        <?php for ($i = 1; $i < $numMaxPages + 1; $i++) : ?>
                                            <li class="page-item">
                                                <a class="page-link" href="<?php
                                                $url = bloginfo('url');
                                                $urlFinal = $url . "/projetos";
                                                echo $urlFinal . "/page" . "/" . $i ?>"><?= $i ?></a>
                                            </li>
                                        <?php endfor; ?>
                                        <li class="page-item">
                                            <a class="page-link" href="<?php $urlFinal . "/page" . "/" . $numMaxPages ?>">
                                                <span aria-hidden="true">&raquo;</span>
                                                <span class="sr-only">Next</span>
                                            </a>
                                        </li>
                                    </ul>
</nav>

<?php get_footer() ?>
