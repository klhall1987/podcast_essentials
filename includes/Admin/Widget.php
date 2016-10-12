<?php if ( ! defined( 'ABSPATH' ) ) exit;

class PE_Admin_Widget
{
    private $_template = 'widget-call-to-action';

    public function __construct()
    {
        $this->get_template( $this->_template );
    }

    public function get_template( $template )
    {
        Podcast_Essentials::$instance->load_templates( $template );
    }

}