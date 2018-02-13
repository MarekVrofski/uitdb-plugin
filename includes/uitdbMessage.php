<?php
/**
 * Created by PhpStorm.
 * User: markprive
 * Date: 12/02/2018
 * Time: 20:30
 */

class uitdbMessage
{
    private $_message;

    private $_messageType;

    function __construct( $message, $messageType ) {
        $this->_message = $message;
        $this->_messageType = $messageType;

        add_action( 'admin_notices', array( $this, 'render' ) );
    }

    function render() {
        printf( '<div class="notice notice-' . $this->_messageType . ' is-dismissible"><p>%s</p></div>', $this->_message );
    }
}