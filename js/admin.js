var resetBtn=false;
jQuery(document).ready(function(){ 
	 var winURL=window.location.href.split('?')[0];
//	 console.log(winURL);
	 var tabURL=winURL.split("/");
	 var txtURL=tabURL[tabURL.length-1].split("_");	
	 
	 if(txtURL[txtURL.length-1]=="add"){
		 jQuery(".reqApp").remove();
	 }
	if(tabURL[tabURL.length-1]=="edit-profile"){
		jQuery(".backToEdit").remove();
	}
	jQuery(".reqUpdates").click(function(e){  
			 jQuery("a.directoryLnk:first").click();
		     setTimeout(function(){ jQuery("a.directoryLnk1:first").click();	}, 500);		 
			 
	}); 
	
	if(jQuery("#sort_order").length > 0){
		jQuery("#sort_order").attr("maxlength","4");
		jQuery("#sort_order").addClass("numericOnly numbers");
		jQuery(".numericOnly").numericOnly();
	}
	 var finaltabURL=tabURL[tabURL.length-1].split("_")[0];
	 if(jQuery(".comonLinkBtn") .length >0) {
	   jQuery(".comonLinkBtn").each(function(key,val){
				 if(finaltabURL=="testimonial" || finaltabURL=="brochure"){
					 finaltabURL+="s";
				 } 
				if(finaltabURL==jQuery(this).find("span").html().toLowerCase()){
					
						jQuery(this).addClass("active");
				} 
	   });	 
		 
		 
	 }
	 /*if(jQuery("div.S_addNew").length > 0){
		 htmlLimit='<div class="limitDrp actionBtn">'+jQuery('.limitDrp').html()+'</div>';
		 jQuery(".S_addNew").prepend(htmlLimit);
	 }	*/
	 
	 /** Crop Tab Function ***/
	 if(jQuery("#executeScript").length> 0 && jQuery("#executeScript").val()=="1"){
		 jQuery("#selectFile").hide();
		 jQuery(".cropTab").bind("click",function(){
			 jQuery('.imgTabing').find('.current').removeClass('current');
		   jQuery(".cropTab").each(function(){
			   jQuery(jQuery(this).attr("data-tab")).hide();
		   }); 
		   jQuery(jQuery(this).attr("data-tab")).show();
		   if(jQuery(this).attr("data-tab")=="#selectFile" ){ 
			   jQuery(".loadSelectImg").show();
			   getFiles();
		   }
		 jQuery(this).parent('.tabing').addClass('current');  
		 });
		 
		 jQuery("#insertImg").bind("click",function(){
				 var imgURL=jQuery(".selectedImg").find("img").attr("src");
				 imgURL = imgURL.replace(/thumb/g,"large");
				 jQuery("#popDetails").show();
				 jQuery("#selectFile").hide();
			 	jQuery("#imageCrop").attr("src",imgURL);
				var hiddenV = jQuery("#"+jQuery("#thumbHidden").val()).val();
				if(hiddenV==""){
					 var dataArr=imgURL.split("/");
					 console.log(dataArr);
					//jQuery("#"+jQuery("#thumbHidden").val()).val(dataArr[dataArr.length-5]);
					jQuery("#"+jQuery("#thumbHidden").val()).val(jQuery(".selectedImg").find("img").attr("title"));
				}
				//jQuery("#"+jQuery("#thumbHidden").val()).val(jQuery(".selectedImg").find("img").attr("title"));
				if(cropper){
					cropper.destroy();
				}
				 jQuery(".selectedImg").removeClass("selectedImg");
				
				getImageUploader(document.getElementById("imageCrop"));
				jQuery(".tabing").removeClass("current");
				jQuery(".cropTab:first").closest("li").addClass("current");
				loadCropSlideBar();
				jQuery("#zoomSection").show();
				 
		 });
		  jQuery("#useImg").bind("click",function(){
			 if(jQuery(".selectedImg").length > 0){
			   var imgSelected=jQuery(".selectedImg").find("img");
			   var imgSelectedFolder=jQuery(".selectedImg").next(".infoNote").find('.folder').html().toLowerCase();
			   if(imgSelectedFolder=="blog"){
				   imgSelectedFolder="profileblog";
			   } else if(imgSelectedFolder=="slider"){
				   imgSelectedFolder="directoryslider";
			   }
			   jQuery("#imageCrop").attr("src",imgSelected.attr("src").replace(/thumb/g,"large"));
			   jQuery("#"+jQuery("#thumbHidden").val()).val('i^'+imgSelectedFolder+'#'+imgSelected.attr("title"));
			   jQuery("#"+jQuery("#thumbPreview").val()).find("img").attr("src", imgSelected.attr("src").replace(/thumb/g,'small'));
			   if(cropper){
					cropper.destroy();
				}
				jQuery("a[data-preview="+jQuery("#thumbPreview").val()+"]").remove();
				jQuery("div[data-preview="+jQuery("#thumbPreview").val()+"]").after("<a title='Delete Image' href='javascript:' data-url='"+jQuery("#"+jQuery("#thumbPreview").val()).find("img").attr("src")+"' data-hidden='"+jQuery("#thumbHidden").val()+"' data-preview='"+jQuery("#thumbPreview").val()+"' class='delImg' onclick='delImg(this);'>Delete</a>");
				jQuery("#"+jQuery("#thumbPreview").val()).show();
				jQuery("#"+jQuery("#thumbPreview").val()).prev("img").hide();
			    jQuery(".selectedImg").removeClass("selectedImg");
				getImageUploader(document.getElementById("imageCrop"));
				jQuery(".tabing").removeClass("current");
				jQuery(".cropTab:first").closest("li").addClass("current");
				loadCropSlideBar();
				jQuery(".closeCrop").trigger("click");
			 } else {
				 alert('Please select image');
			 }
		  });	  
	 }
	 /**** Cropping Function ***********/
	 
	 if(jQuery(".closeCrop").length > 0){
		 jQuery(".closeCrop").click(function(){
				jQuery("#uploadImage").val("");
				jQuery("#imageCrop").hide();
				jQuery("#uploadImage").prev("span.text").html("");					
				clearObj(); 
				if(jQuery(".loading").length > 0) {
					jQuery(".loading").hide();
				}
		 });
		
	   	
	  jQuery(".delImg").bind("click",function(e){
			e.stopPropogation();
	  });	 
		   
	 jQuery("#cropImg").bind("click",function(){
			 
			if(jQuery("#"+jQuery("#thumbHidden").val()).val()=="" && jQuery("#uploadImage").val()==""){
				alert('Please upload file');
				return false;
			}
			var filename="";
			if(jQuery("#uploadImage").val()!=""){
				filename=document.getElementById("uploadImage").files[0].name;
			} else {
			 
				filename=jQuery("#"+jQuery("#thumbHidden").val()).val();
			}
			 
			if(jQuery("#uploadImage").val()=="" && filename=="" /*jQuery("#imageCrop").val()!=""*/){
				alert('Please upload file');
				return false;
			} 
                        
                        if(confirm('Are you sure want to crop this image?') == true)
                        {
			console.log(cropper);
			//cropper.crop(); 
			var propertyCrop = { width:parseInt(jQuery("#imageCrop").attr('data-aratio-w')),height:parseInt(jQuery("#imageCrop").attr('data-aratio-h')) }; //Remove propertyCrop variable from getCroppedCanvas for using same image for multiple time crop
			cropper.getCroppedCanvas(propertyCrop).toBlob(function (blob) { 
			var imgCropURL=cropper.getCroppedCanvas(propertyCrop).toDataURL('image/png');	
			 	jQuery("#cropImg").attr("disabled","disabled");
			var formData = new FormData();
			formData.append('folder',jQuery("#thumbFolder").val());
			formData.append('user',jQuery("#thumbUser").val());
			formData.append('directory_id',jQuery("#directory_id").val());
			formData.append('filename',filename);
			formData.append('croppedImage', imgCropURL);
		
			var imageUrl =  baseURL+"/theme/images/";
			jQuery("#cropImg").after("<span class='loading' style='margin-left:10px'><img src='"+imageUrl+"loader.gif' alt='Loading...' /></span>");
			var hsn=location.hostname;
			if(hsn=="192.168.200.13"){
				 hsn="192.168.200.13:8080";
			}
			jQuery.ajax(baseURL+'user/upload-image/'+jQuery("#thumbFolder").val()+'/'+jQuery("#thumbUser").val()+'/'+jQuery("#directory_id").val(), {
				method: "POST",
				data: formData,
				processData: false,
				contentType: false,
				success: function (data) {
						console.log('Upload success'); 
						jQuery("#cropImg").removeAttr("disabled");
						var dataImg = data.split(",");
						var imgURL=dataImg[0];
						var imgName=dataImg[1]; 
						jQuery("#"+jQuery("#thumbHidden").val()).val(imgName);
						
						jQuery(".closeCrop").trigger("click"); 
						var server=location.hostname;
						if(server=="192.168.200.13"){
							server+=":8080";
						}
						var imgPathCrop=baseURL+"image-catalog/"+imgName+"/small/"+jQuery("#thumbUser").val()+"/"+jQuery("#directory_id").val()+"/"+jQuery("#thumbFolder").val();
						jQuery("#"+jQuery("#thumbPreview").val()).find("img").attr("src",imgPathCrop); 
						jQuery("#"+jQuery("#thumbPreview").val()).find("img").show();
						jQuery("#"+jQuery("#thumbPreview").val()).show();
						jQuery("#uploadImage").val("");
						jQuery("#uploadImage").prev("span.text").html("");
						//jQuery("#"+jQuery("#thumbPreview").val()).closest("div").find("a").remove();
						//jQuery("#"+jQuery("#thumbPreview").val()).closest("div").find(".delImg").remove();
						//jQuery("#"+jQuery("#thumbPreview").val()).closest("div").after("<a title='Delete Image' href='javascript:' data-url='http://"+imgURL+"' data-hidden='"+jQuery("#thumbHidden").val()+"' data-preview='"+jQuery("#thumbPreview").val()+"' class='delImg' onclick='delImg(this);'>Delete</a>");
						jQuery("a[data-preview="+jQuery("#thumbPreview").val()+"]").remove();
						jQuery("div[data-preview="+jQuery("#thumbPreview").val()+"]").after("<a title='Delete Image' href='javascript:' data-url='"+imgPathCrop+"' data-hidden='"+jQuery("#thumbHidden").val()+"' data-preview='"+jQuery("#thumbPreview").val()+"' class='delImg' onclick='delImg(this);'>Delete</a>");
						jQuery("#imageCrop").attr("src","");
						jQuery("#imageCrop").hide();
						jQuery(this).removeAttr("disabled");
						jQuery('.loading').remove();
					
				},
				error: function () {
					console.log('Upload error');
					jQuery(this).removeAttr("disabled");
					jQuery('.loading').remove();
				}
			});
                        
		  });
              }
	   });
	 
	   
	}
	/***********************************/
	 if(jQuery(".bkSavBtn").length > 0){ 
	 jQuery(".button_append").prepend(jQuery(".bkSavBtn").html());
	 jQuery(".bkSavBtn").remove();	
	 }
	 
	if(winURL.search("_")>0){
		jQuery('button[title="Approve"]').remove();
		jQuery('button[title="Disapprove"]').remove();
	} 
	
	if(jQuery("#formTeamAdd").length > 0){
	 var rulesData = {
                name: {required: true}, 
                email: {email: true},
                phone: {minlength: 10},
                mobile:{minlength: 10}
			};
            var messagesData = {
                name: {required:"Please enter name"}, 
                email: {email:"Please enter valid email"},
                phone: {minlength:"Phone must be 10 digit long"},
                mobile:{minlength:"Mobile must be 10 digit long"} 
            };
		 
	 jQuery("#formTeamAdd").validate({
		onkeyup:false,
		rules:rulesData,
		messages:messagesData,
		errorClass: "error"
	 });
	 
	  fileUploader(jQuery("#image_name"),"team",jQuery("#imgPreview img"),jQuery("#userFolder").val(),jQuery("#hndfileupload"),true); 
	  jQuery("#user").change(function(){
		  jQuery("#userFolder").val(jQuery(this).val());
		  fileUploader(jQuery("#image_name"),"team",jQuery("#imgPreview0 img"),jQuery("#userFolder").val(),jQuery("#hndfileupload"),true); 
	  });
	   
	} 
	jQuery(".chkSelect").click(function(){
		jQuery("#selectAll").prop("checked","");
		
	});
	jQuery("#selectAll").change(function(){
		 
		var checkedStatus = jQuery(this).prop("checked");
        jQuery(".chkSelect").each(function() {
            this.checked = checkedStatus;
            if (checkedStatus == true) {
                this.checked = true;
            }
            else if (checkedStatus == false) {
                this.checked = false;
            }
        });
		
	});
	
	jQuery("#btnReset").click(function(){
			resetBtn=true;
			jQuery("#txtSearch").val('');
			doPaging(0,'loader',jQuery('#tableData'),createRows);
			createPages(0);
	});
	
//	jQuery("#action").change(function(){
//			if(jQuery(this).val()!=""){
//				if(jQuery(".chkSelect:checked").length == 0){
//					alert('Please select at one checkbox');
//				}
//				else {
//					var bulk_action="delete";
//					var stat ='0';
//					if(jQuery(this).val()=="active" || jQuery(this).val()=="inactive"){
//						bulk_action="change_status";
//						if(jQuery(this).val()=="active")
//							stat='1';
//					}
//						
//					jQuery.ajax({
//						url:window.location.href.split('?')[0].replace(/list/g,bulk_action),
//						data:{"bulk":jQuery("#frmData").serializeArray(),"status":stat},
//						type:'post',
//						success:function(data){ 
//							jQuery(".heading").before(data);
//							displayMessage();
//							doPaging(jQuery("#show_page").val(),'loader',jQuery('#tableData'),createRows);
//							
//						}
//					});
//				}
//			}
//	});
        
        jQuery("#action").change(function(){ 
			if(jQuery(this).val()!=""){
				if(jQuery(".checkBox:checked").length == 0){
					alert('Please select at least one checkbox');
                                        jQuery('#action').val('');
                                        jQuery('.action').html('Action');
				}
				else { 
					var bulk_action="delete";
					var txtMsg="delete";
					var reqURL="";
					if(isTrashEnable()==true){
						
						if(jQuery("#isTrash").val()!='1'){
							txtMsg="trash";
						} else if(jQuery(this).val()=="restore"){
							txtMsg="restore";
							reqURL="?restore=true";
						}
					}
                                        var msg = 'Do you really want to '+txtMsg+' this record(s)';
					var stat ='0';
					if(jQuery(this).val()=="active" || jQuery(this).val()=="inactive"){
						bulk_action="change_status";
						var msgP=jQuery(this).val();
						if(tabURL[tabURL.length-1]=="notification_list" || tabURL[tabURL.length-1]=="enquiry_list")
						{
							if(jQuery(this).val()=="active"){
								msgP="mark read";
							} else {
								msgP="mark unread";
							}
						}
						
                        var msg = 'Do you really want to '+msgP+' this record(s)';
						if(jQuery(this).val()=="active")
							stat='1';
					}
                                        
					if(confirm(msg))
                                        {
											var trashURL=""; 
											if(jQuery("#isTrash").length>0 && jQuery("#isTrash").val()=="1"){
													trashURL="?show=trash";
											} 
                                            jQuery.ajax({
                                                    url:window.location.href.split('?')[0].replace(/list/g,bulk_action)+reqURL+trashURL,
                                                    data:{"bulk":jQuery("#frmData").serializeArray(),"status":stat},
                                                    type:'post',
                                                    success:function(data){ 
                                                            jQuery(".heading").before(data);
                                                            displayMessage(data);
                                                            doPaging(jQuery("#show_page").val(),'loader',jQuery('#tableData'),createRows);
                                                            jQuery('#action').val('');
                                                            jQuery('.action').html('Action');

                                                    }
                                            });
                                        }
                                        else
                                        {
                                            jQuery('#action').val('');
                                            jQuery('.action').html('Action');
                                        }
				}
			}
                       jQuery("#selectAll").attr('checked', false);
	});
	
  

	 /*if(parseInt(jQuery("#show_page").val())==0){
		 
		pagesLinkDisplay(0,5);
	} else {
		pagesLinkDisplay(parseInt(jQuery("#show_page").val())-1,(parseInt(jQuery("#show_page").val())-1)+5);
	} */
	jQuery("#btnSearch").click(function(){
		
	   if(jQuery("#txtSearch").val()!=""){
		var dataObj=jQuery("#searchFrm").serialize();
		doPaging(0,'loader',jQuery('#tableData'),createRows,'',dataObj);
	   } else {
		   var msgBox="enter any keyword";
		   if(jQuery("#txtSearch").attr("placeholder")!=""){
			   msgBox=jQuery("#txtSearch").attr("placeholder").toLowerCase();
		   }
		   alert('Please '+msgBox+' to search');
		   return false;
	   }
	});
	
	
	
	displayMessage();
	
	jQuery(".pagging").click(function(){ 
		jQuery(".pagging").removeClass("active");  
		doPaging(jQuery(this).attr('id').replace(/pagging/g,''),'loader',jQuery('#tableData'),createRows);
	});
	
	
	jQuery(".is-active").click(function(){
		  var str="";
		  var sort;
		  if(jQuery(this).attr("aria-sort")=="desc"){
			  sort="asc";
			  jQuery(this).attr("aria-sort","asc");
                         
                          jQuery(this).parent('tr').find('th').removeClass('sort_desc');
                          jQuery(this).parent('tr').find('th').removeClass('sort_asc');
                          jQuery(this).addClass("sort_asc");
		  } else {
			  sort="desc";
			  jQuery(this).attr("aria-sort","desc");
                          jQuery(this).parent('tr').find('th').removeClass('sort_desc');
                          jQuery(this).parent('tr').find('th').removeClass('sort_asc');
                          jQuery(this).addClass("sort_desc");
//                          jQuery(this).removeClass('sort_asc').addClass("sort_desc");
		  } 
		  str=jQuery(this).attr('data-title')+"_"+sort;
		  var id=getCurrentPage();
		  doPaging(id,'loader',jQuery('#tableData'),createRows,str);	
	});
	

	
	 
}); 
	function loadCropSlideBar(){  
			var lastValue = 0; 
		  jQuery("#zoomSlider").slider({
                     min: 0.1,
					 max: 4,
					 value: 1,
					step: 0.01,
                    slide: function(event, ui) { 
					 	 if(cropper){
							
							cropper.zoomTo(ui.value);						 
								/*if(lastValue==0){
									if(ui.value >= 5){
										console.log( "this is increasing" );
										cropper.zoom(0.1);
									} else if(ui.value < 10) {
										console.log( "this is decreasing" );
										cropper.zoom(-0.1);
									}
								}
								else if(ui.value > lastValue) {
										console.log( "this is increasing" );
										cropper.zoom(0.1);
								} else {
										console.log( "this is decreasing" );
										cropper.zoom(-0.1);
									} 
								}
								lastValue = ui.value;
								*/
							    /*var prevVal=jQuery("#sliderVal").val();
								var newVal=ui.value; 
								if (prevVal > newVal) {
									cropper.zoom(-0.1);
								} else {
									cropper.zoom(0.1);
								}
								  jQuery("#sliderVal").val(ui.value);
								  console.log("Prev val:"+prevVal+" New Val:"+newVal);*/
							}
						} 
                }); 
	 			
	} 
   function onTrash(){ 
	   if(isTrashEnable()==true) {
		  
		 jQuery(document).ajaxComplete(function() {  
		  if(jQuery("#isTrash").val()=="1"){ 	 
			jQuery(".tEdit").remove();
			jQuery(".chStatus").remove();
			 jQuery(".restoreData").unbind().click(function(){
			    if(confirm('Do you really want to restore this record(s)'))
                {
                    var url=window.location.href.split('?')[0].replace(/list/g,"delete");
                    pageid=getCurrentPage();
					var trashURL="";
					if(isTrashEnable()==true){
						if(jQuery("#isTrash").val()=="1"){
							trashURL+="&restore=true";
						}
					}
                    jQuery.ajax({
                            url:url+"?id="+jQuery(this).attr("data-title")+trashURL,
                            async:true,
                            success:function(data){
								    
                                    window.location.href=window.location.href.split('?')[0]; 
                            }
                    });
                }
			});
			
		}else {
			jQuery(".restoreData").remove();
		}
	  });	
	}	   
   }
  function isTrashEnable(){
	   if(jQuery("#isTrash").length > 0 ) {
			return true;   
	   }
		return false;
  }
   function restoreHTML(id){
	   var htmlR='';
	   if(isTrashEnable()==true) {
		   htmlR='<a class="restoreData" data-title="' + id + '"   href="javascript:;" title="Restore"><i class="fa fa-undo" aria-hidden="true"></i></a>';
	   }
	   return htmlR;
   }
   function getFiles(){
	   jQuery.ajax({
		  url:jQuery("#frontURL").val()+"team/team_add?getFiles=true",
		  success:function(data){
			   jQuery(".loadSelectImg").hide();
			   var imgData=jQuery.parseJSON(data);
			 if(imgData.length > 0){ 
			  console.log(imgData);
			 jQuery(".imgList").html('');
			  var imgHTML="";
			  for(i=0;i<imgData.length;i++){ 
				  imgHTML+=createImgBox(imgData[i]);
			  }
			  jQuery(".imgList").append(imgHTML);
			  jQuery("#insertImg").show();
			  jQuery("#useImg").show();
			 } else {
						if(jQuery(".imgList").find('.Nofiles').length == 0){
							jQuery(".imgList").append('<li class="Nofiles" >No Files Found</li>');
							jQuery("#insertImg").hide();
							jQuery("#useImg").hide();
						}
                                    
								
			 }
		  }
	   });
   }	
   
   function createImgBox(img){
	   return imgHTML='<li class="thumbMain"><div class="thumbImgdiv"><div class="thumbImgMAin" onclick="selectImg(jQuery(this))"><img title="'+img.fileName+'" src="'+img.imageURL+'" class="thumbImg" /><a title="Delete Image" href="javascript:" data-url="'+img.imageURL+'" data-hidden="'+jQuery('#thumbHidden').val()+'" data-preview="'+jQuery('#thumbPreview').val()+'" class="delImg" onclick="delSelectedImg(this);">Delete</a></div><span class="infoNote"><strong>Image Folder</strong> : <span class="folder">'+img.folder+'</span></span></div></li>';
   }

   function delSelectedImg(objImg){
	   delImg(objImg);
	   jQuery(".imgList").html('');
	   getFiles();
   } 
   function selectImg(img){
	   jQuery(".thumbImgMAin").removeClass("selectedThumb");
			jQuery(".selectedImg").removeClass("selectedImg");
			//img.parent(".thumbImgMAin").addClass("selectedThumb");
			img.addClass("selectedImg");
			
			
   }
   function validateForm(obj,rulesData,messagesData,ignore){
	     if(!ignore){
			 ignore=new Array();
		 } 
		 
	   	 obj.validate({
		ignore: ignore,	 
		onkeyup:false,
		rules:rulesData,
		messages:messagesData,
		errorClass: "error",
                highlight: function(obj) {
                    jQuery(obj).addClass("error");
                    jQuery(obj).parent('.customSelect').addClass("error");
                },
                unhighlight: function(obj) {
                    jQuery(obj).removeClass("error");
                    jQuery(obj).parent('.customSelect').removeClass("error");
                }
	 });
   }
	 function submitFrm(obj){
	 
	 if(obj.valid()){
		obj.submit();
		return true;
	 }
	 return false;
 }
 
   function delData(obj){
	   jQuery(".delRecord").bind("click",function(){
		   var trashURL="";
		   var popMsg="permanent delete";
		if(isTrashEnable()==true){
						if(jQuery("#isTrash").val()=="1"){
							trashURL+="&show=trash";
						} else {
							popMsg="trash";
						}
	    }   
		if(confirm('Do you really want to '+popMsg+' this record(s)'))
                {
                    var url=window.location.href.split('?')[0].replace(/list/g,"delete");
                    pageid=getCurrentPage(); 
                    jQuery.ajax({
                            url:url+"?id="+jQuery(this).attr("data-title")+trashURL,
                            async:true,
                            success:function(data){
                                    jQuery(".heading").before(data);
                                    doPaging(pageid,'loader',obj,createRows);
                                    displayMessage(data); 
                            }
                    });
                }
	});
   }
   
   function changeStatus(obj){
	     jQuery(".chStatus").bind("click",function(){
		 
		var url=window.location.href.split('?')[0].replace(/list/g,"change_status");
			pageid=getCurrentPage();
			var activeInactive = new Array();
			activeInactive[0]='inactive';
			activeInactive[1]='active';
			var tabURL = window.location.href.split('?')[0].split("/");
			if(tabURL[tabURL.length-1]=="notification_list" || tabURL[tabURL.length-1]=="enquiry_list")
		    {
		      activeInactive[0] = 'mark unread';
			  activeInactive[1] = 'mark read';
			}
							
		if(confirm('Do you want to '+(jQuery(this).attr("data-status")=='0'?activeInactive[0]:activeInactive[1])+' this record?'))
			jQuery.ajax({
				url:url+"?id="+jQuery(this).attr("data-title")+"&status="+jQuery(this).attr("data-status"),
				async:true,
				success:function(data){
					jQuery(".heading").before(data);
					doPaging(pageid,'loader',obj,createRows);	
					displayMessage(data);
				}
			}); 
	});
   } 
  function displayMessage(message){
          jQuery('.message').hide();
          jQuery('.message').html(message).show();
          if(jQuery('.message').find('.messages').length !== 0)
          {
            jQuery('.messages').hide();
            jQuery('.message .messages').show();
          } 
    }
  function pagesLinkDisplay(start,end){
			//jQuery(".pageNav ul li").hide();
		
			jQuery(".pageNav ul li a.prev").show();
			jQuery(".pageNav ul li a.next").show();
		
			jQuery(".pagging").hide();
			jQuery(".pagging").closest("li").hide();
			 
			jQuery(".pagging").slice(parseInt(start),parseInt(end)).each(function(index) { 
				jQuery(this).closest("li").show();
				jQuery(this).show();
			});
		
			
  } 
 
