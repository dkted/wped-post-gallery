<?php

namespace WPED\Base;

class CustomPostTypeController
{
    public function register()
    {
        add_action('init', array($this, 'registerPostType'));
    }

    public function registerPostType()
    {
        $name = 'PREMIERE Event';
        $plural_name = 'PREMIERE Events';

        $values = [
            'labels' => [
                'name'                  => $plural_name,
                'singular_name'         => $name,
                'menu_name'             => $plural_name,
                'name_admin_bar'        => $name,
                'archives'              => $name .' Archives',
                'attributes'            => $name .' Attributes',
                'parent_item_colon'     => 'Parent '. $name,
                'all_items'             => 'All '. $name,
                'add_new_item'          => 'Add New '. $name,
                'add_new'               => 'Add New',
                'new_item'              => 'New '. $name,
                'edit_item'             => 'Edit '. $name,
                'update_item'           => 'Update '. $name,
                'view_item'             => 'View '. $name,
                'view_items'            => 'View '. $plural_name,
                'search_items'          => 'Search '. $plural_name,
                'not_found'             => 'No '. $name .' Found',
                'not_found_in_trash'    => 'No '. $name .' Found in Trash',
                'featured_image'        => 'Featured Image',
                'set_featured_image'    => 'Set Featured Image',
                'remove_featured_image' => 'Remove Featured Image',
                'use_featured_image'    => 'Use Featured Image',
                'insert_into_item'      => 'Insert into '. $name,
                'uploaded_to_this_item' => 'Upload to this '. $name,
                'items_list'            => $plural_name .' List',
                'items_list_navigation' => $plural_name .' List Navigation',
                'filter_items_list'     => 'Filter '. $plural_name .' List'
            ],
            'label'                     => $name,
            'description'               => $plural_name .' Custom Post Type',
            'supports'                  => ['title', 'editor', 'thumbnail'],
            'taxonomies'                => ['category', 'post_tag'],
            'hierarchical'              => false,
            'public'                    => true,
            'show_ui'                   => true,
            'show_in_menu'              => true,
            'menu_position'             => 5,
            'show_in_admin_bar'         => true,
            'show_in_nav_menus'         => true,
            'can_export'                => true,
            'has_archive'               => true,
            'exclude_from_search'       => false,
            'publicly_queryable'        => true,
            'capability_type'           => 'post',
            'show_in_rest'				=> true,
        ];

        register_post_type( WPEDPG_POST_TYPE, $values);
    }
}