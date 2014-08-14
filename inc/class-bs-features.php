<?php

class BS_Custom {
public $single;
public $plural;

    public function __construct($args)
    {
        extract($args);
        $this->plural = $plural;
        $this->single = $single;
        add_action( 'template_redirect', array($this, 'disable_single' ) );
        add_shortcode(  $this->plural , array($this, 'output' ) );        
    }

    public function disable_single() 
    {
        $queried_post_type = get_query_var('post_type');
        if ( is_single() && $this->plural ==  $queried_post_type ) {
            wp_redirect( home_url(), 301 );
            exit;
        }
    }

    public function output( $atts ) 
    {
        extract( shortcode_atts( array(
            'tag' => 'h3',
            'columns' => 1,
            'orderby' => 'date',
            'order' => 'DESC',
            'limit' => '-1',
            'group' => '',
            'include' => '',
            'size' => 100,
            'buttons' => 'true',
            'responsive' => 'true'            
        ), $atts ) );
        
        $output = "";

        if ( $responsive == 'true' ) {
            $responsive = 'img-responsive';    
        } else {
            $responsive = '';
        }

        if ( $include != '' ) {
        $include = explode( ',', $include );
            $args = array(
                    'post_type' =>  $this->single ,
                    $this->plural .'-group' => $group,
                    'posts_per_page' => $limit, 
                    'post__in' => $include,
                    'orderby' => 'post__in',
                    'order' => $order                 
                );
        } else {
             $args = array(
                    'post_type' => $this->single ,
                    $this->plural .'-group' => $group,
                    'posts_per_page' => $limit,
                    'orderby' => $orderby,
                    'order' => $order                
                );
        }
        $names = get_posts( $args );
        
        if ( !empty( $names) ) {            
            $count = 0;
            if ( $columns >= 2 && $columns <= 4 )
                $output .= "<div class='row bs-'.$this->plural.'>";

            foreach ( $names as $name) {

                // Count
                $count++;

                // Headings
                $link_open = "";
                $link_close = "";
                $modal_target = get_post_meta( $name->ID, 'bs_'.$this->plural.'_modal_target', true );
                $url = get_post_meta( $name->ID, 'bs_'.$this->plural.'_url', true );

                if ( $modal_target ) {
                    $link_open = "<a data-toggle='modal' data-target='$modal_target'>";
                    $link_close = "</a>";
                } elseif ( $url ) {
                    $link_open = "<a href='$url'>";
                    $link_close = "</a>";
                }
                $heading = "<$tag>" . $link_open . $name->post_title . $link_close . "</$tag>";
               
                // Buttons                        
                if ( $buttons == 'true' ) {                    
                    $button_img = get_post_meta( $name->ID, 'bs_'.$this->plural.'_button_img', true );
                    $button_img = wp_get_attachment_image_src( $button_img );
                    $button_img = $button_img[0];
                    $button_text = get_post_meta( $name->ID, 'bs_'.$this->plural.'_button_text', true );
                    if ( '' != $button_img ) {
                        if ( $modal_target ) {
                            $button = "<a class='button' data-toggle='modal' data-target='$modal_target'><img src='$button_img' class='text-center' alt='button' /></a>";                            
                        } elseif ( $url ) {
                            $button = "<a class='button' href='$url'><img src='$button_img' class='text-center' alt='button' /></a>";
                        }
                    } elseif ( '' != $button_text ) {
                        if ( $modal_target ) {
                            $button = "<button data-toggle='modal' data-target='$modal_target' class='btn btn-primary text-center'>$button_text</button>";                            
                        } elseif ( $url ) {
                            $button = "<a href='$url' class='btn btn-primary text-center'>$button_text</a>";
                        }                            
                    } else
                        $button = '';
                } else
                    $button = '';

                // Icon
                $icon_font = get_post_meta( $name->ID, 'bs_'.$this->plural.'_icon_font', true );
                $icon_class = get_post_meta( $name->ID, 'bs_'.$this->plural.'_icon_class', true );
                $icon_size = $size;
                if ( $icon_font != "none" ) {                    
                    if ( $columns == 1 ) 
                        $icon = '<i class="pull-right ' . $icon_font . ' ' . $icon_class . '" style="font-size: ' . $icon_size . 'px"></i>';
                    else
                        $icon = '<i class="' . $icon_font . ' ' . $icon_class . '" style="font-size: ' . $icon_size . 'px"></i>';
                } elseif ( get_the_post_thumbnail( $name->ID ) != '' ) {
                    if ( $columns == 1 ) 
                        $icon = get_the_post_thumbnail( $name->ID, array( $size, $size ), "class=img-circle $responsive pull-right");
                    else
                        $icon = get_the_post_thumbnail( $name->ID, array( $size, $size ), "class=img-circle $responsive center-block");
                } 
                // Output
                if ( $columns == 1 ) { 
                    $output .= "
                        <div class='row'>                    
                            <figure class='col-sm-3'>
                                $icon
                                </figure>
                            <div class='col-sm-9'>
                                $heading
                                <p>$name->post_content</p>
                                $button                             
                            </div>
                        </div>";          
                } elseif ( $columns >= 2 && $columns <= 4 ) {         
                    $md_col_width = 12/$columns;
                    $output .= "
                        <div class='col-md-$md_col_width col-sm-6'>
                            <figure class='text-center'>                                
                                $icon
                            </figure>
                            <div class='text-center'>
                                $heading
                                <p>$name->post_content</p>
                                $button                              
                            </div>                            
                        </div>";
                    if ( $count%$columns == 0 ) $output .= "<div class='clearfix'></div>";                  
                } else {
                    $output .= "
                        <p class='bg-warning' style='padding: 20px;'>
                            Invalid number of columns set. Bootstrap '.$this->plural.' supports 1 to 4 columns.
                        </p>";
                };              
            }

        if ( $columns >= 2 && $columns <= 4 )
            $output .= "</div>";

        return $output;
        }
    }

}

