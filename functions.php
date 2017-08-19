<?php


//Adiciona suporte para cadastrar uma imagem de destaque em posts e páginas
add_theme_support('post-thumbnails');
add_image_size( 'thumb-custom', 800, 800, true);

//Função que crias post types diferentes para o tema
function meus_posts_types(){
    //Habilidades
    register_post_type('habilidades',
        array(
            'labels' => array(
                'name' => __('Habilidades'),
                'singular_name' => __('Habilidade'),   
            ),
            'public' => true,
            'has_archive' => true,
            'menu_icon' => 'dashicons-welcome-learn-more',
            'supports' =>  array(
                'title',
                'editor',
                'thumbnail',
                'custom-fields',
                'page-attributes',
            )
        )
    );
}
add_action('init','meus_posts_types');

//Função retorna imagem por nome
/*
    Retorna um objeto do tipo imagem baseado no nome passado como parametro
*/
function wp_get_attachment_by_post_name($post_name){
    $args = array(
        'posts_per_page' => 1,
        'post_type'      => 'attachment',
        'name'           => trim ( $post_name ),
    );
    $get_attachment = new WP_Query( $args );

    if ( $get_attachment->posts[0] )
        return $get_attachment->posts[0];
    else
        return null;
}

//Função retorna todas as imagens cadastradas do post
/*
    Deve ser utilizada dentro do loop do post ou dentro do arquivo exemplo : single.php
*/
function post_get_images($ind=NULL) {
    global $post;
    $list = array();
    $args = array(
        'post_type' => 'attachment',
        'post_mime_type' => 'image/jpeg',
        'numberposts' => -1,
        'post_status' => null,
        'orderby' => 'menu_order',
        'post_parent' => $post->ID
    );
    $attachments = get_posts($args);

    //jpg
    foreach ($attachments as $at) {
        $list[$at->ID]['title'] = $at->post_title;
        $list[$at->ID]['src'] = $at->guid;
    }
    //bmp
    $args['post_mime_type'] = 'image/bmp';
    $attachments = get_posts($args);
    foreach ($attachments as $at) {
        $list[$at->ID]['title'] = $at->post_title;
        $list[$at->ID]['src'] = $at->guid;
    }
    //png
    $args['post_mime_type'] = 'image/png';
    $attachments = get_posts($args);
    foreach ($attachments as $at) {
        $list[$at->ID]['title'] = $at->post_title;
        $list[$at->ID]['src'] = $at->guid;
    }
    //gif
    $args['post_mime_type'] = 'image/gif';
    $attachments = get_posts($args);
    foreach ($attachments as $at) {
        $list[$at->ID]['title'] = $at->post_title;
        $list[$at->ID]['src'] = $at->guid;
    }

    if (sizeof($list)) {
        $a = 0;
        $images = array();
        foreach ($list as $k => $v) {
            $images[$a]['title'] = $v['title'];
            $images[$a]['src'] = $v['src'];

            $a++;
        }
        unset($list);

        if (!is_null($ind)) {
            if (is_null($images[$ind])) {
                return false;
            } else {
                return $images[$ind];
            }
        } else {
            return $images;
        }
    } else {
        return false;
    }
}

//Função que retorna url de logo baseado no Título da imagem
/*
    Retorna a logo cadastrada no admin em opção de mídia a partir do título
*/
function retornaUrlLogo($titleImage){
    $search = wp_get_attachment_by_post_name($titleImage); 
    $logo = $search->guid;
    return $logo;
}

//Função que retorna menu de links de redes sociais com classes de icones font awesome
/* 
    Necessário criar o menu no personalizar header no admin
    Utilizar opção links personalizados
    preencher os campos url,nome
    E utilizar o campo de classes do item, para inserir a classe do icone do Font Awesome
*/
function listaRedesSociais($nome = "lista-redes"){
    $busca = wp_get_nav_menu_items( $nome );
    $redesSociais = array();
    foreach($busca as $key => $post){
        $redesSociais[$key]["Nome"] = $post->title;
        $redesSociais[$key]["link"] = $post->url;
        $redesSociais[$key]["target"] = $post->target;
        $redesSociais[$key]["icone"] = $post->classes[0] . " " . $post->classes[1];
    }
    return $redesSociais;
}

//Função que remove galeria do content do post
/*
    Deixa apenas images e texto do post

*/
function strip_shortcode_gallery( $content ) {
    preg_match_all( '/' . get_shortcode_regex() . '/s', $content, $matches, PREG_SET_ORDER );

    if ( ! empty( $matches ) ) {
        foreach ( $matches as $shortcode ) {
            if ( 'gallery' === $shortcode[2] ) {
                $pos = strpos( $content, $shortcode[0] );
                if( false !== $pos ) {
                    return substr_replace( $content, '', $pos, strlen( $shortcode[0] ) );
                }
            }
        }
    }

    return $content;
}