<?php

namespace WPED\Base;

use Exception;
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
                'id'                => WPEDPG_METABOX_ID,
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

        add_action('wp_ajax_wpedpg_gallery', [$this, 'ajaxImportIds']);
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
            $metaboxID = $metabox['id'];
            $title = $metaboxID .'_title';
            $videoUrl = $metaboxID .'_video_url';

            if (isset($_POST[$title]) && $this->validateField($post_id, $metaboxID)) {
                $title_data = sanitize_text_field($_POST[$title]);
                $videoUrl_data = sanitize_text_field($_POST[$videoUrl]);
                $images_data = isset($_POST[$metaboxID.'_images'])? $_POST[$metaboxID.'_images'] : [];
                
                $data = [
                    'title' => $title_data,
                    'video_url' => $videoUrl_data,
                    'images' => $images_data,
                ];
                update_post_meta($post_id, $metaboxID, $data);
            }
        }
    }
    
    public function ajaxImportIds()
    {
        $response = [
            'status' => '',
            'data' => ['postID' => 0, 'images' => [], 'newImages' => []]
        ];
        try {
            $data = json_decode(stripslashes($_POST['data']));
            $meta = get_post_meta(intval($data->{'postID'}), WPEDPG_METABOX_ID, true);
                        
            $images = array_unique(
                array_merge($meta['images'], $data->{'ids'})
            );

            $response['data']['postID'] = $data->{'postID'};
            $response['data']['newImages'] = count($data->{'ids'}) > 0? $data->{'ids'} : [];
            $response['data']['images'] = $meta['images'];
            
            $meta['images'] = $images;

            $response['status'] = 'Success';

            update_post_meta( $data->{'postID'}, WPEDPG_METABOX_ID, $meta );
            
        } catch(Exception $ex) {
            $response['status'] = 'Failed';
        }

        wp_send_json($response);
        wp_die();
    }

}