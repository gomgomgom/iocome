/*
 * jQuery.textarea_limiter.js - for sms like textbox
 *
 * version 0.01 (2010/06/1) 
 * 
 * Dual licensed under the MIT and GPL licenses: 
 *   http://www.opensource.org/licenses/mit-license.php 
 *   http://www.gnu.org/licenses/gpl.html 
 */

/**
 *
 * @example $('#textarea').counter({label_info: '#label_info',text_width:160});
 * @desc Limit textarea like sms textbox with label info
 *
 * @name counter
 * @type jQuery
 * @param Object options for the counter (not required)
 * @cat Plugins/Textarea Counter
 * @return jQuery
 * @author Ahmad Satiri (satiri.a@gmail.com)
 */
 
jQuery.fn.counter = function(args,e) {
	
	args = args || {};
	return this.each(function(){
	
	function getCharCode(e){	
		
		if (!e) e = window.event;
		var charCode;
		var ctrl=false;
		var shift=false;
		var alt=false;
	
		if(e && e.which){
			charCode = e.which;
		}else if(window.event){
			e = window.event;
			charCode = e.keyCode;
		}
		
		var result = {"charCode":charCode,"ctrl":ctrl,"alt":alt,"shift":shift};
		return result;
	}
	
	var label = args.label_info?args.label_info:null;
	var msg_width = args.text_width?args.text_width:null;
	var sms_message = "";
	var text_length = 1;
	var jmsg = 0;
	
	if(label==null)
	{
		var div = document.createElement("div");
		label = document.createElement("label");
		$(label).attr("id","label_info");
		
		$(div).append(label);
		$(div).append(this);
		$(this).replaceWith(div);
	}
	
	$(this).keyup(function(e){
		
		OcharCode = getCharCode(e);
		charCode = OcharCode.charCode;
		
		if((OcharCode.ctrl  && charCode==86) || charCode==46)
		{	
			sms_message = $(this).val();
			text_length = sms_message.length;
			updateLabelInfo();
		}	
	});
	
	function updateLabelInfo(){
		if(msg_width==null){
			$(label).html(text_length);
		}else
		{
			jmsg = (Math.floor(text_length/msg_width))+1;
			$(label).html("Chars :" + text_length + "  Msg : " + jmsg);
		}	
	}
	
	$(this).keydown(function(e){
	
		OcharCode = getCharCode(e);
		
		
		charCode = OcharCode.charCode;
		if(charCode && charCode!=127){
			if(text_length>=0){
				if((charCode>=32 && charCode!=37 && charCode!=38 && charCode!=39 && charCode!=40)){
										
					if(OcharCode.ctrlKey  && charCode==86)
					{	//pasting
						//alert("Paste is disabled");
						sms_message = $(this).val();
						text_length = sms_message.length;
						$(label).html(text_length);
						
					}
					else
					{
						text_length++;	
						updateLabelInfo();
					}
				}

				//backspace
				if(charCode==8){
					if((text_length-1)>=0){
						sms_message = $(this).val();
						text_length = (sms_message.length)-1;
						updateLabelInfo();					
					}
				}
				
				//arrow,ctrl+c do nothing
				if(charCode==37 || charCode==38 || charCode==39 || charCode==40 || charCode==17){	
				}
				
				//pasting
				if(charCode==86 || charCode==0 || charCode==118 || charCode==46){
					
					sms_message = $(this).val();				
					text_length = sms_message.length;
					updateLabelInfo();	
				}
				
				if(text_length>=0){
					//sms_message = $(this).val();
					//$(this).val(sms_message);
				}
			}
		}
	});
	
  });
};	