/** Cropping Functions **/

function hasExtension(inputID, exts) {
    var fileName = document.getElementById(inputID).value;
    return (new RegExp('(' + exts.join('|').replace(/\./g, '\\.') + ')$')).test(fileName.toLowerCase());
}

 function PreviewImage(checkSize) {
	 	jQuery("#imageCrop").attr("src","");
	 if(cropper){
		
				 cropper.destroy();
				}
	 var filesize = ((document.getElementById("uploadImage").files[0].size/1024)/1024).toFixed(4); // MB
	 if(filesize > 10){
		alert('Please image size should not be more than 10 MB');
			jQuery("#uploadImage").val("");
			jQuery("#imageCrop").hide();
			return false; 
	 }
	 if (!hasExtension('uploadImage', ['.jpg', '.gif', '.png','.jpeg']) ) {
			alert('Please upload image with proper extensions');
			jQuery("#uploadImage").val("");
			jQuery("#uploadImage").prev("span.text").html("");
			jQuery("#imageCrop").hide();
			return false;
	}
	//alert(jQuery("#thumbFolder").val());
    var wh=setWidthHeight(jQuery("#thumbFolder").val());
	 var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("uploadImage").files[0]);

        oFReader.onload = function (oFREvent) {
			
		   document.getElementById("imageCrop").src ="";
           document.getElementById("imageCrop").src = oFREvent.target.result;
			var img=document.getElementById("imageCrop");
			var flg=true;
			/*img.onload = function(){
			    // alert(jQuery('#imageCrop').prop('naturalWidth'));
				// alert(jQuery('#imageCrop').prop('naturalWidth'));
				 /*if((jQuery('#imageCrop').prop('naturalWidth') < wh[0]  && jQuery('#imageCrop').prop('naturalHeight') < wh[1]) && jQuery("#uploadImage").val()!=""){ 
					 
					 if(cropper){
						 cropper.destroy();
					 }
					 jQuery("#imageCrop").hide();
					 jQuery("#imageCrop").attr("src","");
					 jQuery("#uploadImage").val("");
					 jQuery("#uploadImage").prev("span.text").html("");
						alert('Please upload image with proper dimensions');
					 
					 flg=false;
					  //return false;
				 } else{
					flg=true;
			
			//jQuery("#imageCrop").show();
				 }
				 
			}*/
			//clearObj(img);
			 flg=true;
			if(flg==true){
					getImageUploader(img);	
				    loadCropSlideBar();
					jQuery("#zoomSection").show();
			} else {	
				loadCropSlideBar();	
				jQuery("#zoomSection").hide();
				return false;
			}
			
			delete oFREvent;			
		}
	    delete oFReader;
		
 }
 
 function setWidthHeight(folder){
	 /*var getText=jQuery("span.infoNote").find("b").html();
	 var setText=getText.replace("Recommended size:","");
	 setText=setText.replace(/px/g,"");
     setText=setText.replace(/ /g,"");		
	 setText=setText.replace(/width/g,"");
	 setText=setText.replace(/height/g,"");
	 console.log(setText.split(","));*/
	 setText=setAspectRatio(folder,true);
 	 return setText;	
 }
 
  var cropper;
 
  function getImageUploader(imgObj) {
	  /*
	   *{
        aspectRatio:1/1,
		movable: true,
        zoomable: false,
        rotatable: false,
        scalable: false
      }
	   */   
	   //alert(parseInt(jQuery("#imageCrop").attr('data-aratio-w')));
	   //alert(parseInt(jQuery("#imageCrop").attr('data-aratio-h')));
 cropper = new Cropper(imgObj,{aspectRatio: (parseInt(jQuery("#imageCrop").attr('data-aratio-w'))/parseInt(jQuery("#imageCrop").attr('data-aratio-h'))),
            viewMode: 0,
			autoCropArea: 0,
			dragMode:'move',	
            responsive: false,
            movable: false,
            zoomable: true,
            strict: false,
            touchDragZoom: false,
			zoomOnWheel : false,
			scalable: false,
			resizable:false,
			minCropBoxWidth: parseInt(jQuery("#imageCrop").attr('data-aratio-w')),
			minCropBoxHeight: parseInt(jQuery("#imageCrop").attr('data-aratio-h')),
			cropBoxResizable: false, 
			toggleDragModeOnDblclick:false,
			cropBoxMovable: true, 
            dragCrop: false,
			  data: {
     height: parseInt(jQuery("#imageCrop").attr('data-aratio-h')), // Maybe need computation
     width: parseInt(jQuery("#imageCrop").attr('data-aratio-w'))
    } 
		 
 }	
   ); 
   
   Cropper.template = [
    '<div class="cropper-container">',
        '<div class="cropper-modal"></div>',
        '<div class="cropper-dragger">',
            '<span class="cropper-preview"></span>',
            '<span class="cropper-dashed dashed-h"></span>',
            '<span class="cropper-dashed dashed-v"></span>',
            '<span class="cropper-face" data-direction="*"></span>',
        '</div>',
    '</div>'
].join("");
  }
  
   function clearObj(){
   if(cropper){	 
 
					//if(jQuery("#"+jQuery("#thumbPreview").val()).next(".delImg").length == 0 && jQuery("#"+jQuery("#thumbHidden").val()).val()=="") {
						cropper.destroy();
						jQuery("#uploadImage").val("");
						
					jQuery("#imageCrop").hide();
					jQuery("#imageCrop").attr("src","");
					//} 
   }
 }
 function setAspectRatio(folder,size){
	 var w=16;
	 var h=9;
	 var wh=new Array();
	 
	 switch(folder){
		case "logo":
			/*w=150;
			h=29;
			wh[0]=300;
			wh[1]=58;*/
			w=1;
			h=1;
			wh[0]=185;
			wh[1]=185;
		break;
		case "directoryslider":
			/*w=327;
			h=208;
			wh[0]=654;
			wh[1]=416;*/
			w=16;
			h=10;
			wh[0]=1280;
			wh[1]=760;
		break;
		case "team":
			w=1;
			h=1;
			wh[0]=158;
			wh[1]=158;
		break;
		case "testimonial":
			w=1;
			h=1;
			wh[0]=158;
			wh[1]=158;
		break;
		case "media":
			w=131;
			h=83;
			wh[0]=655;
			wh[1]=415;
		break;
		case "profileblog":
			w=1;
			h=1;
			wh[0]=158;
			wh[1]=158;
		break;
		 
		
	}
	if(wh.length==0){
		wh[0]=800;
		wh[1]=600;
	}
	jQuery("#imageCrop").attr("data-aratio-w",wh[0]);
	jQuery("#imageCrop").attr("data-aratio-h",wh[1]);
	jQuery(".cropSize").html("<small><strong>Recommended size: width: "+wh[0]+"px, height: "+wh[1]+"px</strong></small>");
	if(size){
		return wh;
	}
}
/*****************/  
  
 function getCurrentPage(){
	if(jQuery(".pagging.active").length > 0)
		return jQuery(".pagging.active").attr('id').replace(/pagging/g,'');
	else 
		return 0;
 }
 
