<?php	
if ( ! defined('ABSPATH')) exit;  // if direct access

$team_plugin_info = get_option('team_plugin_info');

$team_settings_upgrade = isset($team_plugin_info['settings_upgrade']) ? $team_plugin_info['settings_upgrade'] : '';
$team_member_upgrade = isset($team_plugin_info['team_member_upgrade']) ? $team_plugin_info['team_member_upgrade'] : '';

?>
<?php

?>
<div class="wrap">
	<div id="icon-tools" class="icon32"><br></div><h2><?php echo sprintf(__('%s Settings - Update', 'team'), team_plugin_name)?></h2>



    <?php

    if($team_settings_upgrade != 'done'){
        team_upgrade_settings();

        $team_plugin_info['settings_upgrade'] = 'done';

        update_option('team_plugin_info', $team_plugin_info);

        ?>
        <p>Settings migration completed.</p>
        <?php

    }else{
        ?>
        <p>Settings migration already completed.</p>
        <?php
    }

    ?>

</div>
