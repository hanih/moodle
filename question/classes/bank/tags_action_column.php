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
 * The question tags column subclass.
 *
 * @package   core_question
 * @copyright 2018 Simey Lameze <simey@moodle.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace core_question\bank;

defined('MOODLE_INTERNAL') || die();

/**
 * Action to add and remove tags to questions.
 *
 * @package    core_question
 * @copyright  2018 Simey Lameze <simey@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class tags_action_column extends action_column_base {

    /**
     * Return the name for this column.
     *
     * @return string
     */
    public function get_name() {
        return 'tagsaction';
    }

    /**
     * Display tags column content.
     *
     * @param object $question The question database record.
     * @param string $rowclasses
     */
    protected function display_content($question, $rowclasses) {
        global $DB;

        if (\core_tag_tag::is_enabled('core_question', 'question') &&
                question_has_capability_on($question, 'view')) {

            $canedit = question_has_capability_on($question, 'edit');
            $category = $DB->get_record('question_categories', ['id' => $question->category], 'contextid');
            $url = $this->qbank->edit_question_url($question->id);

            $this->print_tag_icon($question->id, $url, $canedit, $category->contextid);
        }
    }

    /**
     * Build and print the tags icon.
     *
     * @param int $id The question ID.
     * @param string $url Editing question url.
     * @param bool $canedit Whether the user can edit questions or not.
     * @param int $contextid Question category context ID.
     */
    protected function print_tag_icon($id, $url, $canedit, $contextid) {
        global $OUTPUT;

        $params = [
            'data-action' => 'edittags',
            'data-canedit' => $canedit,
            'data-contextid' => $contextid,
            'data-questionid' => $id
        ];

        echo \html_writer::link($url, $OUTPUT->pix_icon('t/tags', get_string('managetags', 'tag')), $params);
    }
}