function setSearchedData(searchData){ 
var objSearch=jQuery.parseJSON(searchData.replace(/&quot;/g,'"'));
	 jQuery.each(objSearch,function(index,val){
		 jQuery("#searchFrm").find('[name="'+index+'"]').val(val);
	 }); 
}

	
 function doPaging(index,loaderCls,tblObj,callBack,sortData,searchString){
 
	if(tblObj.length >0){
	 
	jQuery("#pagging"+index).addClass("active"); 
	 jQuery("."+loaderCls).show();
	 var url=window.location.href.split('?')[0]+"?isAjax=true&page="+index;
	 if(sortData && sortData!=""){
		 url+="&sort="+sortData;
	 }
	 if(jQuery("#showTask").length > 0 ) {
		 url+="&show="+jQuery("#showTask").val();
	 }
	 if(resetBtn==true){
		 resetBtn=false;
		 url+="&reset=true";
	 }
	
	 if(jQuery("#limit").val()!=""){
		  if(jQuery("#limit").val()!="10"){
				jQuery(".pagging.active:last").removeClass("active");
			}
		 url+="&limit="+jQuery("#limit").val();
	 }
	 
	 
	 if(isTrashEnable()==true && jQuery("#isTrash").val()=="1") {
		 url+="&show=trash";
	 }
	 
	 
	 if(!searchString){
		 searchString='';
	 }
 
	 if(jQuery("#txtSearch").val()!=""){
		  
		 searchString=jQuery("#searchFrm").serialize();
	 }
	 
	 jQuery.ajax({
		 url:url,
		 async:true,
		 type:"post",
		 data:searchString,
		 success:function(data){
			if(data.length > 0 ) { 
			 jQuery("."+loaderCls).hide();
			 var dataJson = jQuery.parseJSON(data);
			 
			 jQuery("#totalCount").val(dataJson.totalCount);
			 if(parseInt(jQuery("#totalCount").val())==0){
				 jQuery(".pageNav").hide();
			 } else {
				  jQuery(".pageNav").show();
			 }
			
			 createPages(index);
			 callBack(dataJson.data,tblObj);
			 delData(tblObj);
			 changeStatus(tblObj); 
			} 
		 }
	 });
	}
 }
 
   function loadNextPrev(obj) {
		 jQuery(".next").bind("click",function(){ 
			var id=getCurrentPage();
			if(parseInt(id) > (parseInt(jQuery("#totalCount").val())) || (parseInt(id)+5) >  (parseInt(jQuery("#totalCount").val()))){ 
				jQuery(this).closest("li").hide();
				return false;
			} 
			jQuery("#pagging"+id).removeClass("active");
			id=parseInt(id)+1;
			 jQuery("#pagging"+id.toString()).addClass("active");
			/*if(id%5==0){
				pagesLinkDisplay(id,id+5);
		    }*/ 
			doPaging(id,'loader',obj,createRows); 
	});
 
	
	 
			jQuery(".prev").bind("click",function(){
			var id=getCurrentPage();
			if(id <= 0){
				return false;
			} 
			
			jQuery("#pagging"+id).removeClass("active");
			id=parseInt(id)-1;
		    jQuery("#pagging"+id.toString()).addClass("active");
			/*if(id%5==0 && id!=0){
				pagesLinkDisplay(id-5,id);
		    }*/ 
			doPaging(id,'loader',obj,createRows);
		});
	 
	}
 
 function createPages(index,obj){
	 
	 var cnt = parseInt(jQuery("#totalCount").val());
   	 
	 if(cnt > 1){
		 jQuery(".pagging").show(); 
		if(index==0){
			jQuery(".prev").hide();
			jQuery(".next").show();
		}
		else if (index==cnt){
			jQuery(".prev").show();
			jQuery(".next").hide();
		} 
		 
		else{
			jQuery(".prev").show();
			jQuery(".next").show();
		}
		 //alert('hi');
		//jQuery(".pagging").closest("li").remove();
		   
		 for(i=cnt;i<jQuery(".pagging").length;i++){
			//html+='<li><a id="pagging'+i+'" class="pagging '+(i==index?"active":"")+'" href="javascript:;">'+(parseInt(i)+1)+'</a></li>';
			jQuery("#pagging"+i).hide();
		}  
		 
		 
		if(cnt > 5) {
            if(parseInt(index)+5 > cnt ){
				pagesLinkDisplay(cnt-5,cnt);
				jQuery(".next").hide();
			} else {
				pagesLinkDisplay(parseInt(index),parseInt(index)+5);
			}			
			
		}  
	 if(cnt < 5){
		  
		 jQuery(".prev").hide();
		jQuery(".next").hide();
 
	 }
		
		//jQuery(".prev").closest("li").after(html);
		
	 }else{
		jQuery(".pagging").hide(); 
		jQuery(".prev").hide();
		jQuery(".next").hide();
	 }
 }

