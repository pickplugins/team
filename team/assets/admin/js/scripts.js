
jQuery(document).ready(function($)
	{




		$(document).on('click', '.settings-tabs .add-contact', function(){

			time = $.now();
			dataName = $(this).attr('data-name');

			html = '<div class="item">';
			html += '<div>Type: </div>';
			html += '<select name="'+dataName+'[contacts]['+time+'][type]">';
			html += '<option value="email">Email</option>';
			html += '<option value="phone">Phone</option>';
			html += '<option value="link">Link</option>';
			html += '<option value="text">Text</option>';
			html += '<option value="skype">Skype</option>';
			html += '</select>';
			html += '<div>Link or Value:</div>';
			html += '<input type="text" name="'+dataName+'[contacts]['+time+'][value]" placeholder="Write username, link, phone number or skype" value="">';
			html += '<div>Label:</div>';
			html += '<input type="text" name="'+dataName+'[contacts]['+time+'][label]" placeholder="Twitter" value="">';
			html += '<div>Icon:</div>';
			html += '<input type="text" name="'+dataName+'[contacts]['+time+'][icon]" placeholder="" value="">';
			html += '<span class="button sort"><i class="fas fa-arrows-alt"></i></span>';
			html += '<span class="button remove" onclick="jQuery(this).parent().remove()"><i class="fas fa-times"></i></span>';
			html += '<hr/>';
			html += '</div>';

			$('.contact-list').append(html);

		})







		$(document).on('click', '#team_metabox .expandable .expand', function()
			{	
			
				//alert('Hello');
			
				if($(this).parent().parent().hasClass('active'))
					{
					$(this).parent().parent().removeClass('active');
					}
				else
					{
						$(this).parent().parent().addClass('active');
					}
				

			})








		$(document).on('click', '.meta-key-list .remove', function()
			{
				//alert('Hello');
				$(this).parent().remove();
			})



		$(document).on('click', '#team_metabox .add-meta-key', function()
			{
				
				var key = $.now();
				
				data = '<div><span class="remove"><i class="fa fa-times" aria-hidden="true"></i></span> <span class="move"><i class="fa fa-bars" aria-hidden="true"></i></span> <input placeholder="<div>%s</div>" type="text" name="team_grid_meta_keys['+key+'][wrapper]" value="%s" /> <input placeholder="meta_key" type="text" name="team_grid_meta_keys['+key+'][key]" value="" /></div>';
				
				
				jQuery("#team_metabox .meta-key-list").append(data);

				
			})








		$(document).on('click', '.update-list-team-ids', function()
			{	
				//alert('Hello');
				
				var is_confirm = $(this).attr('confirm');
				
				if(is_confirm == 'ok'){
					
					update_yes= 'yes';
					
					jQuery.ajax(
						{
					type: 'POST',
					url: team_admin_ajax.team_admin_ajaxurl,
					data: {"action": "team_get_all_post_ids",'update_yes':update_yes},
					success: function(data)
							{	
								//alert('Hello');
								//alert(data);
								$('.team_content_source_post_id').html(data);
								$( ".team_content_source_post_id ul" ).sortable({  });
								
								//window.location.reload();
							}
						});
					
						//$(this).html('Done');
						$(this).html(L10n_team.done_text);
					
					}
				else{
						
						$(this).attr('confirm','ok');
						//$(this).html('Confirm');
						$(this).html(L10n_team.confirm_text);
					}

		

			})	



		
		
		$(document).on('click', '.team_member_social_icon', function()
			{	
			var team_member_social_icon = prompt("Please insert icon url","");
			if(team_member_social_icon != null)
				{
					var icon_name = $(this).attr("icon-name");	
							
					$(this).css("background-image",'url('+team_member_social_icon+')');
						
					$(".team_member_social_icon_"+icon_name).val(team_member_social_icon);
				}



			})
			
			
			
		$(document).on('click', '.remove_icon', function()
			{	
				if (confirm('Do you really want to delete this field ?')) {
					
					$(this).parent().parent().remove();
				}
			})			
			
			
				
		
		$(document).on('click', '.team_content_source', function()
			{	
				var source = $(this).val();
				var source_id = $(this).attr("id");
				
				$(".content-source-box.active").removeClass("active");
				$(".content-source-box."+source_id).addClass("active");

			})
			
			
			
			
			
		$(document).on('click', '.reset_team_member_social_field', function()
			{	
				//alert('Hello');
				if(confirm('Do yuo really want to reset ?')){
					jQuery.ajax(
						{
					type: 'POST',
					url: team_admin_ajax.team_admin_ajaxurl,
					data: {"action": "reset_team_member_social_field",},
					success: function(data)
							{	
								//alert('Hello');
								
								window.location.reload();
							}
						});
					
					}

		

			})			
			
			
			
			
			
			
		$(document).on('click', '.new_team_member_social_field', function()
			{
				var user_profile_social = prompt("Please add new social site","");
				
				if(user_profile_social != null && user_profile_social != '')
					{
						$(".team_member_social_field").append('<tr><td class="sorting"></td><td><input type="text" value="'+user_profile_social+'" name="team_member_social_field['+user_profile_social+'][name]"></td><td><input type="text" name="team_member_social_field['+user_profile_social+'][meta_key]" value="'+user_profile_social+'"  /></td><td><span class="team_member_social_icon empty_icon" icon-name="'+user_profile_social+'" title="Icon for this field." style=" "></span><input class="team_member_social_icon team_member_social_icon_'+user_profile_social+'" type="hidden" value="" name="team_member_social_field['+user_profile_social+'][icon]"></td><td><input type="checkbox" value="1" name="team_member_social_field['+user_profile_social+'][visibility]" checked=checked></td><td><span class="remove_icon">X</span><input type="hidden" value="yes" name="team_member_social_field['+user_profile_social+'][can_remove]"></td></tr>');
					}

		
			})
			
			
			
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
