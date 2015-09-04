<?php

class MY_Router extends CI_Router {

function _set_request($segments = array()){
parent::_set_request(str_replace('-', '_', $segments));
}

}
