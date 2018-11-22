

function loadTinymce(image,id) {
        var livePath =(baseURL+"theme/js/");
        var path = (baseURL+"theme/js/"); 
		var setPath="";
		if(jQuery('input[name=isEdit]').length > 0) {
			setPath="/"+jQuery('input[name=isEdit]').val();
		} else if(jQuery("#userFolder").length > 0){
			setPath="/"+jQuery('#userFolder').val();
		} else if(window.location.href.indexOf("parts_add")!=-1){
			setPath="/parts/"+jQuery('#random_code').val();
		} 
			
		 //var rootPath = (jQuery("#toolbar-administration").length > 0?'/files'+setPath:'/files');
		 var rootPath ='/files'+setPath;
        tinymce.init({
							
                content_css: path+"tinymce/css/fck-style.css",
                selector: '#'+id,
                formats : {
					alignleft : {selector : 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes : 'alignleft'},
                  aligncenter : {selector : 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes : 'aligncenter'},
                  alignright : {selector : 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes : 'alignright'},
                  alignfull : {selector : 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes : 'full'},
                  bold: { inline: 'span', 'classes': 'bold' },
                italic: { inline: 'span', 'classes': 'italic' },
                underline: { inline: 'span', 'classes': 'underline', exact: true },
                strikethrough: { inline: 'del' },
                  customformat : {inline : 'span', styles : {color : '#00ff00', fontSize : '20px'}, attributes : {title : 'My custom format'}}
                },
               menubar: false,
                relative_urls: false,
                remove_script_host: false,
                convert_urls: true,
                force_p_newlines:true,
//              force_br_newlines:true,
                paste_as_text: true,
                paste_data_images: true,
				moxiemanager_title:'Worthy Parts',
				moxiemanager_leftpanel: false,
				moxiemanager_extensions : 'jpg,jpeg,png,JPG',
				//drupalSettings.user.uid
				 moxiemanager_rootpath : rootPath,
                plugins: [
                    "advlist autolink lists link image charmap print preview anchor hr paste",
                    "searchreplace visualblocks code fullscreen",
                    "insertdatetime media table contextmenu paste textcolor template imagetools"
                ],
				
                toolbar: "insertfile undo redo | hr | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist outdent indent | link media | forecolor backcolor | image",
				
				gecko_spellcheck : true,
                forced_root_block: "",
                link_class_list: [
                    {title: 'None', value: ''},
                    {title: 'cmsButton', value: 'cmsButton'}

                ],
				
				
            
				 
                setup: function(editor) {

            //                                editor.on('PostProcess', function(ed) {
            //                                    // we are cleaning empty paragraphs
            //                                    ed.content = ed.content.replace(/(<p>&nbsp;<\/p>)/gi, '<br />');
            //                                });
			editor.on('blur', function (e) { 
						 if(isLiveAutoSave()==true){  
						  editor.save();
							autoSave(jQuery("#edit_profile"),jQuery("#edit_profile").attr("action"));
						 }
					});


                },
				init_instance_callback: function (editor) {
					
				},
                 onchange_callback: function(editor) {
                    tinyMCE.triggerSave();
                    jQuery("#" + editor.id).valid();
                  },
				  file_picker_types: 'file image media',
				  /*file_browser_callback: 'file image media'*/
                /*file_browser_callback: function(field, url, type, win) {
                        tinyMCE.activeEditor.windowManager.open({
                        file: path+'plugin/tinymce/js/kcfinder/browse.php?opener=tinymce4&field=' + field + '&type=' + type,
                        title: 'KCFinder',
                        width: 700,
                        height: 500,
                        inline: true,
                        close_previous: false,
                    }, {
                        window: win,
                        input: field
                    });
                    return false;
                },*/
				/* Above "file_browser_callback" is commented and below "external_plugins" inserted to load tinymce with "moxiemanager" images upload option - Rohit Avasthi - 04-12-2017 tinymce.documentBaseURL + */
				external_plugins: { 
					'moxiemanager': baseURL+'moxiemanager-php-pro/plugin.js'
				}
        });
  }

        