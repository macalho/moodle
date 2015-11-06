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
 * @package  block_simplehtml
 * @category block
 *
 * @return array
 */
function block_simplehtml_images() {
    global $CFG;
    return array('<img src="' . $CFG->wwwroot . '/blocks/simplehtml/pix/picture0.gif" alt="'.get_string('red', 'block_simplehtml').'">',
            '<img src="' . $CFG->wwwroot . '/blocks/simplehtml/pix/picture1.gif" alt="'.get_string('blue', 'block_simplehtml').'">',
            '<img src="' . $CFG->wwwroot . '/blocks/simplehtml/pix/picture2.gif" alt="'.get_string('green', 'block_simplehtml').'">');
}

/*
function block_simplehtml_pluginfile($course, $context, $filearea, $args, $forcedownload, array $options=array()) {
    // Check the contextlevel is as expected
    if ($context->contextlevel != CONTEXT_BLOCK) {
        return false;
    }

    // Make sure the filearea is one of those used by the plugin.
    if ($filearea !== 'page' && $filearea !== 'post') {
        return false;
    }

    require_login($course, true);

    // Check the relevant capabilities
    if (!has_capability('block/simplehtml:viewpages', $context)) {
        return false;
    }

    // Leave this line out if you set the itemid to null in make_pluginfile_url (set $itemid to 0 instead).
    //$itemid = array_shift($args); // The first item in the $args array.

    // Use the itemid to retrieve any relevant data records and perform any security checks to see if the
    // user really does have access to the file in question.

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
*/