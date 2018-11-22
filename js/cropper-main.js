
var console = window.console || {log: function() {
    }};
	
var mediaDirPath="../sites/default/media/worthyparts/189/";

/***
 * 
 * @param object $element part in which cropping will done for eg. id model box
 * @param object main image thumbnail object
 * @param object crop image thumbnail object
 * @param object edit image link object
 * @param string main image directory
 * @param string crop image directory
 * @param object hidden variable of image object
 * @param string delUrl delete image action url
 * @param string appType used to identify front or admin action
 * 
 * @returns {CropAvatar}
 */
function CropAvatar($element, mainImg, cropImg, cropLink, mainDir, cropDir, hdnVar, delUrl, appType, btnObj, imageObj) {
    this.$container = $element;

    this.$avatarView = btnObj;
    this.$avatar = this.$avatarView.find('img');
    this.$croppedImg = cropImg;
    this.$mainImg = mainImg;
    this.$cropLink = cropLink;
    this.$hdnVal = hdnVar;
    this.$mainDir = mainDir;
    this.$cropDir = mainDir+"/"+cropDir;
    this.$delURL = delUrl;
    this.$appType = appType;

    this.$avatarModal = this.$container.find('#avatar-modal');
    this.$loading = this.$container.find('.loading');

    this.$avatarForm = this.$avatarModal.find('.avatar-form');
    this.$avatarUpload = this.$avatarForm.find('.avatar-upload');
    this.$avatarSrc = this.$avatarForm.find('.avatar-src');
    this.$avatarData = this.$avatarForm.find('.avatar-data');
    this.$avatarInput = this.$avatarForm.find('.avatar-input');
    this.$avatarSave = this.$avatarForm.find('.avatar-save');
    this.$avatarBtns = this.$avatarForm.find('.avatar-btns');

    this.$avatarWrapper = this.$avatarModal.find('.avatar-wrapper');
    this.$imgUrl = "";
    this.$avatarPreview = this.$avatarModal.find('.avatar-preview');

    this.init();
    //this.$avatarModal.on('hidden.bs.modal', function () {  });
//    console.log(this);
    /* custom code to load image if imageObj is not blank or set */
    if (typeof(imageObj) != "undefined" && imageObj != "") {
        filename = imageObj[0].name;
		loadCrop($element, mainImg, cropImg, cropLink, mainDir, cropDir, hdnVar, delUrl, appType, btnObj, imageObj);
        checkImage(mediaDirPath + mainDir + "/" + filename,
                function() {
                    loadCrop($element, mainImg, cropImg, cropLink, mainDir, cropDir, hdnVar, delUrl, appType, btnObj, imageObj);
                },
                function() {
                    return;
//					console.log("Error in image found...!!!");
                }
        );

    }
}

