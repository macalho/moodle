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
 * A custom form to create a simple html page.
 *
 * @package block_simplehtml
 * @copyright 2015 Marcelo Carvalho
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once($CFG->libdir . '/formslib.php');
require_once($CFG->dirroot . '/blocks/simplehtml/lib.php');

/**
 * The simplehtml_form class definition.
 *
 * @package    block_simplehtml
 * @copyright  2015 Marcelo Carvalho
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class simplehtml_form extends moodleform {

    function definition() {
        global $CFG, $COURSE;

        $mform =& $this->_form;
        $maxbytes = 2000000;

        // Add group for text areas
        $mform->addElement('header', 'displayinfo', get_string('textfields', 'block_simplehtml'));

        // Add page title element
        $mform->addElement('text', 'pagetitle', get_string('formtitle','block_simplehtml'));
        $mform->addRule('pagetitle', null, 'required', null, 'client');
        $mform->setType('pagetitle', PARAM_RAW);

        // Add html text editor
        $mform->addElement('editor', 'displaytext', get_string('displaytext', 'block_simplehtml'));
        $mform->setType('displaytext', PARAM_RAW);

        // Add filename selection
        $mform->addElement('filepicker', 'filename', get_string('displayfile', 'block_simplehtml'), null,
                array('maxbytes'        => $maxbytes,
                      'accepted_types'  => '*',
                      'courseid'        => $COURSE->id
                ));

        // Add group for picture fields
        $mform->addElement('header', 'pictureinfo', get_string('picturefields', 'block_simplehtml'));

        $mform->addElement('selectyesno', 'displaypicture', get_string('displaypicture', 'block_simplehtml'));

        // Add image selector radio buttons
        $images = block_simplehtml_images();
        $radioarray = array();
        for ($i = 0; $i < count($images); $i++) {
            $radioarray[] =&$mform->createElement('radio', 'picture', '', $images[$i], $i);
        }

        $mform->addGroup($radioarray, 'radioar', get_string('pictureselect', 'block_simplehtml'), array(' '), false);

        // Add description field
        $attributes = array('size'=>'50', 'maxlength'=>'100');
        $mform->addElement('text', 'description', get_string('picturedesc', 'block_simplehtml'), $attributes);
        $mform->setType('description', PARAM_TEXT);
        $mform->setAdvanced('pictureinfo');

        // Add group for optional fields
        $mform->addElement('header', 'optional', get_string('optional','form'));

        // Add date_time selector in optional area
        $mform->addElement('date_time_selector', 'displaydate', get_string('displaydate', 'block_simplehtml'), array('optional'=>true));
        $mform->setAdvanced('optional');

        // Add hidden elements to store page parameters
        $mform->addElement('hidden', 'blockid');
        $mform->setType('blockid', PARAM_INT);
        $mform->addElement('hidden', 'courseid');
        $mform->setType('courseid', PARAM_INT);

        // Add save and cancel buttons
        $this->add_action_buttons();
    }
}