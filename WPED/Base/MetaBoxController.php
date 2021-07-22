<?php

namespace WPED\Base;

use WPED\Callbacks\MetaBoxCallbacks;

class MetaBoxController
{
    public $callbacks;

    public $metaboxes = [];

    public function register()
    {
        $this->callbacks = new MetaBoxCallbacks();

        $this->metaboxes = array(
            array(
                'id'                => 'wpedpg_event_gallery',
                'title'             => 'Event Gallery',
                'callback'          => array($this->callbacks, 'gallery'),
                'screen'            => WPEDPG_POST_TYPE,
                'context'           => 'advanced',
                'priority'          => 'default',
                'callback_args'     => null,
            ),
        );

        add_action('add_meta_boxes', array($this, 'addMetaBoxes'));

        add_action('save_post', array($this, 'savePost'));
    }

    public function addMetaBoxes()
    {
        foreach ($this->metaboxes as $metabox) {
            add_meta_box(
                $metabox['id'], 
                $metabox['title'], 
                $metabox['callback'], 
                $metabox['screen'], 
                $metabox['context'], 
                $metabox['priority'], 
                $metabox['callback_args'], 
            );
        }
    }
    
    public function validateField($post_id, $metaboxID)
    {
        $nonce          = $metaboxID .'_nonce';
        $nonce_data     = $metaboxID .'_data';
        $title          = $metaboxID .'_title';
        
        if (!isset($_POST[$nonce])) {
            return false;
        }
        if (!wp_verify_nonce($_POST[$nonce], $nonce_data)) {
            return false;
        }
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return false;
        }
        if (!current_user_can('edit_post', $post_id)) {
            return false;
        }
        if (!isset($_POST[$title])) {
            return false;
        }
        return true;
    }

    public function savePost($post_id)
    {
        foreach ($this->metaboxes as $metabox) {
            $title = $metabox['id'] . '_title';

            if (isset($_POST[$title]) && $this->validateField($post_id, $metabox['id'])) {
                $title_data = sanitize_text_field($_POST[$title]);
                $postImages = isset($_POST[$metabox['id'].'_images'])? $_POST[$metabox['id'].'_images'] : [];
                $images = [];

                foreach ($postImages as $index => $image) {
                    $images[] = [
                        'id' => $image['id'],
                        'url' => $image['url'],
                    ];
                }

                $data = [
                    'title' => $title_data,
                    'images' => $images,
                ];
                update_post_meta($post_id, $metabox['id'], $data);
            }
        }
    }
    
}