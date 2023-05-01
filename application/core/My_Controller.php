<?php
/**
 * Coded by: Pran Krishna Das
 * Social: www.fb.com/pran93
 * Coded for: www.sketchmeglobal.com
 * CI: 3.0.6
 * Purpose:
 * Date: 30-09-2016
 * Time: 12:18
 */

Class My_Controller extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->db->query('SET sql_mode =  "ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION"');
    }

}