CropAvatar.prototype = {
    constructor: CropAvatar,
    support: {
        fileList: !!jQuery('<input type="file">').prop('files'),
        blobURLs: !!window.URL && URL.createObjectURL,
        formData: !!window.FormData
    },
    init: function() {
        this.support.datauri = this.support.fileList && this.support.blobURLs;

        if (!this.support.formData) {
            this.initIframe();
        }

        this.initTooltip();
        this.initModal();
        this.addListener();
    },
    addListener: function() {
        this.$avatarView.on('click', jQuery.proxy(this.click, this));
        this.$avatarInput.on('change', jQuery.proxy(this.change, this));
        this.$avatarForm.on('submit', jQuery.proxy(this.submit, this));
        this.$avatarBtns.on('click', jQuery.proxy(this.rotate, this));
    },
    initTooltip: function() {
        this.$avatarView.tooltip({
            placement: 'bottom'
        });
    },
    initModal: function() {

        this.$avatarModal.modal({
            show: false
        });



    },
    initPreview: function() {
        //var url = this.$avatar.attr('src');

        //this.$avatarPreview.empty().html('<img src="' + url + '">');
    },
    initIframe: function() {

        var target = 'upload-iframe-' + (new Date()).getTime(),
                $iframe = jQuery('<iframe>').attr({
            name: target,
            src: ''
        }),
        _this = this;

        // Ready ifrmae
        $iframe.one('load', function() {

            // respond response
            $iframe.on('load', function() {
                var data;

                try {
                    data = jQuery(this).contents().find('body').text();
                } catch (e) {
                    console.log(e.message);
                }

                if (data) {
                    try {
                        data = jQuery.parseJSON(data);
                    } catch (e) {
                        console.log(e.message);
                    }

                    _this.submitDone(data);
                } else {
                    _this.submitFail('Image upload failed!');
                }

                _this.submitEnd();

            });
        });

        this.$iframe = $iframe;
        this.$avatarForm.attr('target', target).after($iframe.hide());
    },
    click: function() {
        this.$container.find("#avatar-modal-label").html('Upload Image');
        this.$container.find("#avatarInput").show();
        this.$container.find("#avatarInput").prev("label").show();
        this.$container.find('.avatar-wrapper').html('<img id="edit-cropped" src="" style="display:none" />');
        //alert("hi");
        this.$avatarInput.val("");
        this.$avatarModal.modal('show');
        this.initPreview();
    },
    change: function() {
        // alert("hi again");
        var files,
                file;

        if (this.support.datauri) {
            files = this.$avatarInput.prop('files');

            if (files.length > 0) {
                file = files[0];

                if (file.size > 4000000) {
                    alert('Maximum file upload size is 4 MB. Please select file again');
                    this.$avatarInput.val('');
                    return false;
                }
                if (this.isImageFile(file)) {
                    readURL('avatarInput' + this.$container.attr("id"), this.$mainImg.attr("id"));

                    if (this.url) {
                        URL.revokeObjectURL(this.url); // Revoke the old one
                    }

                    this.url = URL.createObjectURL(file);
                    this.startCropper();
                } else {
                    alert('Invalid File Type.Please upload jpg, gif, png extension file');
                    this.$avatarInput.val('');
                    return false;
                }
            }
        } else {
            file = this.$avatarInput.val();

            if (this.isImageFile(file)) {
                this.syncUpload();
            }
        }
        this.$container.find("#avatarHidden").val("");
    },
    submit: function() {
        if (!this.$avatarSrc.val() && !this.$avatarInput.val()) {
            return false;
        }

        if (this.support.formData) {
            this.support.formData;

            //alert(jQuery("#"+this.$croppedImg.attr("id")).closest("div"));
            //this.$mainImg.attr('src',this.url);
            this.$avatarModal.modal('hide');
            jQuery("#"+this.$croppedImg.attr("id")).closest("div").attr("style", jQuery(".preview-lrg-"+ this.$container.attr("id")).attr("style"));
            jQuery("#"+this.$croppedImg.attr("id")).closest("div").css("overflow","hidden");
            jQuery("#"+this.$croppedImg.attr("id")).closest("div").css("max-width","100%");
            jQuery("#"+this.$croppedImg.attr("id")).closest("div").show();
            this.$croppedImg.attr("src", jQuery(".preview-lrg-" + this.$container.attr("id") + " > img").attr("src"));
            this.$croppedImg.attr("style", jQuery(".preview-lrg-" + this.$container.attr("id") + " > img").attr("style"));
            this.$croppedImg.show();

            //alert("hi");
            this.ajaxUpload();
            return false;
        }
    },
    rotate: function(e) {
        var data;

        if (this.active) {
            data = jQuery(e.target).data();

            if (data.method) {
                this.$img.cropper(data.method, data.option);
            }
        }
    },
    isImageFile: function(file) {
        if (file.type) {
            return /^image\/\w+$/.test(file.type);
        } else {
            return /\.(jpg|jpeg|png|gif)$/.test(file);
        }
    },
    startCropper: function() {
        var _this = this;
        this.$imgUrl = this.url;
        //if (this.active) {  
        //     this.$img.cropper('replace', this.url);
        //  } else {  
        this.$img = jQuery('<img src="' + this.url + '">');
        this.$avatarWrapper.empty().html(this.$img);
        this.$img.cropper({
            aspectRatio: 2 / 3,
            responsive: true,
            movable: true,
            preview: this.$avatarPreview,
            zoomable: false,
            strict: false,
            touchDragZoom: true,
            dragCrop: true,
            modal: true,
            strict:false,
                    crop: function(data) {
                var json = [
                    '{"x":' + data.x,
                    '"y":' + data.y,
                    '"height":' + data.height,
                    '"width":' + data.width,
                    '"rotate":' + data.rotate + '}'
                ].join();

                _this.$avatarData.val(json);

            }
        });

        this.active = true;
        //}
    },
    stopCropper: function() {
        if (this.active) {
            this.$img.cropper('destroy');
            this.$img.remove();
            this.active = false;
        }
    },
    ajaxUpload: function() {

        var url = this.$avatarForm.attr('action'),
                data = new FormData(this.$avatarForm[0]),
                _this = this;
        jQuery("#loading" + _this.$container.attr("id")).show();
        jQuery("#qLoverlay" + _this.$container.attr("id")).show();
        //Disable buttons
        jQuery("#form_submit_hide").attr("style", "disabled='disabled'");
        jQuery(".shortcuts").hide();

        jQuery(jQuery("#" + _this.$croppedImg.attr("id")).closest("div")).after("<div class='cropLoader'>Cropping...</div>");
        
        jQuery.ajax(url, {
            type: 'post',
            data: data,
            dataType: 'json',
            async: true,
            processData: false,
            contentType: false,
            beforeSend: function() {
                _this.submitStart();
            },
            success: function(data) {
                //alert(_this.$container.attr("id"));
                jQuery("#loading" + _this.$container.attr("id")).hide();
                jQuery("#qLoverlay" + _this.$container.attr("id")).hide();
                jQuery("#form_submit_hide").removeAttr("disabled");
                jQuery(".shortcuts").show();

               //jQuery(jQuery("#" + _this.$croppedImg.attr("id")).closest("div")).find(".cropLoader").remove();
               jQuery(".cropLoader").remove();
                _this.submitDone(data);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                _this.submitFail(textStatus || errorThrown);
            },
            complete: function() {

                _this.submitEnd();
            }
        });
    },
    syncUpload: function() {
        this.$avatarSave.click();
    },
    submitStart: function() {
        this.$loading.fadeIn();
    },
    submitDone: function(data) {
        console.log(data);

        if (jQuery.isPlainObject(data) && data.state === 200) {
            if (data.result) {
                this.url = data.result;
                if (this.support.datauri || this.uploaded) {
                    this.uploaded = false;



                    if (this.$container.find("#avatarHidden").val().length == 0) {
                        this.$container.find("#avatarHidden").val(data.result.replace(this.$cropDir, this.$mainDir));
                    } else {
                        this.$imgUrl = data.result;

                    }
                    jQuery("label[for='hdnImg'].text-error").hide();


                    var replaceURL = this.$imgUrl.replace(this.$cropDir, this.$mainDir);
                    this.$mainImg.attr('src', replaceURL);
                    this.$mainImg.show();

                    if (jQuery("#" + this.$cropLink.attr("id")).next("span.delImg").length > 0) {
                        jQuery("#" + this.$cropLink.attr("id")).next("span.delImg").remove();
                    }
                    jQuery('<span class="red delImg" style="cursor:pointer" onclick="jQuery(this).remove();deleteFile(\'' + this.$delURL + '\',\'' + this.$hdnVal.attr("id") + '\',\'' + this.$appType + '\',\'' + this.$mainImg.attr("id") + '\',\'' + this.$croppedImg.attr("id") + '\',\'' + this.$cropLink.attr("id") + '\',\'' + this.$mainDir + '\',\'' + this.$cropDir + '\',\'' + this.$container.attr("id") + '\');" title="Delete">X</span>').insertAfter(this.$cropLink);
                    this.$croppedImg.attr("style", "width:80px");
                    this.$croppedImg.attr('src', this.$container.find("#avatarHidden").val().replace(this.$mainDir, this.$cropDir) + '?' + Math.random());
                    this.$croppedImg.show();
                    this.$cropLink.show();
                    this.$hdnVal.val(getFileName(this.$container.find("#avatarHidden").val()));

                    this.$container.find(".cropBtn").show();
                    this.$container.find(".avatar-save").hide();
                    this.cropDone();
                } else {
                    this.uploaded = true;
                    this.$avatarSrc.val(this.url);
                    this.startCropper();
                }

                this.$avatarInput.val('');
            } else if (data.message) {
                this.alert(data.message);
            }
        } else {
            this.alert('Failed to response');
        }
    },
    submitFail: function(msg) {
        this.alert(msg);
    },
    submitEnd: function() {
        this.$loading.fadeOut();
    },
    cropDone: function() {
        this.$avatarForm.get(0).reset();
        this.$avatar.attr('src', this.url);
        this.stopCropper();
        this.$avatarModal.modal('hide');
    },
    alert: function(msg) {
        var $alert = [
            '<div class="alert alert-danger avater-alert">',
            '<button type="button" class="close" data-dismiss="alert">&times;</button>',
            msg,
            '</div>'
        ].join('');

        this.$avatarUpload.after($alert);
    }
};



