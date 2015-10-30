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
 * A block which displays simple html pages.
 *
 * @package block_simplehtml
 * @copyright 2015 Marcelo Carvalho
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * The simplehtml block class definition.
 *
 * @package    block_simplehtml
 * @copyright  2015 Marcelo Carvalho
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_simplehtml extends block_list {

    public function init() {
        $this->title = get_string ( 'simplehtml', 'block_simplehtml' );
    }

    public function get_content() {
        if ($this->content !== null) {
            return $this->content;
        }

        global $COURSE, $CFG;

        $this->content = new stdClass ();
        $this->content->items  = array();
        $this->content->icons  = array();

        if (empty ( $this->config->text )) {
            $this->content->text = get_string ( 'defaulttext', 'block_simplehtml' );
        } else {
            $this->content->text = $this->config->text;

            if (get_config ( 'simplehtml', 'Allow_HTML' ) == '0') {
                $this->content->text = strip_tags( $this->config->text );
            }
        }

        $url = $CFG->wwwroot . '/blocks/simplehtml';
        $this->content->items[] = html_writer::tag('a', 'Form test', array(
                'href' => $url .'/view.php?blockid=' . $this->instance->id . '&courseid='. $COURSE->id));

        $this->content->footer = 'Footer here...';

        return $this->content;
    }

    public function specialization() {
        if (isset ( $this->config )) {
            if (empty ( $this->config->title )) {
                $this->title = get_string ( 'defaulttitle', 'block_simplehtml' );
            } else {
                $this->title = $this->config->title;
            }

            if (empty ( $this->config->text )) {
                $this->config->text = get_string ( 'defaulttext', 'block_simplehtml' );
            }
        }
    }

    public function has_config() {
        return true;
    }

    public function instance_config_save($data, $nolongerused = false) {
        if (get_config ( 'simplehtml', 'Allow_HTML' ) == '0') {
            $data->text = strip_tags ( $data->text );
        }

        // And now forward to the default implementation defined in the parent class
        return parent::instance_config_save ( $data );
    }
}