function delImg(obj){
	 var yn=confirm('Are you sure want to delete this image?');
	 if(yn){
	 jQuery.ajax({
		url:jQuery(obj).attr("data-url"),
		data:{del:true},
		type:"POST",
		success:function(data){
			jQuery("#"+jQuery(obj).attr("data-preview")).hide();
			jQuery("#"+jQuery(obj).attr("data-hidden")).val("");
			jQuery(obj).remove();
			if(cropper){
				cropper.destroy();
				jQuery("#uploadImage").val("");
				jQuery("#uploadImage").prev("span.text").html("");	
				jQuery("#imageCrop").hide();
				jQuery("#imageCrop").attr("src","");
			}
		}
	 });
	 }
}
      jQuery('.popclick').off('click');	
  jQuery(document).on('click', '.popclick', function(e) {
        var linkAttrib = jQuery(this).attr('data-pop');
        var colorClass = jQuery(this).attr('data-colorclass');
        jQuery('.poptitle').removeClass().addClass(' poptitle '+colorClass);
		
		if(jQuery("#crop").length > 0 ){
			jQuery("#imageCrop").hide();
			var hdnData = jQuery("#"+jQuery(this).attr("data-hiddenData")).val();
		   if(hdnData!=""  || jQuery("#imageCrop").attr("src")!=""){	
			
			jQuery("#imageCrop").attr("src",jQuery("#"+jQuery(this).attr("data-preview")).find("img").attr("src").replace("small","large")).load(function(){
				 //jQuery("#imageCrop").show();
			});
			if(cropper){
				cropper.destroy();
			}
			
			
			jQuery("#zoomSection").show();
		   } else{
			   jQuery("#zoomSection").hide();
		   }
		   jQuery("#thumbPreview").val(jQuery(this).attr("data-preview"));
		   jQuery("#thumbFolder").val(jQuery(this).attr("data-folder"));
		   jQuery("#thumbUser").val(jQuery(this).attr("data-user"));
		   jQuery("#thumbHidden").val(jQuery(this).attr("data-hiddenData"));
			setAspectRatio(jQuery(this).attr("data-folder"));
			getImageUploader(document.getElementById("imageCrop"));
			loadCropSlideBar();
			
			/*if(jQuery("#imageCrop").attr("src")!=""){
				jQuery("#imageCrop").show();
			}*/
		   //setWidthHeight(jQuery(this).attr("data-folder"));
		   
		   	
		}
    
        
        jQuery('#' + linkAttrib).addClass("popVisible");
        jQuery('body').addClass('bodyFixed');
    });
    jQuery(document).on('click', '.closePopup, .overlayer', function(e) {
        jQuery('.popupMain').removeClass("popVisible");
        jQuery('.tabing').removeClass('current');
        jQuery('.imgTabing li.tabing:first').addClass('current');
        jQuery('body').removeClass('bodyFixed');
		if(jQuery(".closeCrop").length > 0){
				jQuery("#uploadImage").val("");
				jQuery("#imageCrop").hide();
				jQuery("#uploadImage").prev("span.text").html("");				
				clearObj(); 
                                
		 }
		if(jQuery("#selectFile").length > 0) {
			jQuery("#popDetails").show();
			jQuery("#selectFile").hide();
                        
		}

    });
 	

