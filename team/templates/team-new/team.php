<?php
if ( ! defined('ABSPATH')) exit;  // if direct access

$teamid = isset($_GET['teamid']) ? $_GET['teamid'] : '';
$teamMember = isset($_GET['teamMember']) ? (int) $_GET['teamMember'] : '';

include team_plugin_dir.'/templates/team-new/variables.php';




if(!empty($teamid)):
    include team_plugin_dir.'/templates/team-new/team-single.php';
else:
    include team_plugin_dir.'/templates/team-new/team-grid.php';
endif;

