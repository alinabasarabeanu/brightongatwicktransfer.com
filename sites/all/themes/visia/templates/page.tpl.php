<nav class="clearfix">

  <!-- Logo -->
  <div class="logo">
    <?php if (drupal_is_front_page()): ?><div id="top"><?php endif; ?>
    <?php if ($logo): ?>
        <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home" id="logo">
          <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" />
        </a>
      <?php endif; ?>
      <?php if (drupal_is_front_page()): ?></div><?php endif; ?>
  </div>
  <!-- Mobile Nav Button -->
  <button type="button" class="nav-button" data-toggle="collapse" data-target=".nav-content">
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
  </button>

  <?php if ($page['main_navigation']): ?>
    <!-- Navigation Links -->
    <div class="navigation">
      <?php print render($page['main_navigation']); ?>
    </div>
  <?php endif; ?>

</nav>

<!-- main content -->
<div id="main-content" class="content padded container">
  <?php if (theme_get_setting('enable_breadcrumb')): ?>
    <?php if ($breadcrumb): ?>
      <div id="breadcrumb"><?php print $breadcrumb; ?></div>
    <?php endif; ?>
  <?php endif; ?>

  <?php if ($title): ?>
    <div id="page-title" class="title grid-full">
      <h2><?php print $title; ?></h2>
      <span class="border"></span>
    </div>
  <?php endif; ?>


  <?php
  $content_column_size = theme_get_setting('content_column_size');
  $sidebar_column_size = 6 - (int) $content_column_size;
  if (!$page['sidebar']) {
    $content_column_size = 6; // if sidebar empty content column will fullwidth 6 columns
  }
  ?>
  <!-- Content -->
  <div id="content" class="grid-<?php print $content_column_size; ?>">
    <?php print $messages; ?>


    <?php if ($page['highlighted']): ?><div id="highlighted"><?php print render($page['highlighted']); ?></div><?php endif; ?>
    <a id="main-content"></a>
    <?php print render($title_prefix); ?>

    <?php print render($title_suffix); ?>
    <?php if ($tabs): ?>
      <div id="main-tabs" class="tabs">
        <?php print render($tabs); ?>
        <div class="clearfix"></div>
      </div>

    <?php endif; ?>
    <?php print render($page['help']); ?>
    <?php if ($action_links): ?>
      <ul class="action-links"><?php print render($action_links); ?></ul>
    <?php endif; ?>
    <?php print render($page['content']); ?>
    <?php print $feed_icons; ?>
  </div>
  <!-- // Content  -->

  <?php if ($page['sidebar']): ?>
    <!-- sidebar -->
    <div id="sidebar" class="grid-<?php print $sidebar_column_size; ?> sidebar">
      <?php print render($page['sidebar']); ?>
    </div>
    <!-- // sidebar -->
  <?php endif; ?>

</div>
<!-- // main content -->

<footer id="footer" class="clearfix">
  <?php if ($page['footer_top']): ?>
    <div class="content dark container">
      <?php print render($page['footer_top']); ?>
    </div>
  <?php endif; ?>

  <?php if ($page['footer_contact_form']): ?>
    <!-- Contact Form -->
    <div id="contact-form" class="dark clearfix">
      <?php print render($page['footer_contact_form']); ?>
    </div>
  <?php endif; ?>

  <div class="container">

    <?php print render($page['footer']); ?>

  </div>
</footer>