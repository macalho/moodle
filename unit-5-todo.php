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
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * "To Do" homework from Moodle Dev course - Unit 5.
 *
 * @package    unit-5-todo
 * @copyright  2015 Marcelo Carvalho
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

global $DB;

require_once(__DIR__ . '/config.php');
require_once ($CFG->dirroot . '/lib/datalib.php');
require_once ($CFG->dirroot . '/lib/weblib.php');
require_once ($CFG->dirroot . '/lib/moodlelib.php');

// The function format_string needs the context set,
// I believe it can't find magically on root folder level
$PAGE->set_context(context_system::instance());

$startinterval = make_timestamp('2006','10','01');
//$finalinterval = make_timestamp('2007','12','01');
$finalinterval = make_timestamp('2015','12','01');

$sql = "SELECT c.id, c.shortname, c.fullname
          FROM {course} c
         WHERE c.timecreated > ($startinterval)
           AND c.timecreated < ($finalinterval)";

$courses = $DB->get_records_sql($sql);

// apresenta mais detalhes do que print_r (o tipo de dados nos campos)
//var_dump($courses);
//echo '<pre>'; print_r($courses); echo '</pre>';

$output = '';
$i = 0;

if ($courses != null) {
    foreach ($courses as $course) {
        $i++;
        $shortname = format_string($course->shortname);
        $fullname = format_string($course->fullname);

        $output .= $i . ' - ' . get_string('course') . ':<br />';
        $output .= 'ID: ' . $course->id . '<br />';
        $output .= get_string('shortname') . ': ' . $shortname . '<br />';
        $output .= get_string('fullname') . ': ' . $fullname . '<br />';
        $output .= '<br /><br />';
    }
    echo $output;
}
