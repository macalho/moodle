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
 * The form page to process the creation of a simple html page.
 *
 * @package block_simplehtml
 * @copyright 2015 Marcelo Carvalho
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once('simplehtml_form.php');

global $CFG, $DB, $USER;

$blockid = required_param('blockid', PARAM_INT);
$courseid = required_param('courseid', PARAM_INT);
$course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);

require_login($course);

$url = new moodle_url($CFG->wwwroot . '/blocks/simplehtml/view.php');
$PAGE->set_url($url, array('blockid' => $blockid, 'courseid' => $courseid));
$PAGE->set_title(get_string ('formtitle', 'block_simplehtml'));
$PAGE->set_heading(get_string ('headerpage', 'block_simplehtml'));

$simplehtmlform = new simplehtml_form();

$toform['blockid'] = $blockid;
$toform['courseid'] = $courseid;
$simplehtmlform->set_data($toform);

// Form state control
if ($simplehtmlform->is_cancelled()) {
    // Cancelled forms redirect to course main page
    redirect(new moodle_url($CFG->wwwroot . '/course/view.php?id=' . $courseid));
} else if ($fromform = $simplehtmlform->get_data()) {
    // Handling the 'displaytext' element data, it came as array,
    // we must separate before store it or insert_record can't find the data correctly
    $fromform->format = $fromform->displaytext['format'];
    $fromform->displaytext = $fromform->displaytext['text'];

    // Get the file name to store it
    $name = $simplehtmlform->get_new_filename('filename');
    $fromform->filename = $name;

    // Submitted data has been validated, we can store it now
    $lastinsertid = $DB->insert_record('block_simplehtml', $fromform, true);

    // Create and dispatching the event to log the insert on the database
    $event = \block_simplehtml\event\page_added::create ( array (
            // 'context' value is needed by \core\event\base
            'context' => context_course::instance($courseid),
            'userid' => $USER->id,
            'objectid' => $lastinsertid,
            'courseid' => $courseid,
            'other' => array(
                    'blockid' => $blockid,
                    'triggeredfrom' => get_string('triggeredfrom', 'block_simplehtml')
            )
    ));
    $event->trigger();

    // Redirect after save the data
    redirect(new moodle_url($CFG->wwwroot . '/course/view.php?id=' . $courseid));
} else {
    // Form didn't validate or this is the first display
    echo $OUTPUT->header();

    $simplehtmlform->display();

    echo $OUTPUT->footer();
    die();
}