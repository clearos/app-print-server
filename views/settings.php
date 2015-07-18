<?php

/**
 * Print server settings view.
 *
 * @category   apps
 * @package    print-server
 * @subpackage views
 * @author     ClearFoundation <developer@clearfoundation.com>
 * @copyright  2011 ClearFoundation
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 3 or later
 * @link       http://www.clearfoundation.com/docs/developer/apps/print_server/
 */

///////////////////////////////////////////////////////////////////////////////
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.  
//  
///////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////
// Load dependencies
///////////////////////////////////////////////////////////////////////////////

$this->lang->load('base');
$this->lang->load('print_server');

$url = 'https://' . $_SERVER['SERVER_ADDR'] . ':631/';

///////////////////////////////////////////////////////////////////////////////
// Show warning if not running
///////////////////////////////////////////////////////////////////////////////

echo "<div id='server_not_running' style='display:none;'>";
echo infobox_warning(lang('base_warning'), lang('print_server_management_tool_not_accessible'));
echo "</div>";

$options['buttons'] = array(
    anchor_custom($url, lang('print_server_go_to_management_tool'), 'high', array('target' => '_blank'))
);

echo "<div id='server_running' style='display:none;'>";
echo infobox_highlight(
    lang('print_server_management_tool'),
    lang('print_server_management_tool_help'),
    $options
);
echo "</div>";
