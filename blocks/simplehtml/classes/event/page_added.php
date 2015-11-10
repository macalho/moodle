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
 * Page added event
 *
 * @package block_simplehtml
 * @copyright 2015 Marcelo Carvalho
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace block_simplehtml\event;

defined('MOODLE_INTERNAL') || die();

/**
 * The page_added event class.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - string triggeredfrom: name of the element from where event was triggered.
 * }
 *
 * @since     Moodle 2.6
 * @copyright 2015 Marcelo Carvalho
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 **/
class page_added extends \core\event\base {

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['crud'] = 'c'; // c(reate), r(ead), u(pdate), d(elete)
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
        $this->data['objecttable'] = 'block_simplehtml';
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventpageadded', 'block_simplehtml');
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' has added a simple html page" .
                " with id '$this->objectid' from course id '$this->courseid'.";
    }

    /**
     * Get URL related to the action.
     *
     * @return \moodle_url
     */
    public function get_url() {
        return new \moodle_url('/blocks/simplehtml/view.php', array(
                'blockid'   => $this->objectid,
                'courseid'  => $this->courseid
        ));
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();

        if (!isset($this->other['triggeredfrom'])) {
            throw new \coding_exception('The \'triggeredfrom\' value must be set in other.');
        }
    }
}