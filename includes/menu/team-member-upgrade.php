<?php	
if ( ! defined('ABSPATH')) exit;  // if direct access

$team_plugin_info = get_option('team_plugin_info');
$team_member_upgrade = isset($team_plugin_info['team_member_upgrade']) ? $team_plugin_info['team_member_upgrade'] : '';

?>
<?php

?>
<div class="wrap">
	<div id="icon-tools" class="icon32"><br></div><h2><?php echo sprintf(__('%s Team member - Update', 'team'), team_plugin_name)?></h2>



    <?php

    if($team_member_upgrade != 'done'){



        //update_team_member_data();




        $team_plugin_info['team_member_upgrade'] = 'done';
        //update_option('team_plugin_info', $team_plugin_info);

        ?>

        <p>Team member data migration completed.</p>
        <?php

    }else{
        ?>
        <p>Team member data migration already completed.</p>
        <?php
    }

    ?>

</div>
