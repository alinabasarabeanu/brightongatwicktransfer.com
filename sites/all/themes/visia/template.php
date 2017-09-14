<?php

function visia_preprocess_html(&$variables) {

  $theme_path = path_to_theme();
  $default_theme_color = theme_get_setting('theme_color');

  
  drupal_add_css($theme_path . '/stylesheets/colors/' . $default_theme_color, array('group' => CSS_THEME, 'every_page' => TRUE, 'weight' => 10000));

  drupal_add_html_head(
          array(
      '#tag' => 'meta',
      '#attributes' => array(
          'name' => 'viewport',
          'content' => 'width=device-width, initial-scale=1',
      ),
          ), 'visia:viewport_meta'
  );

  drupal_add_html_head(
          array(
      '#tag' => 'meta',
      '#attributes' => array(
          'http-equiv' => 'X-UA-Compatible',
          'content' => 'IE=edge,chrome=1',
      ),
          ), 'anchor:viewport_compatible'
  );
}

function visia_preprocess_node(&$variables) {
  $variables['view_mode'] = $variables['elements']['#view_mode'];
  // Provide a distinct $teaser boolean.
  $variables['teaser'] = $variables['view_mode'] == 'teaser';
  $variables['node'] = $variables['elements']['#node'];
  $node = $variables['node'];

  $variables['date'] = format_date($node->created);
  $variables['name'] = theme('username', array('account' => $node));

  $uri = entity_uri('node', $node);
  $variables['node_url'] = url($uri['path'], $uri['options']);
  $variables['title'] = check_plain($node->title);
  $variables['page'] = $variables['view_mode'] == 'full' && node_is_page($node);

  // Flatten the node object's member fields.
  $variables = array_merge((array) $node, $variables);

  // Helpful $content variable for templates.
  $variables += array('content' => array());
  foreach (element_children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }

  // Make the field variables available with the appropriate language.
  field_attach_preprocess('node', $node, $variables['content'], $variables);

  // Display post information only on certain node types.
  if (variable_get('node_submitted_' . $node->type, TRUE)) {
    $variables['display_submitted'] = TRUE;
    $submitted = '<h6>' . t('Posted by !username', array('!username' => $variables['name'])) . ' ' . visia_format_comma_field('field_tags', $node) . '</h6>';
    $variables['submitted'] = $submitted; //t('Submitted by !username on !datetime', array('!username' => $variables['name'], '!datetime' => $variables['date']));
    $variables['user_picture'] = theme_get_setting('toggle_node_user_picture') ? theme('user_picture', array('account' => $node)) : '';
  } else {
    $variables['display_submitted'] = FALSE;
    $variables['submitted'] = '';
    $variables['user_picture'] = '';
  }

  // Gather node classes.
  $variables['classes_array'][] = drupal_html_class('node-' . $node->type);
  if ($variables['promote']) {
    $variables['classes_array'][] = 'node-promoted';
  }
  if ($variables['sticky']) {
    $variables['classes_array'][] = 'node-sticky';
  }
  if (!$variables['status']) {
    $variables['classes_array'][] = 'node-unpublished';
  }
  if ($variables['teaser']) {
    $variables['classes_array'][] = 'node-teaser';
  }
  if (isset($variables['preview'])) {
    $variables['classes_array'][] = 'node-preview';
  }

  // Clean up name so there are no underscores.
  $variables['theme_hook_suggestions'][] = 'node__' . $node->type;
  $variables['theme_hook_suggestions'][] = 'node__' . $node->nid;
}

function visia_format_comma_field($field_category, $node, $limit = NULL) {

  if (module_exists('i18n_taxonomy')) {
    $language = i18n_language();
  }

  $category_arr = array();
  $category = '';
  $field = field_get_items('node', $node, $field_category);

  if (!empty($field)) {
    foreach ($field as $item) {
      $term = taxonomy_term_load($item['tid']);


      if ($term) {
        if (module_exists('i18n_taxonomy')) {
          $term_name = i18n_taxonomy_term_name($term, $language->language);

          // $term_desc = tagclouds_i18n_taxonomy_term_description($term, $language->language);
        } else {
          $term_name = $term->name;
          //$term_desc = $term->description;
        }

        $category_arr[] = l($term_name, 'taxonomy/term/' . $item['tid']);
      }

      if ($limit) {
        if (count($category_arr) == $limit) {
          $category = implode(', ', $category_arr);
          return $category;
        }
      }
    }
  }
  $category = implode('/ ', $category_arr);

  return $category;
}