function fileUploader(obj,folder,previewObj,userid,hiddenObj,crop){

  if(crop){
	
	 
	 obj.closest("div").addClass("popclick"); 
	 obj.closest("div").attr("data-preview",previewObj.closest("div").attr("id"));
	 obj.closest("div").attr("data-folder",folder);
	 obj.closest("div").attr("data-user",userid);
	 obj.closest("div").attr("data-hiddenData",hiddenObj.attr("id"));
	 obj.closest("div").attr("data-pop","crop");
	 obj.remove(); 
	 /*if( jQuery("#imageCrop").attr("src")!=""){
		 jQuery("#imageCrop").attr("src",previewObj.attr("src"));
		 jQuery("#imageCrop").show();
	 }
	 //setWidthHeight(jQuery("#uploadImage"),new Array(158,158));
	 jQuery("#thumbPreview").val(previewObj.closest("div").attr("id"));
	 jQuery("#thumbFolder").val(folder);
	 jQuery("#thumbUser").val(userid);
	 jQuery("#thumbHidden").val(hiddenObj.attr("id"));*/		
	 
  } else {
	  jQuery(function() {
        'use strict';
        // Change this to the location of your server-side upload handler:
		var url = baseURL+"user/upload-image/"+folder+"/"+userid+"/"+jQuery("#directory_id").val();
        var dataIndex = obj.attr('data-id');
		 
        
        obj.fileupload({
            url: url,
            dataType: 'json',
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
            maxFileSize: 5000000,
            done: function(e, data) {
				
				var imgURL=data.result.files[0].url;
				
				if(imgURL!=""){
			    jQuery("#progress"+dataIndex).removeClass("progress");
				previewObj.closest("div").find("a").remove(); 
				previewObj.closest("div").show();
				previewObj.closest("div").append("<a title='Delete Image' href='javascript:' data-url='"+imgURL+"' data-hidden='"+hiddenObj.attr("id")+"' data-preview='"+previewObj.closest("div").attr("id")+"' onclick='delImg(this)'>Delete</a>");
                previewObj.attr("src",imgURL+"?"+new Date().getTime());      
				previewObj.show();
                hiddenObj.val(data.result.files[0].name); 	
				}
					
            }, 
            progressall: function(e, data) { 
                jQuery('#progress'+dataIndex).show();
                var progress = parseInt(data.loaded / data.total * 100, 10);
                jQuery('#progress'+dataIndex+' .progress-bar').css(
                        'width',
                        progress + '%'
                        );
                jQuery('#progress'+dataIndex+' .progress-bar').show();
                jQuery('#progress'+dataIndex+' .uploading').show();
				jQuery('#progress'+dataIndex).addClass("progress");
                if(progress > 99)
                {
                  jQuery('#progress'+dataIndex+' .uploading').hide(); 
                }
                
            }
        }).on('fileuploadprocessalways', function(e, data) {
            var index = data.index,
			 dataIndex= index+1,
                    file = data.files[index]; 
					 
            if (file.error) {
                dataIndex = jQuery('#'+obj.attr('id')).attr('data-multi-id');
                if(!dataIndex || dataIndex == 'undefined' || dataIndex =='')
                    dataIndex = jQuery('#'+obj.attr('id')).attr('data-id');
                jQuery('#progress'+dataIndex).hide();
                jQuery("#fileError"+dataIndex).html("<span style='color:#ff0000;'>" + file.error + "</span>");
                jQuery("#fileError"+dataIndex+".validation-advice").show();
                obj.addClass('validation-failed'); 
            }
            else{
               dataIndex = jQuery('#'+obj.attr('id')).attr('data-multi-id');
                if(!dataIndex || dataIndex == 'undefined' || dataIndex =='')
                    dataIndex = jQuery('#'+obj.attr('id')).attr('data-id');
                obj.removeClass('validation-failed');
                jQuery("#fileError"+dataIndex+".validation-advice").hide();
				
				previewObj.attr("src","");
				
				jQuery("#progress"+dataIndex).hide();
                jQuery("#fileError"+dataIndex).html("");
            }
            
        });
    });
  }
  
}

