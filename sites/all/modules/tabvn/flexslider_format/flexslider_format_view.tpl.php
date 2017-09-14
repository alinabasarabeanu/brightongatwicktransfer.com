
<?php
$url = '#';
if (!empty($entity['type']) && !empty($entity['object']) && ($entity['type'] == 'node')) {
  $node = $entity['object'];
  $url = url('node/' . $node->nid);
}
?>

<?php if (!empty($items) && (count($items) > 1)): ?>
  <section class="flexslider">
    <ul class="slides post-img">
      <?php foreach ($items as $delta => $item): ?>
        <?php
        if (module_exists('colorbox')) {
          if (!empty($settings['destination_image_style'])) {
            $img_url = image_style_path($settings['destination_image_style'], $item['uri']);
          } else {
            $img_url = file_create_url($item['uri']);
          }
        }
       $gallery_id = !empty($node->nid) ? $node->nid : $item['timestamp'];
        $href = '';
        if (!empty($img_url)) {
          $href = 'rel="gallery[' . $gallery_id . ']" class="colorbox" href="' . $img_url . '"';
        }
        ?>
        <li> 
          <a <?php print $href; ?>>
            <?php
            print theme('image_style', array(
                'style_name' => $settings['source_image_style'],
                'path' => $item['uri'],
                ''
            ));
            ?>
          </a>


        </li>

      <?php endforeach; ?>
    </ul>
  </section>
<?php else: ?>


  <?php foreach ($items as $delta => $item): ?>
    <?php
    if (module_exists('colorbox')) {
      if (!empty($settings['destination_image_style'])) {
        $img_url = image_style_path($settings['destination_image_style'], $item['uri']);
      } else {
        $img_url = file_create_url($item['uri']);
      }
    }

    $gallery_id = !empty($node->nid) ? $node->nid : $item['timestamp'];
    $href = '';
    if (!empty($img_url)) {
      $href = 'rel="gallery[' . $gallery_id . ']" class="colorbox" href="' . $img_url . '"';
    }
    ?>
    <figure class="post-img">
      <a <?php print $href; ?>><?php
    print theme('image_style', array(
        'style_name' => $settings['source_image_style'],
        'path' => $item['uri'],
        ''
    ));
    ?>
      </a>
    </figure>
  <?php endforeach; ?>
<?php endif; ?>

