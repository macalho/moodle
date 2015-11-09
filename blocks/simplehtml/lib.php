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
 * Library functions for the simplehtml block
 *
 * @package block_simplehtml
 * @copyright 2015 Marcelo Carvalho
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Return a array with image elements to be selected by simple html page
 *
 * @return array A list of images
 */
function block_simplehtml_images() {
    global $CFG;
    return array('<img src="' . $CFG->wwwroot . '/blocks/simplehtml/pix/picture0.gif" alt="'.get_string('red', 'block_simplehtml').'">',
            '<img src="' . $CFG->wwwroot . '/blocks/simplehtml/pix/picture1.gif" alt="'.get_string('blue', 'block_simplehtml').'">',
            '<img src="' . $CFG->wwwroot . '/blocks/simplehtml/pix/picture2.gif" alt="'.get_string('green', 'block_simplehtml').'">');
}

/**
 * Print or return html content created from the Simple html page
 * form, the elements inserted on that form are loaded and treated
 * here to generate the html content.
 *
 * @param object $simplehtml The database record of one simple html page
 * @param int $contextid The current context id
 * @param bool $return Defines if this function prints or returns the content
 * @return string HTML content as string
 */
function block_simplehtml_print_page($simplehtml, $contextid, $return = FALSE) {
    global $CFG, $COURSE, $OUTPUT;

    $output = '';
    $br = html_writer::empty_tag('br');

    $output .= $OUTPUT->heading($simplehtml->pagetitle, 2, 'main');

    if ($simplehtml->displaydate) {
        $output .= html_writer::div(userdate($simplehtml->displaydate));
    }

    $output .= $br;
    $output .= $OUTPUT->box_start('generalbox');
    $output .= clean_text($simplehtml->displaytext);

    // Creating links of uploaded files
    $links = array();
    $fs = get_file_storage();
    $files = $fs->get_area_files($contextid, 'block_simplehtml', 'page', $simplehtml->id);
    foreach ($files as $file) {
        $filename = $file->get_filename();
        if ($filename !== '.') // removing the indication of the current folder
        {
            $url = moodle_url::make_pluginfile_url($file->get_contextid(), $file->get_component(),
                            $file->get_filearea(), $file->get_itemid(),
                            $file->get_filepath(), $file->get_filename());
            $links[] = html_writer::link($url, $filename);
        }
    }
    $output .= implode($br, $links);

    $output .= $OUTPUT->box_end();
    $output .= $br;

    if ($simplehtml->displaypicture) {
        $images = block_simplehtml_images();
        $output .= $OUTPUT->box_start('generalbox');
        $output .= $images[$simplehtml->picture];
        $output .= $br;
        $output .= $simplehtml->description;
        $output .= $OUTPUT->box_end();
    }

    if ($return) {
        return $output;
    } else {
        echo $output;
    }
}

/**
 * Print or return html content created from the Simple html page
 * form, the elements inserted on that form are loaded and treated
 * here to generate the html content.
 *
 * @param object $course The database record of a course
 * @param object $cm The course module object
 * @param object $context The context_course object
 * @param string $filearea One of the elements that helps identify a file area
 * @param array $args Have items that helps locate a single file
 * @param bool $forcedownload If true (default false), forces download of file rather than view in browser/plugin
 * @param array $options additional options affecting the file serving
 * @return string HTML content as string
 */
function block_simplehtml_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options=array()) {
    // Check the contextlevel is as expected
    if ($context->contextlevel != CONTEXT_COURSE) {
        return false;
    }

    // Make sure the filearea is one of those used by the plugin.
    if ($filearea !== 'page' && $filearea !== 'post') {
        return false;
    }

    require_login($course);

    // Check the relevant capabilities
    if (!has_capability('block/simplehtml:viewpages', $context)) {
        return false;
    }

    $itemid = array_shift($args); // The first item in the $args array.

    // Extract the filename / filepath from the $args array.
    $filename = array_pop($args); // The last item in the $args array.
    if (!$args) {
        $filepath = '/'; // $args is empty => the path is '/'
    } else {
        $filepath = '/'.implode('/', $args).'/'; // $args contains elements of the filepath
    }

    // Retrieve the file from the Files API.
    $fs = get_file_storage();
    $file = $fs->get_file($context->id, 'block_simplehtml', $filearea, $itemid, $filepath, $filename);
    if (!$file) {
        return false; // The file does not exist.
    }

    // We can now send the file back to the browser - in this case with a cache lifetime of 1 day and no filtering.
    send_stored_file($file, 86400, 0, $forcedownload, $options);
}