function pdfUploader(obj,folder,previewObj,userid,hiddenObj){
	 
  jQuery(function() {
        'use strict';
        // Change this to the location of your server-side upload handler:
       
		var url = baseURL+"user/upload-image/"+folder+"/"+userid+"/"+jQuery("#directory_id").val();
        var dataIndex = obj.attr('data-id');
		
        obj.fileupload({
            url: url,
            dataType: 'json',
            acceptFileTypes: /(\.|\/)(pdf)$/i,
            maxFileSize: 10000000,
            done: function(e, data) { 
				jQuery("#progress"+dataIndex).removeClass("progress");
				hiddenObj.val(data.result.files[0].name); 
				var  pdfURL=window.location.href.split('?')[0].replace(/add/g,"delete_pdf");
			 
				previewObj.show();
				previewObj.closest("div").show();
				previewObj.closest("div").append("<a title='Delete PDF' data-url='"+pdfURL+"' data-hidden='"+hiddenObj.attr("id")+"' data-preview='"+previewObj.closest("div").attr("id")+"' href='javascript:' onclick='delPdf(this)'>Delete</a>");
                jQuery("#fileError"+dataIndex).html("");	
            },
			success:function(data){
				previewObj.wrap("<a target='_blank' href='"+data.files[0].url+"'></a>");
			 
		},
            progressall: function(e, data) { 
				jQuery("#progress"+dataIndex).addClass("progress");
                jQuery('#progress'+dataIndex).show();
                var progress = parseInt(data.loaded / data.total * 100, 10);
                jQuery('#progress'+dataIndex+' .progress-bar').css(
                        'width',
                        progress + '%'
                        );
                jQuery('#progress'+dataIndex+' .progress-bar').show();
                jQuery('#progress'+dataIndex+' .uploading').show();
                if(progress > 99)
                {
                  jQuery('#progress'+dataIndex+' .uploading').hide(); 
                }
                
            }
        }).on('fileuploadprocessalways', function(e, data) {
            var index = data.index,
			 dataIndex= index+1,
                    file = data.files[index]; 
					 
            if (file.error) {
                dataIndex = jQuery('#'+obj.attr('id')).attr('data-id');	 
                jQuery('#progress'+dataIndex).hide();
                jQuery("#fileError"+dataIndex).html("<span style='color:#ff0000;'>" + file.error + "</span>");
                jQuery("#fileError"+dataIndex+" .validation-advice").show();
                obj.addClass('validation-failed'); 
            }
            else{
		dataIndex = jQuery('#'+obj.attr('id')).attr('data-id');	 		 
                obj.removeClass('validation-failed');
                jQuery("#fileError"+dataIndex+" .validation-advice").hide();
                
            }
            
        });
    });
}

