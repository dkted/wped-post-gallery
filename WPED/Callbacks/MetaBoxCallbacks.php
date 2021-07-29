<?php

namespace WPED\Callbacks;

class MetaBoxCallbacks
{
	public function gallery($post, $metabox)
	{
		$metaboxID = $metabox['id'];
		$postID = $post->ID;

		wp_nonce_field($metaboxID.'_data', $metaboxID.'_nonce');

		$metaboxValue = get_post_meta($post->ID, $metaboxID, true);

		if ( $metaboxValue === '' ) {
			$metaboxValue = [
				'title' => '',
				'images' => []
			];
		}
		include_once WPEDPG_PATH .'/templates/post-gallery.php';
	}
}