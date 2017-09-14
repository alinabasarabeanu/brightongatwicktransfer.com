
<div id="<?php print $block_html_id; ?>" class="clearfix <?php print $classes; ?>"<?php print $attributes; ?>>

<?php print render($title_prefix); ?>
<?php if ($block->subject): ?>
<h3<?php print $title_attributes; ?>><?php print $block->subject ?></h3>
<span class="border"></span>
<?php endif;?>
<?php print render($title_suffix); ?>

<div class="block-content"<?php print $content_attributes; ?>>
  <?php print $content ?>
</div>
</div>
