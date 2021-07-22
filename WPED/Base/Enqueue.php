<?php

namespace WPED\Base;

class Enqueue
{
	public function register()
	{
		add_action('admin_enqueue_scripts', [$this, 'enqueue']);
	}

	public function enqueue()
	{
		wp_enqueue_media();
        wp_enqueue_style(WPEDPG .'_style', WPEDPG_URL .'assets/wpedpg.css');
        wp_enqueue_script(WPEDPG .'_script', WPEDPG_URL .'assets/wpedpg.js');
	}
}