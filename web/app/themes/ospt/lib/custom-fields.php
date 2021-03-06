<?php

if( function_exists('acf_add_local_field_group') ):

  acf_add_local_field_group(array (
      'key' => 'group_55783005a3974',
      'title' => 'Category',
      'fields' => array (
          array (
              'key' => 'field_55783009d0ba5',
              'label' => 'Category',
              'name' => 'category',
              'type' => 'taxonomy',
              'instructions' => '',
              'required' => 1,
              'conditional_logic' => 0,
              'wrapper' => array (
                  'width' => '',
                  'class' => '',
                  'id' => '',
              ),
              'taxonomy' => 'category',
              'field_type' => 'select',
              'allow_null' => 0,
              'add_term' => 0,
              'load_save_terms' => 1,
              'return_format' => 'object',
              'multiple' => 0,
              'load_terms' => 0,
              'save_terms' => 1,
          ),
      ),
      'location' => array (
          array (
              array (
                  'param' => 'post_type',
                  'operator' => '==',
                  'value' => 'post',
              ),
          ),
      ),
      'menu_order' => 0,
      'position' => 'side',
      'style' => 'default',
      'label_placement' => 'top',
      'instruction_placement' => 'label',
      'hide_on_screen' => '',
      'active' => 1,
      'description' => '',
  ));

  acf_add_local_field_group(array (
      'key' => 'group_55794a1653ef5',
      'title' => 'Content',
      'fields' => array (
          array (
              'key' => 'field_55794a1b32019',
              'label' => 'Content',
              'name' => 'content',
              'type' => 'wysiwyg',
              'instructions' => '',
              'required' => 1,
              'conditional_logic' => 0,
              'wrapper' => array (
                  'width' => '',
                  'class' => '',
                  'id' => '',
              ),
              'default_value' => '',
              'tabs' => 'all',
              'toolbar' => 'full',
              'media_upload' => 1,
          ),
      ),
      'location' => array (
          array (
              array (
                  'param' => 'post_type',
                  'operator' => '==',
                  'value' => 'post',
              ),
              array (
                  'param' => 'post_category',
                  'operator' => '==',
                  'value' => 'category:news',
              ),
          ),
      ),
      'menu_order' => 0,
      'position' => 'normal',
      'style' => 'default',
      'label_placement' => 'top',
      'instruction_placement' => 'label',
      'hide_on_screen' => '',
      'active' => 1,
      'description' => '',
  ));

  acf_add_local_field_group(array (
      'key' => 'group_55782c75ad4cd',
      'title' => 'Document',
      'fields' => array (
          array (
              'key' => 'field_55782c7acba06',
              'label' => 'Document',
              'name' => 'document',
              'type' => 'file',
              'instructions' => '',
              'required' => 1,
              'conditional_logic' => 0,
              'wrapper' => array (
                  'width' => '',
                  'class' => '',
                  'id' => '',
              ),
              'return_format' => 'url',
              'library' => 'all',
              'min_size' => '',
              'max_size' => '',
              'mime_types' => '.doc, .docx, .pdf',
          ),
      ),
      'location' => array (
          array (
              array (
                  'param' => 'post_type',
                  'operator' => '==',
                  'value' => 'post',
              ),
              array (
                  'param' => 'post_category',
                  'operator' => '==',
                  'value' => 'category:office-notices',
              ),
          ),
      ),
      'menu_order' => 0,
      'position' => 'normal',
      'style' => 'default',
      'label_placement' => 'top',
      'instruction_placement' => 'label',
      'hide_on_screen' => '',
      'active' => 1,
      'description' => '',
  ));

  acf_add_local_field_group(array (
      'key' => 'group_5581765055379',
      'title' => 'Document Downloads',
      'fields' => array (
          array (
              'key' => 'field_55817654f4231',
              'label' => 'Document Downloads',
              'name' => 'document_downloads',
              'type' => 'repeater',
              'instructions' => '',
              'required' => 0,
              'conditional_logic' => 0,
              'wrapper' => array (
                  'width' => '',
                  'class' => '',
                  'id' => '',
              ),
              'min' => '',
              'max' => '',
              'layout' => 'block',
              'button_label' => 'Add Row',
              'sub_fields' => array (
                  array (
                      'key' => 'field_5581765ff4232',
                      'label' => 'Title',
                      'name' => 'title',
                      'type' => 'text',
                      'instructions' => '',
                      'required' => 1,
                      'conditional_logic' => 0,
                      'wrapper' => array (
                          'width' => '',
                          'class' => '',
                          'id' => '',
                      ),
                      'default_value' => '',
                      'placeholder' => '',
                      'prepend' => '',
                      'append' => '',
                      'maxlength' => '',
                      'readonly' => 0,
                      'disabled' => 0,
                  ),
                  array (
                      'key' => 'field_55817665f4233',
                      'label' => 'File',
                      'name' => 'file',
                      'type' => 'file',
                      'instructions' => '',
                      'required' => 1,
                      'conditional_logic' => 0,
                      'wrapper' => array (
                          'width' => '',
                          'class' => '',
                          'id' => '',
                      ),
                      'return_format' => 'url',
                      'library' => 'all',
                      'min_size' => '',
                      'max_size' => '',
                      'mime_types' => '',
                  ),
              ),
          ),
      ),
      'location' => array (
          array (
              array (
                  'param' => 'post_type',
                  'operator' => '==',
                  'value' => 'page',
              ),
          ),
          array (
              array (
                  'param' => 'page_parent',
                  'operator' => '!=',
                  'value' => '685',
              ),
          ),
      ),
      'menu_order' => 0,
      'position' => 'normal',
      'style' => 'default',
      'label_placement' => 'top',
      'instruction_placement' => 'label',
      'hide_on_screen' => '',
      'active' => 1,
      'description' => '',
  ));

  acf_add_local_field_group(array (
      'key' => 'group_557eb934b336b',
      'title' => 'Related Links',
      'fields' => array (
          array (
              'key' => 'field_557eb93a3bf4f',
              'label' => 'Links',
              'name' => 'links',
              'type' => 'repeater',
              'instructions' => '',
              'required' => 0,
              'conditional_logic' => 0,
              'wrapper' => array (
                  'width' => '',
                  'class' => '',
                  'id' => '',
              ),
              'min' => '',
              'max' => '',
              'layout' => 'block',
              'button_label' => 'Add Row',
              'sub_fields' => array (
                  array (
                      'key' => 'field_557eb9403bf50',
                      'label' => 'Title',
                      'name' => 'title',
                      'type' => 'text',
                      'instructions' => '',
                      'required' => 1,
                      'conditional_logic' => 0,
                      'wrapper' => array (
                          'width' => '',
                          'class' => '',
                          'id' => '',
                      ),
                      'default_value' => '',
                      'placeholder' => '',
                      'prepend' => '',
                      'append' => '',
                      'maxlength' => '',
                      'readonly' => 0,
                      'disabled' => 0,
                  ),
                  array (
                      'key' => 'field_557eb94a3bf51',
                      'label' => 'Link',
                      'name' => 'link',
                      'type' => 'url',
                      'instructions' => '',
                      'required' => 1,
                      'conditional_logic' => 0,
                      'wrapper' => array (
                          'width' => '',
                          'class' => '',
                          'id' => '',
                      ),
                      'default_value' => '',
                      'placeholder' => '',
                  ),
              ),
          ),
      ),
      'location' => array (
          array (
              array (
                  'param' => 'post_type',
                  'operator' => '==',
                  'value' => 'page',
              ),
          ),
          array (
              array (
                  'param' => 'page',
                  'operator' => '!=',
                  'value' => '685',
              ),
          ),
      ),
      'menu_order' => 0,
      'position' => 'normal',
      'style' => 'default',
      'label_placement' => 'top',
      'instruction_placement' => 'label',
      'hide_on_screen' => '',
      'active' => 1,
      'description' => '',
  ));

endif;
