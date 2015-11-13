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
 * @package block_simplehtml
 * @copyright 2015 Marcelo Carvalho
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_simplehtml extends block_base {

    public function init() {
        $this->title = get_string('simplehtml', 'block_simplehtml');
    }

    public function get_content() {
        if ($this->content !== null) {
            return $this->content;
        }

        global $COURSE, $CFG, $DB, $PAGE;

        $this->content = new stdClass();

        $context = context_course::instance($COURSE->id);

        // Check user content config (without check capability, just to see if the config option really works)
        if (empty($this->config->text)) {
            $this->content->text = get_string('defaulttext', 'block_simplehtml');
        } else {
            $this->content->text = $this->config->text;
        }

        if (has_capability('block/simplehtml:viewpages', $context))
        {
            $canmanage = (has_capability('block/simplehtml:managepages', $context) &&
                            $PAGE->user_is_editing());
            $ultag = '';
            $url = $CFG->wwwroot . '/blocks/simplehtml';

            // List of previously saved pages
            $simplehtmlpages = $DB->get_records('block_simplehtml', array('blockid' => $this->instance->id));

            if (count($simplehtmlpages) > 0) {
                foreach ($simplehtmlpages as $simplehtmlpage) {
                    if ($canmanage) {
                        $editimage = html_writer::empty_tag('img', array(
                                'src' => $CFG->wwwroot . '/pix/t/edit.png',
                                'alt' => get_string('editpage', 'block_simplehtml')
                        ));
                        $edit = html_writer::tag('a', $editimage, array(
                                'href' => $url . '/page.php?blockid=' . $this->instance->id .
                                '&courseid=' . $COURSE->id . '&id=' . $simplehtmlpage->id
                        ));
                        $deleteimage = html_writer::empty_tag('img', array(
                                'src' => $CFG->wwwroot . '/pix/t/delete.png',
                                'alt' => get_string('deletepage', 'block_simplehtml')
                        ));
                        $delete = html_writer::tag('a', $deleteimage, array(
                                'href' => $url . '/delete.php?id=' . $simplehtmlpage->id .
                                '&courseid=' . $COURSE->id
                        ));
                    } else {
                        $edit = '';
                        $delete = '';
                    }

                    $atag = html_writer::tag('a', $simplehtmlpage->pagetitle, array(
                            'href' => $url . '/view.php?id=' . $simplehtmlpage->id . '&courseid=' . $COURSE->id
                    )) . ' ' . $edit . ' ' . $delete;

                    $litag = html_writer::tag('li', $atag);
                    $ultag .= $litag;
                }
                $this->content->text .= html_writer::tag('ul', $ultag);
            }
        } else {
            $this->content->text .= '';
        }

        if (has_capability('block/simplehtml:managepages', $context)) {
            $this->content->footer = html_writer::tag('a', get_string('addpage', 'block_simplehtml'), array(
                    'href' => $url . '/page.php?blockid=' . $this->instance->id . '&courseid=' . $COURSE->id
            ));
        } else {
            $this->content->footer = '';
        }

        // Check for admin global config
        if (get_config('simplehtml', 'Allow_HTML') == '0') {
            $this->content->text = strip_tags($this->config->text);
        }

        return $this->content;
    }

    public function specialization() {
        if (isset($this->config)) {
            if (empty($this->config->title)) {
                $this->title = get_string('defaulttitle', 'block_simplehtml');
            } else {
                $this->title = $this->config->title;
            }

            if (empty($this->config->text)) {
                $this->config->text = get_string('defaulttext', 'block_simplehtml');
            }
        }
    }

    public function has_config() {
        return true;
    }

    public function instance_config_save($data, $nolongerused = false) {
        if (get_config('simplehtml', 'Allow_HTML') == '0') {
            $data->text = strip_tags($data->text);
        }
        // And now forward to the default implementation defined in the parent class
        return parent::instance_config_save($data);
    }

    public function instance_delete() {
        global $DB;
        $DB->delete_records('block_simplehtml', array('blockid' => $this->instance->id));
    }
}