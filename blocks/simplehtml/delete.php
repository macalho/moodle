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
 * A form to delete a simple html page.
 *
 * @package block_simplehtml
 * @copyright 2015 Marcelo Carvalho
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once ('../../config.php');

global $CFG, $DB, $USER;

$id = required_param('id', PARAM_INT);
$courseid = required_param('courseid', PARAM_INT);
$confirm = optional_param('confirm', 0, PARAM_INT);

$course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);
$context = context_course::instance($courseid);

require_login($course);

require_capability('block/simplehtml:managepages', $context);

$url = new moodle_url($CFG->wwwroot . '/blocks/simplehtml/delete.php');
$PAGE->set_url($url, array('id' => $id, 'courseid' => $courseid));

$simplehtmlpage = $DB->get_record('block_simplehtml', array('id' => $id), '*', MUST_EXIST);

echo $OUTPUT->header();

if(!$confirm){
    $optionsno = array('id' => $courseid);
    $optionsyes = array (
            'id'        => $id,
            'courseid'  => $courseid,
            'confirm'   => 1,
            'sesskey'   => sesskey()
    );
    echo $OUTPUT->heading(get_string('confirmdelete', 'block_simplehtml'));

    echo $OUTPUT->confirm(get_string('deletemessage', 'block_simplehtml', $simplehtmlpage),
                    new moodle_url($CFG->wwwroot . '/blocks/simplehtml/delete.php', $optionsyes),
                    new moodle_url($CFG->wwwroot . '/course/view.php', $optionsno));
}
else {
    if (confirm_sesskey()) {
        if (! $DB->delete_records('block_simplehtml', array('id' => $id))) {
            echo $OUTPUT->error_text(get_string('deleterror', 'block_simplehtml'));
        } else {
            // Create and dispatching the event to log the deletion on the database
            $event = \block_simplehtml\event\page_deleted::create(array(
                    // 'context' value is needed by \core\event\base
                    'context' => $context,
                    'userid' => $USER->id,
                    'objectid' => $id,
                    'courseid' => $courseid,
                    'other' => array(
                            'triggeredfrom' => get_string('pluginname', 'block_simplehtml')
                    )
            ));
            $event->trigger();
        }
    } else {
        echo $OUTPUT->error_text(get_string('sessionerror', 'block_simplehtml'));
    }
    redirect(new moodle_url($CFG->wwwroot . '/course/view.php', array('id' => $courseid)));
}

echo $OUTPUT->footer();
die();