<?php

function visia_form_system_theme_settings_alter(&$form, $form_state) {


  $form['settings'] = array(
      '#type' => 'vertical_tabs',
      '#title' => t('Theme settings'),
      '#weight' => 2,
      '#collapsible' => TRUE,
      '#collapsed' => FALSE,
  );

  $form['settings']['general'] = array(
      '#type' => 'fieldset',
      '#title' => t('General settings'),
      '#collapsible' => TRUE,
      '#collapsed' => FALSE,
  );
  $form['settings']['general']['enable_breadcrumb'] = array(
      '#type' => 'checkbox',
      '#title' => t('Use breadcrumb'),
      '#default_value' => theme_get_setting('enable_breadcrumb'),
  );
  $form['settings']['general']['use_parallax'] = array(
      '#type' => 'checkbox',
      '#title' => t('Use Parallax'),
      '#default_value' => theme_get_setting('use_parallax'),
  );
  $form['settings']['general']['content_column_size'] = array(
      '#type' => 'select',
      '#title' => t('Content column size'),
      '#default_value' => theme_get_setting('content_column_size'),
      '#description' => t('Change size of main content column, default is 4'),
      '#options' => array(
          1 => 1,
          2 => 2,
          3 => 3,
          4 => 4,
          5 => 5,
      ),
  );
  // bg background
  $dir = drupal_get_path('theme', 'visia') . DIRECTORY_SEPARATOR . 'stylesheets' . DIRECTORY_SEPARATOR . 'colors';

  $files = file_scan_directory($dir, '/.*\.css/');


  $css_files = array();
  if (!empty($files)) {
    foreach ($files as $file) {
      if (isset($file->filename)) {
        $css_files[$file->filename] = $file->filename;
      }
    }
  }

  $form['settings']['general']['theme_color'] = array(
      '#type' => 'select',
      '#title' => t('Default theme color'),
      '#default_value' => theme_get_setting('theme_color'),
      '#description' => t('Colors availabe in <strong>!path/stylesheets/colors</strong> , you could also create new custom css file put in that directory and system will auto detects your css file.', array('!path' => base_path() . drupal_get_path('theme', 'visia'))),
      '#options' => $css_files,
  );

  $form['settings']['general']['custom_theme_css'] = array(
      '#type' => 'textarea',
      '#title' => t('Custom theme css'),
      '#default_value' => theme_get_setting('custom_theme_css'),
      '#description' => t('Custom your own css, eg: <strong>#page-title h2{color: #060606;}</strong>'),
  );
  
}
