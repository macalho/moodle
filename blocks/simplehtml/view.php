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

require_once('../../config.php');
require_once('simplehtml_form.php');

global $CFG, $DB, $USER;

$courseid = required_param('id', PARAM_INT);
$course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);

require_login($course);

$url = new moodle_url($CFG->wwwroot . '/blocks/simplehtml/view.php?id=' . $courseid);
$PAGE->set_url($url, array('id' => $courseid));
$PAGE->set_title(get_string ('formtitle', 'block_simplehtml'));
$PAGE->set_heading(get_string ('headerpage', 'block_simplehtml'));

$simplehtmlform = new simplehtml_form();

// Form state control
if ($simplehtmlform->is_cancelled()) {
    // Cancelled forms redirect to course main page
    redirect("$CFG->wwwroot . '/course/view.php?id=' . $courseid");
} else if ($fromform = $simplehtmlform->get_data()) {
    // Submitted data has been validated, we can store it now
    redirect("$CFG->wwwroot . '/course/view.php?id=' . $courseid");
} else {
    // Form didn't validate or this is the first display
    echo $OUTPUT->header();

    $simplehtmlform->display();

    echo $OUTPUT->footer();
    die();
}