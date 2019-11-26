<?php
require_once get_template_directory() . '/includes/options-config.php';
require_once get_template_directory() . '/admin/control-icon-picker.php';
	if( ! class_exists('Greed_Customizer_API_Wrapper') ) {
		require_once get_template_directory() . '/admin/class.greed-customizer-api-wrapper.php';
	}


Greed_Customizer_API_Wrapper::getInstance($options);