function visia_status_messages(&$variables) {
  $display = $variables['display'];
  $output = '';

  $message_info = array(
      'status' => array(
          'heading' => 'Status message',
          'class' => 'success',
      ),
      'error' => array(
          'heading' => 'Error message',
          'class' => 'error',
      ),
      'warning' => array(
          'heading' => 'Warning message',
          'class' => '',
      ),
  );

  foreach (drupal_get_messages($display) as $type => $messages) {
    if (empty($message_info[$type]['class'])) {
      $message_info[$type]['class'] = 'status';
    }
    $message_class = $type != 'warning' ? $message_info[$type]['class'] : 'warning';
    $output .= "<div class=\"alert alert-block alert-$message_class $message_class\">\n";
    if (!empty($message_info[$type]['heading'])) {
      $output .= '<h2 class="element-invisible">' . $message_info[$type]['heading'] . "</h2>\n";
    }
    if (count($messages) > 1) {
      $output .= " <ul>\n";
      foreach ($messages as $message) {
        $output .= '  <li>' . $message . "</li>\n";
      }
      $output .= " </ul>\n";
    } else {
      $output .= $messages[0];
    }
    $output .= "</div>\n";
  }
  return $output;
}

function visia_pager($variables) {
  $tags = $variables['tags'];
  $element = $variables['element'];
  $parameters = $variables['parameters'];
  $quantity = $variables['quantity'];
  global $pager_page_array, $pager_total;

  // Calculate various markers within this pager piece:
  // Middle is used to "center" pages around the current page.
  $pager_middle = ceil($quantity / 2);
  // current is the page we are currently paged to
  $pager_current = $pager_page_array[$element] + 1;
  // first is the first page listed by this pager piece (re quantity)
  $pager_first = $pager_current - $pager_middle + 1;
  // last is the last page listed by this pager piece (re quantity)
  $pager_last = $pager_current + $quantity - $pager_middle;
  // max is the maximum page number
  $pager_max = $pager_total[$element];
  // End of marker calculations.
  // Prepare for generation loop.
  $i = $pager_first;
  if ($pager_last > $pager_max) {
    // Adjust "center" if at end of query.
    $i = $i + ($pager_max - $pager_last);
    $pager_last = $pager_max;
  }
  if ($i <= 0) {
    // Adjust "center" if at start of query.
    $pager_last = $pager_last + (1 - $i);
    $i = 1;
  }
  // End of generation loop preparation.

  $li_first = theme('pager_first', array('text' => (isset($tags[0]) ? $tags[0] : t('« first')), 'element' => $element, 'parameters' => $parameters));
  $li_previous = theme('pager_previous', array('text' => (isset($tags[1]) ? $tags[1] : t('‹ previous')), 'element' => $element, 'interval' => 1, 'parameters' => $parameters));
  $li_next = theme('pager_next', array('text' => (isset($tags[3]) ? $tags[3] : t('next ›')), 'element' => $element, 'interval' => 1, 'parameters' => $parameters));
  $li_last = theme('pager_last', array('text' => (isset($tags[4]) ? $tags[4] : t('last »')), 'element' => $element, 'parameters' => $parameters));

  if ($pager_total[$element] > 1) {
    if ($li_first) {
      $items[] = array(
          'class' => array('pager-first'),
          'data' => $li_first,
      );
    }
    if ($li_previous) {
      $items[] = array(
          'class' => array('pager-previous'),
          'data' => $li_previous,
      );
    }

    // When there is more than one page, create the pager list.
    if ($i != $pager_max) {
      if ($i > 1) {
        $items[] = array(
            'class' => array('pager-ellipsis', 'disabled'),
            'data' => '<a href="#">…</a>',
        );
      }
      // Now generate the actual pager piece.
      for (; $i <= $pager_last && $i <= $pager_max; $i++) {
        if ($i < $pager_current) {
          $items[] = array(
              //'class' => array('pager-item'),
              'data' => theme('pager_previous', array('text' => $i, 'element' => $element, 'interval' => ($pager_current - $i), 'parameters' => $parameters)),
          );
        }
        if ($i == $pager_current) {
          $items[] = array(
              'class' => array('pager-current', 'disabled'),
              'data' => '<a href="#">' . $i . '</a>',
          );
        }
        if ($i > $pager_current) {
          $items[] = array(
              //'class' => array('pager-item'),
              'data' => theme('pager_next', array('text' => $i, 'element' => $element, 'interval' => ($i - $pager_current), 'parameters' => $parameters)),
          );
        }
      }
      if ($i < $pager_max) {
        $items[] = array(
            'class' => array('pager-ellipsis', 'disabled'),
            'data' => '<a href="#">…</a>',
        );
      }
    }
    // End generation.
    if ($li_next) {
      $items[] = array(
          'class' => array('pager-next'),
          'data' => $li_next,
      );
    }
    if ($li_last) {
      $items[] = array(
          'class' => array('pager-last'),
          'data' => $li_last,
      );
    }
    return '<h2 class="element-invisible">' . t('Pages') . '</h2>' . '<div class="' . implode(' ', array('pagination', 'pagination-centered')) . '">' . theme('item_list', array(
                'items' => $items,
                    //'attributes' => array('class' => array('pagination')),
            )) . '</div>';
  }
}