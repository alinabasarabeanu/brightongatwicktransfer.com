<!DOCTYPE html>
<!--[if IE 8 ]><html class="ie" xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language; ?>" lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>"<?php print $rdf_namespaces; ?>> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language; ?>" lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>"<?php print $rdf_namespaces; ?>><!--<![endif]-->

  <head profile="<?php print $grddl_profile; ?>">
    <?php print $head; ?>
    <title><?php print $head_title; ?></title>
    <link rel="shortcut icon" href="<?php print base_path() . path_to_theme(); ?>/images/favicon.png">
      <link rel="apple-touch-icon" href="<?php print base_path() . path_to_theme(); ?>/images/favicon.png">
        <link rel="apple-touch-icon" sizes="72x72" href="<?php print base_path() . path_to_theme(); ?>/images/favicon.png">
          <link rel="apple-touch-icon" sizes="114x114" href="<?php print base_path() . path_to_theme(); ?>/images/favicon.png">
            <?php print $styles; ?>
            <style type="text/css"><?php
            $custom_theme_css = theme_get_setting('custom_theme_css');
            if (!empty($custom_theme_css)) {
              print $custom_theme_css;
            }
            ?></style>


            <!--[if lt IE 9]>
                <link rel="stylesheet" type="text/css" href="<?php print base_path() . path_to_theme(); ?>/stylesheets/ie.css" />
              <![endif]-->

            <!--[if lt IE 9]>
              <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
            <![endif]-->
            <?php print $scripts; ?>

            </head>
            <body class="royal_loader <?php print $classes; ?>" <?php print $attributes; ?>>
              <div id="skip-link">
                <a href="#main-content" class="element-invisible element-focusable"><?php print t('Skip to main content'); ?></a>
              </div>
              <?php print $page_top; ?>
              <?php print $page; ?>
              <?php print $page_bottom; ?>
              <?php
              $path = base_path() . path_to_theme();
              ?>
              <script type="text/javascript">
                var images = {
                  'parallax1': '<?php print $path; ?>/images/hero.jpg',
                  'parallax2': '<?php print $path; ?>/images/services-red.jpg',
                  'parallax3': '<?php print $path; ?>/images/clients.jpg',
                  'About Us': '<?php print $path; ?>/images/about.jpg',
                  'Team': '<?php print $path; ?>/images/team.jpg',
                  'Thumb1': '<?php print $path; ?>/images/thumbnails/project1.jpg',
                  'Thumb2': '<?php print $path; ?>/images/thumbnails/project2.jpg',
                  'Thumb3': '<?php print $path; ?>/images/thumbnails/project3.jpg',
                  'Thumb4': '<?php print $path; ?>/images/thumbnails/project4.jpg',
                  'Thumb5': '<?php print $path; ?>/images/thumbnails/project5.jpg',
                  'Thumb6': '<?php print $path; ?>/images/thumbnails/project6.jpg',
                  'Thumb7': '<?php print $path; ?>/images/thumbnails/project7.jpg',
                  'Thumb8': '<?php print $path; ?>/images/thumbnails/project8.jpg'
                };
              </script>
              <?php if (!theme_get_setting('use_parallax')): ?>
                <script type="text/javascript">
                  (function($) {
                    $(document).ready(function() {
                      $('.parallax').each(function() {
                        
                        $(this).addClass('no-parallax')
                      });
                    });

                  })(jQuery);
                </script>
              <?php endif; ?>
            </body>
            </html>
