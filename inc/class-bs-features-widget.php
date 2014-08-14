<?php


/**
 * Bootstrap Custom Widget
 */

class BS_Custom_Widget extends WP_Widget {
 
    public  $class;
    public  $plural;
    public  $single;
    public  $desc;

    
 // $class = 'BS_Custom', $plural = 'Features' , $single = 'Feature' , $desc ='A parent widget'
    /** constructor -- name this the same as the class above */
    function __construct($class='BS_Custom' ,  $plural='Features' , $single='Feature' , $desc='A Parent Widget')  {
        
    $this->class=$class;
    $this->plural=$plural;
    $this->single=$single;
    $this->desc=$desc;
        parent::__construct(
            false, // Base ID
            __("Bootstrap $this->plural"),
            array( 'description' => __($this->desc), ) // Args
        );

     
        // $wp_widget_factory->register(__CLASS__);
    
    }

 
    /** @see WP_Widget::widget -- do not rename this */
    function widget( $args, $instance ) { 
        extract( $args );
        $title    = apply_filters( 'widget_title', $instance['title'] );
        $title_link = $instance['title_link'];
        $tagline = $instance['tagline'];
        $tag = $instance['tag'];
        $columns = $instance['columns'];
        $orderby = $instance['orderby'];
        $order = $instance['order'];
        $limit = $instance['limit'];
        $group = $instance['group'];
        $include = $instance['include'];
        $size = $instance['size'];
        $buttons = $instance['buttons'];
        $responsive = $instance['responsive'];

        if ( $limit == '' ) $limit = "-1";
        
        // Disregard specific ID setting if specific group is defined
        if ( $group != 'all' ) {
            $include = '';
        } else {
            $group = '';
        }
        
        if ( $include != '' ) $limit = "-1";
              
        if ( $responsive == '1' )
            $responsive = 'true';
        else
            $responsive = 'false';

        if ( $buttons == '1' )
            $buttons = 'true';
        else
            $buttons = 'false';
                
        if ( $title_link ) {
            $link_open = "<a href='$title_link'>";
            $link_close = "</a>";
        } else {
            $link_open = "";
            $link_close = "";
        }

        echo $before_widget;        
        if ( $title )
            echo $before_title . $link_open . $title . $link_close . $after_title;

        if ( $tagline )
            echo "<p class='tagline text-center'>$tagline</p>";

              
        if ( class_exists( 'BS_Custom' ) ) {
                $custom_array = array(
                    'single' => $this->single , 
                    'plural' => $this->plural
                   );
               $BS_Custom = new BS_Custom($custom_array);
                echo $BS_Custom->output(array(                                                                            
                                    'tag' => $tag,                                    
                                    'columns' => $columns,
                                  'orderby' => $orderby,
                                    'order' => $order,
                                    'limit' => $limit,
                                    'group' => $group,
                                    'include' => $include,                                    
                                    'size' => $size,
                                    'buttons' => $buttons,
                                    'responsive' => $responsive
                                    )
                                );                 
     };  
        echo $after_widget;        
    }
 
    /** @see WP_Widget::update -- do not rename this */
    function update($new_instance, $old_instance) {   
    $instance = $old_instance;
    $instance['title'] = strip_tags( $new_instance['title'] );
    $instance['title_link'] = strip_tags( $new_instance['title_link'] );
    $instance['tagline'] = strip_tags( $new_instance['tagline'] );
    $instance['tag'] = strip_tags( $new_instance['tag'] );
    $instance['columns'] = strip_tags( $new_instance['columns'] );
    $instance['orderby'] = strip_tags( $new_instance['orderby'] );
    $instance['order'] = strip_tags( $new_instance['order'] );
    $instance['limit'] = strip_tags( $new_instance['limit'] );
    $instance['group'] = strip_tags( $new_instance['group'] ); 
    $instance['include'] = strip_tags( $new_instance['include'] );
    $instance['size'] = strip_tags( $new_instance['size'] );
    $instance['buttons'] = strip_tags( $new_instance['buttons'] );
    $instance['responsive'] = strip_tags( $new_instance['responsive'] );
       
    return $instance;
    }
 
