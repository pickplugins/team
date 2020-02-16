
jQuery(document).ready(function($)
	{


			
			
			
		$(document).on('click', '.add_team_member_skill', function()
			{
				var skill_name = prompt("Skill name ?","");
				
				if(skill_name != null && skill_name != '')
					{
						$(".team-member-skills").append('<tr><td class="sorting"></td><td><input type="text" value="'+skill_name+'" name="team_member_skill['+skill_name+'][name]" placeholder="Programming" size="30"></td><td><input type="text" value="" name="team_member_skill['+skill_name+'][value]" placeholder="80%" size="30"></td><td><span class="remove-skill">X</span></td></tr>');
					}

		
			})			
			
			
		$(document).on('click', '.remove-skill', function()
			{	
				if (confirm('Do you really want to delete this field ?')) {
					
					$(this).parent().parent().remove();
				}
			})
			
			
			
			
			
		$(document).on('click', '.add_team_member_meta', function()
			{
				var meta_name = prompt("Meta name ?","");
				
				if(meta_name != null && meta_name != '')
					{
						$(".team-member-meta-fields").append('<tr><td class="sorting"></td><td><input type="text" value="'+meta_name+'" name="team_member_meta_fields['+meta_name+'][name]" placeholder="" size="30"></td><td><input type="text" value="" name="team_member_meta_fields['+meta_name+'][meta_key]" placeholder="meta_key" size="30"></td><td><span class="remove-meta">X</span></td></tr>');
					}

		
			})				
			
			
			
		$(document).on('click', '.team-member-meta-fields .remove-meta', function()
			{	
				if (confirm('Do you really want to delete this field ?')) {
					
					$(this).parent().parent().remove();
				}
			})
			
			
			
			

	});	
