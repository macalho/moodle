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