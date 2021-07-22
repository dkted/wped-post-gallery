<?php

namespace WPED\Base;

class Activate
{
	public static function activate()
	{
		flush_rewrite_rules();

		if (get_option( WPEDPG_NAME )) {
			return;
		}

		if (!get_option( WPEDPG_NAME )) {
			update_option(WPEDPG_NAME, []);
		}
	}
}