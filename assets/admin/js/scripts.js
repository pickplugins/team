jQuery(document).ready(function($){


    $(document).on('click', '.team-import-layouts', function(event){

        event.preventDefault();

        xml_source = $(this).attr('href');
        $(this).html('Please wait...');


        console.log(xml_source);

        jQuery.ajax(
            {
                type: 'POST',
                context: this,
                url: team_ajax.team_ajaxurl,
                data: {"action": "team_import_xml_layouts","source": xml_source,"ajax_nonce": team_ajax.ajax_nonce },
                success: function(response) {
                    var data = JSON.parse( response );

                    success = data['success'];

                    $(this).html(success);

                    console.log(success);

                }
            });

    })











});