/**
 * This function will execute clicking on edit image
 * @param object mainImg main image thumbnail object 
 * @param object cropImg cropped image thumbnail object
 * @param object hdnVar hidden variable object
 * 
 */
function cropImg(mainImg, cropImg, hdnVar, isEdit, obj) {
    popUp = jQuery("#" + obj);
	alert(  popUp.find('#avatar-modal').length);
    popUp.find("#avatar-modal-label").html('Edit Image');
    popUp.find("#avatarInput").hide();
    popUp.find("#avatarInput").prev("label").hide();
    htmlVar = '<img src=\'\' id=\'edit-cropped\' />';
    //jQuery('.avatar-view').trigger('click');
    if (isEdit == false) {
        popUp.find('#avatar-modal').modal('show');
    }
    popUp.find('.avatar-wrapper').html(htmlVar);
    popUp.find('#edit-cropped').attr('src', jQuery(mainImg).attr("src"));
    popUp.find('.avatar-src').val(jQuery(mainImg).attr("src"));
    var $image = popUp.find('.avatar-wrapper > img'),
            canvasData,
            cropBoxData;

    popUp.find('#avatar-modal').on('click', function() {
		alert("hi");
        $image.cropper({
            aspectRatio: 2 / 3,
            responsive: true,
            movable: true,
            zoomable: false,
            strict: false,
            touchDragZoom: true,
            dragCrop: true,
            modal: true,
            built: function() {
                $image.cropper('setCanvasData', canvasData);
                $image.cropper('setCropBoxData', cropBoxData);


            },
            crop: function(data) {
                var json = [
                    '{"x":' + data.x,
                    '"y":' + data.y,
                    '"height":' + data.height,
                    '"width":' + data.width,
                    '"rotate":' + data.rotate + '}'
                ].join();
                popUp.find(".avatar-data").val(json);
            },
        });
    });
    /*popUp.find('.cropBtn').click(function() {
     canvasData = $image.cropper('getCanvasData');
     cropBoxData = $image.cropper('getCropBoxData');
     
     data = $image.cropper('getData');
     var json = [
     '{"x":' + data.x,
     '"y":' + data.y,
     '"height":' + data.height,
     '"width":' + data.width,
     '"rotate":' + data.rotate + '}'
     ].join();
     popUp.find(".avatar-data").val(json);
     
     popUp.find("#avatar-form").submit();
     var srcImgs = popUp.find("#avatarHidden").val().replace("activity-main", "activity") + '?' + Math.random();
     
     $image.cropper('destroy');
     jQuery(mainImg).attr("src", popUp.find("#avatarHidden").val());
     jQuery(cropImg).attr("src", srcImgs);
     jQuery(hdnVar).val(getFileName(popUp.find("#avatarHidden").val()));
     });*/
}

