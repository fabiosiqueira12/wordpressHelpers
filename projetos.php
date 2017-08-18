<?php
/*
Template Name: Projetos
*/
?>
<?php get_header() ?>

<?php
    
    $post_per_page = 9;
    $btpgid=get_queried_object_id();
    $btmetanm=get_post_meta( $btpgid, 'WP_Catid','true' );
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

<main>
<section id="pagina" class="produtos">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center mb-3">
                        <h2 class="titulo-page">Projetos</h2>
                    </div>
                </div>
                <div class="row" style="margin-top : 40px">

                <?php if ( $postslist->have_posts()) : ?>
                        <?php
                        $contador = 0; 
                        while ( $postslist->have_posts() ) :
                          $categories = wp_get_object_terms( $postslist->posts[$contador]->ID , 'category' );
                          $postslist->the_post();        
                          
                        ?>
                            <div class="col-md-4 col-sm-12 col-12">
                                <a href="<?= the_permalink() ?>">
                                    <div class="produto-box efeito1">
                                        <div class="imagem">
                                            <?php the_post_thumbnail(); ?>
                                        </div>
                                        <div class="hover-produto">
                                            <div class="titulo">
                                                <?= the_title() ?>
                                            </div>
                                            <div class="categorias">
                                                <?php foreach($categories as $key => $value) : ?>
                                                    <?php if ($key == 0 or $key == count($categories)) { ?>
                                                        <span><?= $value->name ?></span>
                                                    <?php }else { ?>
                                                        /<span><?= $value->name ?></span>
                                                    <?php } ?>
                                                <?php endforeach; ?>
                                            </div>

                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php $contador++; ?>
                        <?php endwhile; ?>
                        
                        <?php if ( $numMaxPages > 1 ) { ?>
                            <?php     
                                
                            ?>
                            <div class="col-12 coluna-flex hori-align mt-3">
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
                            </div>
                        <?php } ?>
                        
                    <?php else : ?>
                    
                        <div class="col-12 m-t-2" style="display : flex;justify-content : center">
                        
                            <div class="alert alert-danger" role="alert">
                            <strong>Oh Desculpe!</strong> Ainda não postamos os nossos projetos.
                            </div>
                        </div>

                    <?php endif; ?>
                    
                </div>
            </div>
        </section>
</main>

<?php get_footer() ?>