function delPdf(obj){ 
	var objData={isAjax:true,pdf:jQuery("#"+jQuery(obj).attr("data-hidden")).val(),userID:jQuery("#userFolder").val()};
	 jQuery.ajax({
		url:jQuery(obj).attr("data-url"),
		data:objData, 
		type:"POST",
		success:function(data){
			jQuery("#"+jQuery(obj).attr("data-preview")).hide();
			jQuery("#"+jQuery(obj).attr("data-hidden")).val("");
			jQuery(obj).remove();
		}
	 });
}
/** Auto save function ***/
var liveAutoSave=true;
function isLiveAutoSave(){
	return liveAutoSave;
} 
function autoSave(formObj,actionURL){
   if(isLiveAutoSave()==true && jQuery("#service_provider").prop("checked")==true){  
        var newActionURL=actionURL;
		if(actionURL.indexOf("auto_save") != -1){
			
		} else {
			if(actionURL.indexOf("?") != -1){
					actionURL=actionURL+"&auto_save="+liveAutoSave;	
			} else {
				actionURL=actionURL+"?auto_save="+liveAutoSave;	
			}
			
		} 
		
		jQuery.ajax({
				url:actionURL,
				type:"POST",
				async: false,
				data:formObj.serialize(),
				success:function(data){
				   if(data!=""){
					 var jdata=jQuery.parseJSON(data);
					 if(jdata.action_update){
						 
						formObj.attr("action",newActionURL+"?auto_save="+liveAutoSave+"&id="+jdata.action_update.uid+"&directory_id="+jdata.action_update.directoryId+"&page=0");
						jQuery("input[name='isEdit']").val(jdata.action_update.directoryId);
						jQuery("#uid").val(jdata.action_update.uid);
					 }  
				   }	
					
						console.log(data);
				}
		});  
   }
}