/**
 * Get file name from url
 * @param {type} path
 * @returns file name
 */
function getFileName(path) {
    path = path.substring(path.lastIndexOf("/") + 1);
    return (path.match(/[^.]+(\.[^?#]+)?/) || [])[0];
}

/**
 * Delete Main and cropped file
 * @param string url image delete action URL
 * @param string hidden value id
 * @param string applicatin type front or admin
 * @param string main image id
 * @param string cropped image id
 * @param string cropped image link id
 * @param string main directory name
 * @param string crop directory name
 * 
 */

function deleteFile(url, hdnVar, appType, mainImg, croppedImg, croppedLink, mainDir, cropDir, divId) {
    var msg = confirm("Are you sure want to delete this file?");
    if (msg) {
        if (appType == "front") {
            url = url + "?";
        }
        var obj = jQuery("#" + divId);

        fileName = jQuery("#" + hdnVar).val();
        if (appType == "admin") {
            url = url + "&";
        }
                jQuery("#" + mainImg).attr("src", "../templates/" + appType + "/images/no-image.jpg");
                jQuery("#" + mainImg).hide();
                jQuery("#" + croppedImg).attr("src", "");
                jQuery("#" + croppedImg).hide();
                jQuery("#" + croppedLink).hide();
                obj.find(".avatar-wrapper").html('');
                jQuery("#" + hdnVar).val("");
                var files=jQuery("#delImg").val();
                files+=fileName+",";
                jQuery("#delImg").val(files);
//        jQuery.ajax({
//            url: url + "file=" + fileName,
//            type: 'post',
//            data: {file: fileName, mainDir: mainDir, cropDir: cropDir},
//            success: function(data) {
//                jQuery("#" + mainImg).attr("src", "../templates/" + appType + "/images/no-image.jpg");
//                jQuery("#" + mainImg).hide();
//                jQuery("#" + croppedImg).attr("src", "");
//                jQuery("#" + croppedImg).hide();
//                jQuery("#" + croppedLink).hide();
//                obj.find(".avatar-wrapper").html('');
//                jQuery("#" + hdnVar).val("");
//            }
//        });
    }
}


/**
 * to check image source is available or not.
 **/
function checkImage(src, good, bad) {
    var img = new Image();
    img.onload = good;
    img.onerror = bad;
    img.src = src;
}

/**
 * croped images load.....
 **/
function loadCrop(crop_avatar, mainImg, croppedImg, cropLink, mainDir, cropDir, hdnImg, delURL, appType, avatar_view, imageObj) {
    var imgData = imageObj[0];
    var fileName = imgData.name;
    mainImg.show();

    mainImg.attr("src", mediaDirPath + mainDir + "/" + fileName);
    croppedImg.show();
    croppedImg.attr("src", mediaDirPath + cropDir + "/" + fileName);
    cropLink.show();
    hdnImg.val(fileName);
    crop_avatar.find('.avatar-wrapper > img').attr("src", mediaDirPath + mainDir + "/" + fileName);
    jQuery('<span class="red delImg" style="cursor:pointer" onclick="jQuery(this).remove();deleteFile(\'' + delURL + '\',\'' + hdnImg.attr("id") + '\',\'' + appType + '\',\'' + mainImg.attr("id") + '\',\'' + croppedImg.attr("id") + '\',\'' + cropLink.attr("id") + '\',\'' + mainDir + '\',\'' + cropDir + '\',\'' + crop_avatar.attr("id") + '\');">X</span>').insertAfter(cropLink);

    crop_avatar.find('.avatar-src').val(jQuery(mainImg).attr("src"));
    crop_avatar.find(".avatar-save").hide();
    crop_avatar.find('.cropBtn').show();
//		console.log(mediaDirPath + activityMainDir + fileName);
    crop_avatar.find("#avatarHidden").val(mediaDirPath + mainDir + fileName);
    crop_avatar.find('.avatar-wrapper > img').cropper({
        aspectRatio: 2 / 3,
        responsive: true,
        movable: true,
        zoomable: false,
        strict: false,
        touchDragZoom: true,
        dragCrop: true,
        modal: true,
        crop: function(data) {
            var json = [
                '{"x":' + data.x,
                '"y":' + data.y,
                '"height":' + data.height,
                '"width":' + data.width,
                '"rotate":' + data.rotate + '}'
            ].join();
            crop_avatar.find('.avatar-data').val(json);
        }
    });
}
function readURL(input, imgId) {

    var oFReader = new FileReader();
    oFReader.readAsDataURL(document.getElementById(input).files[0]);

    oFReader.onload = function(oFREvent) {
        document.getElementById(imgId).src = oFREvent.target.result;
        jQuery("#" + imgId).show();
    };

}