    /** @see WP_Widget::form -- do not rename this */
    function form($instance) {  
    
        $defaults = array( 
            'title' => $this->single,
            'title_link' => '',
            'tagline' => '',
            'tag' => 'h3',
            'columns' => '1', 
            'orderby' => 'date',
            'order' => 'DESC',
            'limit' => '',
            'group' => '', 
            'include' => '',
            'size' => '100', 
            'buttons' => 1,              
            'responsive' => 1
            );
        $instance = wp_parse_args( (array) $instance, $defaults );   

        $title    = esc_attr($instance['title']);
        $title_link    = esc_attr($instance['title_link']);
        $tagline    = esc_attr($instance['tagline']);
        $tag    = esc_attr($instance['tag']);
        $columns  = esc_attr($instance['columns']);
        $orderby  = esc_attr($instance['orderby']);
        $order  = esc_attr($instance['order']);
        $limit  = esc_attr($instance['limit']);
        $group = esc_attr($instance['group']);
        $include  = esc_attr($instance['include']);
        $size  = esc_attr($instance['size']);
        $buttons = esc_attr($instance['buttons']);
        $responsive = esc_attr($instance['responsive']);

        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('title_link'); ?>"><?php _e( 'Title Link:' ); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('title_link'); ?>" name="<?php echo $this->get_field_name('title_link'); ?>" type="text" value="<?php echo $title_link; ?>" />
            <small>Link the widget title to a URL</small>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('tagline'); ?>"><?php _e('Tagline:'); ?></label> 
            <textarea class="widefat" rows="8" cols="20" id="<?php echo $this->get_field_id('tagline'); ?>" name="<?php echo $this->get_field_name('tagline'); ?>"><?php echo $tagline; ?></textarea>
            <small>Tagline to display below the widget title</small>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('tag'); ?>"><?php _e('Heading Tag:'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('tag'); ?>" name="<?php echo $this->get_field_name('tag'); ?>" type="text" value="<?php echo $tag; ?>" />
            <small>HTML tag to wrap your headings. Eg. h2, h3, p etc</small>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('columns'); ?>"><?php _e('Columns:'); ?></label>
            <select name="<?php echo $this->get_field_name('columns'); ?>" id="<?php echo $this->get_field_id('columns'); ?>" class="widefat layout">
            <?php
            $options = array('1', '2', '3', '4');
            foreach ($options as $option) {
                echo '<option value="' . lcfirst($option) . '" id="' . $option . '"', $columns == lcfirst($option) ? ' selected="selected"' : '', '>', $option, '</option>';
            }
            ?>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('orderby'); ?>"><?php _e('Order By:'); ?></label>
            <select name="<?php echo $this->get_field_name('orderby'); ?>" id="<?php echo $this->get_field_id('orderby'); ?>" class="widefat">
            <?php
            $options = array(
                'None' => 'none', 
                'ID' => 'ID',
                'Name' => 'name', 
                'Date' => 'date',
                'Modified Date' => 'modified',
                'Random' => 'rand' 
                );
            foreach ($options as $name=>$value) {
                echo '<option value="' . $value . '" id="' . $value . '"', $orderby == $value ? ' selected="selected"' : '', '>', $name, '</option>';
            }
            ?>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('order'); ?>"><?php _e('Order:'); ?></label>
            <select name="<?php echo $this->get_field_name('order'); ?>" id="<?php echo $this->get_field_id('order'); ?>" class="widefat">
            <?php
            $options = array(
                'Ascending' => 'ASC', 
                'Descending' => 'DESC'
                );
            foreach ($options as $name=>$value) {
                echo '<option value="' . $value . '" id="' . $value . '"', $order == $value ? ' selected="selected"' : '', '>', $name, '</option>';
            }
            ?>
            </select>
        </p>     
        <p>
            <label for="<?php echo $this->get_field_id('limit'); ?>"><?php _e('Maximum amount:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo $limit; ?>" />
            <small><?php _e('Leave empty to display all'); ?></small>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('group'); ?>"><?php _e("$this->single Group:"); ?></label>
            <select name="<?php echo $this->get_field_name('group'); ?>" id="<?php echo $this->get_field_id('group'); ?>" class="widefat">
            <?php
            $options = get_terms("$this->single-group");
            echo '<option value="all" id="all">All Groups</option>';
            foreach ($options as $option) {
                echo '<option value="' . $option->slug . '" id="' . $option->slug . '"', $group == $option->slug ? ' selected="selected"' : '', '>', $option->name, '</option>';
            }
            ?>
            </select>
        </p>
        <p class="bs-<?php echo $this->single;?>-specify">
            <label for="<?php echo $this->get_field_id('include'); ?>"><?php _e("Specify $this->plural by ID:"); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('include'); ?>" name="<?php echo $this->get_field_name('include'); ?>" type="text" value="<?php echo $include; ?>" />
            <small><?php _e('Comma separated list, overrides limit setting'); ?></small>
        </p>        
        <p>
            <label for="<?php echo $this->get_field_id('size'); ?>"><?php _e('Icon size:'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('size'); ?>" name="<?php echo $this->get_field_name('size'); ?>" type="text" value="<?php echo $size; ?>" />
        </p>
        <p>
            <input id="<?php echo $this->get_field_id('buttons'); ?>" name="<?php echo $this->get_field_name('buttons'); ?>" type="checkbox" value="1" <?php checked( '1', $buttons ); ?> />
            <label for="<?php echo $this->get_field_id('buttons'); ?>"><?php _e('Show Buttons'); ?></label>
        </p>
        <p>
            <input id="<?php echo $this->get_field_id('responsive'); ?>" name="<?php echo $this->get_field_name('responsive'); ?>" type="checkbox" value="1" <?php checked( '1', $responsive ); ?> />
            <label for="<?php echo $this->get_field_id('responsive'); ?>"><?php _e('Responsive Images'); ?></label>
        </p>
        <script>
        jQuery(document).ready(function($) {
            var valueSelected = jQuery("#widget-bs_<?php echo $this->plural;?>_widget-2-group :selected").val();

            if ( valueSelected == 'all' ) {
                jQuery('.bs-<?php echo $this->plural;?>-specify').show();                
            } else {
                jQuery('.bs-<?php echo $this->plural;?>-specify').hide();
            }
            jQuery("#widget-bs_<?php echo $this->plural;?>_widget-2-group").change(function() {
                var valueSelected = this.value;

                if ( valueSelected == 'all' ) {
                    jQuery('.bs-<?php echo $this->plural;?>-specify').show();                
                } else {
                    jQuery('.bs-<?php echo $this->plural;?>-specify').hide();
                }
            });
        });
        </script>
        <?php
        
    }

}//end of class



class  WP_Widget_Custom_Factory extends WP_Widget_Factory {

    function register($widget_class , $widget_args) {
        extract($widget_args);
        $this->widgets[$widget_class] = new BS_Custom_Widget($related_class , $plural , $single , $description);
    }

}




?>