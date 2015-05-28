jQuery(document).ready(function($){$('.newsletter_subscription_submit').live('click',function(){var $parent=$(this).parents('.newsletter_subscription_box');if(!validateEmail($parent.find('.newsletter_subscription_email').val())){$parent.find('.newsletter_subscription_messages *').hide();$parent.find('.newsletter_subscription_messages .newsletter_subscription_message_wrong_email').show();return false;}
var current_name='';if($parent.find('.newsletter_subscription_name').length>0){current_name=$parent.find('.newsletter_subscription_name').val();}
$parent.find('.newsletter_subscription_form').hide();$parent.find('.newsletter_subscription_ajax').show();$.post(tf_script.ajaxurl,{action:'tfuse_ajax_newsletter',tf_action:'tfuse_ajax_newsletter_save_email',email:$parent.find('.newsletter_subscription_email').val(),name:current_name},function(data){$parent.find('.newsletter_subscription_ajax').hide();$parent.find('.newsletter_subscription_form').show();if(data.status==-2){$parent.find('.newsletter_subscription_messages *').hide();$parent.find('.newsletter_subscription_messages .newsletter_subscription_message_wrong_email').show();}
else if(data.status==-1){$parent.find('.newsletter_subscription_messages *').hide();$parent.find('.newsletter_subscription_messages .newsletter_subscription_message_failed').show();setTimeout(function(){$parent.find('.newsletter_subscription_messages *').hide();$parent.find('.newsletter_subscription_messages .newsletter_subscription_message_initial').show();},3000);}
else if(data.status==1){$parent.find('.newsletter_subscription_messages *').hide();$parent.find('.newsletter_subscription_messages .newsletter_subscription_message_success').show();}},'json');return false;});function validateEmail(email){if(!email)
return false;var emailReg=/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;if(!emailReg.test(email)){return false;}else{return true;}}});
/* end of /wp-content/themes/autotrader-parent/framework/extensions/newsletter/static/js/newsletter_clientside.js */
jQuery(document).ready(function()
{tf_reset_jsp();make_selected_item_default();set_multi_select_z_index()});function add_style_for_multi_select(itemId){$('.multi_select.'+itemId+' .multi_select_box').jScrollPane({showArrows:true,mouseWheelSpeed:15,autoReinitialise:true,verticalDragMinHeight:50});$('.mutli_select_box.'+itemId+' input').customInput();}
function add_style_for_sensitive_multi_select(itemId){$('.mutli_select.'+itemId+' .mutli_select_box').removeClass('jspScrollable').removeData().jScrollPane({showArrows:true,mouseWheelSpeed:5,autoReinitialise:true,verticalDragMinHeight:50});$('.multi_select_box.'+itemId+' input').customInput();}
function change_values_for_multi_select(itemId){var checked_terms=[];$('.field_multiselect .'+itemId+' input:checked').each(function(){checked_terms.push($(this).val());});$('.multi_select_taxonomy.'+itemId).val((checked_terms.length)?checked_terms.join(';'):'all').trigger('terms_changed',{terms:checked_terms});}
function make_selected_item_default()
{jQuery('.field_multiselect.closable .select_row label').bind('click',function()
{var current=jQuery(this);current.parents('.multi_select_box').prev('.multi_select_text').text(current.text());current.parents('.field_multiselect.closable').removeClass('open');});}
function tf_reset_jsp()
{var body=jQuery('body *');body.addClass('display_block');jQuery('.multi_select_box .jspContainer').each(function()
{var obj=jQuery(this);obj.height(obj.children('.jspPane').height());});body.removeClass('display_block');}
function set_multi_select_z_index()
{var counterIndex=1000;jQuery('.search_row form .multi_select').each(function(){jQuery(this).css('z-index',counterIndex--);});}
/* end of /wp-content/themes/autotrader-parent/theme_config/extensions/seek/static/js/scripts.js */
