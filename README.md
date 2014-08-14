Bootstrap Features
==================
* Contributors: lsdev, iaincoughtrie
* Donate link: http://lsdev.biz
* Tags: features, widget, shortcode, template-tag, feedback, customers
* Tested up to: 3.8.0
* License: GPLv2 or later
* License URI: http://www.gnu.org/licenses/gpl-2.0.html

Creates a features post type, and allows you to display features on your site using a shortcode, template tag or widget. Designed to be used with the Bootstrap framework.

Shortcode:
==========

Insert the shortcode [features] into any post or page to display all features.

Optional shortcode parameters:
------------------------------
- include: include specific features by ID. 
	eg [features include="3, 5, 12"]

- size: set the size in pixels of the icon that displays on each feature. 
	eg [features size=200]

- group: set the Feature Group slug to display features from that group only.
	eg [features group="feature-group-slug"]

- responsive: choose whether the image size should adjust according to the viewport size. (Doesn't affect font icons, only images)
	eg [features responsive=true]

- limit: set a limit on the number of features that are returned (not necessary if already using the 'include' parameter).
	eg [features limit=5]

- buttons: choose whether or not to display the button set for each feature.
	eg [features buttons=false]

- columns: choose 1 to 4 column layout.
	eg [features columns=2]


Template tag:
=============

```
<?php
	if ( class_exists( 'BS_Features' ) ) {
        $BS_Features = new BS_Features();
        echo $BS_Features->output();
    };
?>
```

Optional template tag parameters:
---------------------------------
The template tag accepts an array of the same parameters used in the shortcode.
eg:
```
<?php if ( class_exists( 'BS_Features' ) ) {
        $BS_Features = new BS_Features();
        echo $BS_Features->output(array(                                        
                            'size' => 80,
                            'responsive' => true,
                            'columns' => 2,
                            'limit' => 6,
                            'buttons' => false
                            )
                        );                 
} ?>
```