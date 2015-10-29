<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle. If not, see <http://www.gnu.org/licenses/>.

/**
 * "To Do" homework from Moodle Dev course - Unit 7.
 *
 * @package block/simplehtml
 * @copyright 2015 Marcelo Carvalho
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once("$CFG->libdir/formslib.php");

class simplehtml_form extends moodleform {

    function definition() {
        global $CFG;

        $mform =& $this->_form;

        // add group for text areas
        $mform->addElement('header', 'displayinfo', get_string('textfields', 'block_simplehtml'));

        // add page title element
        $mform->addElement('text','pagetitle', get_string('formtitle','block_simplehtml'));
        $mform->addRule('pagetitle', null, 'required', null, 'client');
        $mform->setType('pagetitle', PARAM_RAW);
    }
}