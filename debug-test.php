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
 * Simple debug test page.
 *
 * @package    simple_debug_test
 * @copyright  2015 Marcelo Carvalho
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/config.php');
require_once($CFG->libdir . '/datalib.php');

echo 'Output with print_object(): ';
print_object($CFG->wwwroot);
echo '<br /><br />';

echo 'Output with print(): ';
print($CFG->wwwroot);
echo '<br /><br /><br />';

echo 'Output with "echo": ';
echo "$CFG->wwwroot";
echo '<br /><br /><br />';

echo 'Nome do servidor: ';
echo $_SERVER['SERVER_NAME'];
echo '<br /><br /><br />';

echo 'Document root: ';
echo $_SERVER['DOCUMENT_ROOT'];
echo '<br /><br /><br />';

echo '__DIR__: ';
echo __DIR__;
echo '<br /><br /><br />';

echo '__FILE__: ';
echo __FILE__;
echo '<br /><br /><br />';







