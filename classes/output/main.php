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
 * Class containing data for test block.
 *
 * @package    block_test_block
 * @copyright  Vinay Bhalerao <vinaybhalerao11@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace block_test_block\output;
defined('MOODLE_INTERNAL') || die();

use renderable;
use renderer_base;
use templatable;
use stdClass;

/**
 * Class containing data for my overview block.
 *
 * @copyright  2018 Bas Brands <bas@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class main implements renderable, templatable {

    /**
     * main constructor.
     * Initialize the user preferences
     *
     * @param string $grouping Grouping user preference
     * @param string $sort Sort user preference
     * @param string $view Display user preference
     * @param int $paging
     * @param string $customfieldvalue
     *
     * @throws \dml_exception
     */
    public function __construct() {
    }

    /**
     * Export this data so it can be used as the context for a mustache template.
     *
     * @param \renderer_base $output
     * @return array Context variables for the template
     * @throws \coding_exception
     *
     */
    public function export_for_template(renderer_base $output) {
        global $CFG, $USER, $COURSE, $DB;
        $courseid = $COURSE->id;
        $defaultvariables = array();
        $mods = get_array_of_activities($courseid);
        if (empty($mods)) {
            return $defaultvariables;
        }
        $modinfo = array();
        foreach ($mods as $mod) {
            $modobj = new stdClass();
            $modobj->cmid = $mod->cm;
            $modobj->actname = $mod->name;
            $modobj->cdate = date('d-M-Y', $mod->added);
            $data = $DB->get_record('course_modules_completion', array('coursemoduleid' => $mod->cm, 'userid' => $USER->id));
            if ($data->completionstate == 1) {
                $modobj->status = get_string('completed', 'block_test_block');;
            }
            array_push($modinfo, $modobj);
        }
        $defaultvariables = [
            'modules' => $modinfo
        ];
        return $defaultvariables;
    }
}
