window.audience = {};
var getVar = {};
document.location.search.replace(/\??(?:([^=]+)=([^&]*)&?)/g, function () {
    function decode(s) {
            return decodeURIComponent(s.split("+").join(" "));
    }

    //handling for multidimensional arrays
    if(decode(arguments[1]).indexOf("[]") > 0){
        var newName = decode(arguments[1]).substring(0, decode(arguments[1]).length - 2);
        if(typeof getVar[newName] == 'undefined'){
            getVar[newName] = new Array();
        }
        getVar[newName].push(decode(arguments[2]));
    }else{
        getVar[decode(arguments[1])] = decode(arguments[2]);
    }
});

jQuery(document).ready(function(){
    loadDaterangepicker();
    jQuery("#refineGraph").on("click",function(){
        var url=window.location.href;
        jQuery('.small_loading,.loading').show();
        jQuery.ajax({
                url:url,
                data:{'isAjax':true,'date_range':jQuery('#date_range').val(),'dahboard-user':jQuery('#filter_dashboard_user').val()},
		async:true,
		success:function(data){
                    var data = jQuery.parseJSON(data);
                    
                    if(!data.PartsView.counts )
                    {
                         blankGraph('myChart1',[],'Parts View(s)',[0]);
                    }
                    else
                    {
                        printMainChart('myChart1',data.PartsView.labels,'Parts View(s)',data.PartsView.counts);
                    }
//                    if(!data.dirClickAndView.counts)
//                    {
//                         blankGraph('myChart2',[],'Directory Clicks',[0]);
//                         jQuery('#totalClickCount').html('0');
//                    }
//                    else
//                    {
//                        printClickChart('myChart2',data.dirClickAndView.labels,'Directory Clicks',data.dirClickAndView.counts);
//                        jQuery('#totalClickCount').html(data.dirClickAndView.totalClick);
//                    }
                    if(!data.partsClickAndView.totalView && !data.enquiryGraph.totalClick)
                    {
                         blankGraph('myChart2',[],'Parts View(s)',[0]);
                         jQuery('#totalView').html('0');
                         jQuery('#totalClick').html('0');
                    }
                    else
                    {
                        printClickChart('myChart2',data.partsClickAndView,'Parts View(s)/Click(s)');
                        if(data.partsClickAndView.totalView)
                            jQuery('#totalView').html(data.partsClickAndView.totalView);
                        else
                            jQuery('#totalView').html('0');
                        if(data.partsClickAndView.totalClick)
                            jQuery('#totalClick').html(data.partsClickAndView.totalClick);
                        else
                            jQuery('#totalClick').html('0');
                    }
					
                    if(!data.enquiryGraph.totalEnquiry /*&& !data.enquiryGraph.totalCallback && !data.enquiryGraph.totalQuote*/)
                    {
                         blankGraph('myChart3',[],'Directory Enquiry',[0]);
                         jQuery('#totalEnqCount').html('0');
                         /*jQuery('#totalCallback').html('0');
                         jQuery('#totalQuote').html('0');*/
                         jQuery('.export-enq-csv').hide();
                         
                    }
                    else
                    {
                        printEnquiryChart('myChart3',data.enquiryGraph,'Parts Enquiry');
                        if(data.enquiryGraph.totalEnquiry)
                            jQuery('#totalEnqCount').html(data.enquiryGraph.totalEnquiry);
                        else
                            jQuery('#totalEnqCount').html('0');
                        /*if(data.enquiryGraph.totalCallback)
                            jQuery('#totalCallback').html(data.enquiryGraph.totalCallback);
                        else
                            jQuery('#totalCallback').html('0');
                        if(data.enquiryGraph.totalQuote)
                            jQuery('#totalQuote').html(data.enquiryGraph.totalQuote);
                        else
                            jQuery('#totalQuote').html(data.enquiryGraph.totalQuote);*/
                        
                        jQuery('.export-enq-csv').show();
                    }
					  
                    var searchUser = jQuery('#filter_dashboard_user').val();
                    var exportPdfLink = jQuery('#export_pdf').attr('data-href');
                    var exportEnqLink = jQuery('.export-enq-csv').attr('data-href');
                    if(searchUser && searchUser != '')
                    {
                        exportPdfLink = exportPdfLink+'?dahboard-user='+searchUser;
                        exportEnqLink = exportEnqLink+'?uid='+searchUser;
                        jQuery('#export_pdf').prop('href',exportPdfLink);
                        jQuery('.export-enq-csv').prop('href',exportEnqLink);
                        jQuery('.smryTadiv').hide();
                    }
                    else
                    {
                        jQuery('#export_pdf').prop('href',exportPdfLink);
                        jQuery('.export-enq-csv').prop('href',exportEnqLink);
                        jQuery('.smryTadiv').show();
                    }
                    jQuery('.small_loading,.loading').hide();
                }
        });
        jQuery('.graphdate').text(jQuery('#date_range').val());
    });
    
    if(getVar['dahboard-user'] && getVar['dahboard-user'] != 'undefined')
    {
        var userid = getVar['dahboard-user'];
        var businessname = getVar['businessname'];
        jQuery("#filter_dashboard_user").empty().append(jQuery("<option/>").val(userid).text(businessname)).val(userid).trigger("change");
        jQuery("#refineGraph").trigger("click");
    }
    else
    {   
        jQuery("#refineGraph").trigger("click");
    }
    jQuery('#date_range').change(function(){
       jQuery('.graphdate').text(jQuery('#date_range').val()); 
    });
   load_part_select();
   loadTinymce("1","description");
    jQuery('.popclick').off('click');
    jQuery(document).on('click', '.popclick', function(e) {
        var linkAttrib = jQuery(this).attr('data-pop');
        var colorClass = jQuery(this).attr('data-colorclass');
        jQuery('.poptitle').removeClass().addClass(' poptitle '+colorClass);
        
        
        jQuery('#' + linkAttrib).addClass("popVisible");
        jQuery('body').addClass('bodyFixed');
    });
    jQuery(document).on('click', '.closePopup, .overlayer', function(e) {
        jQuery('.popupMain').removeClass("popVisible");
        jQuery('body').removeClass('bodyFixed');
        jQuery('#user_email').val('');
        jQuery('#cc_email').val('');
        jQuery('label.error').hide();
        
    });
    
    if(jQuery("#frmSendEmail").length > 0){
        jQuery.validator.addMethod("multiemail", function (value, element) {
                if (this.optional(element)) {
                return true;
                }

                var emails = value.split(','),
                valid = true;

                for (var i = 0, limit = emails.length; i < limit; i++) {
                value = emails[i];
                valid = valid && jQuery.validator.methods.email.call(this, value, element);
                }

                return valid;
        }, "Invalid email format: please use a comma to separate multiple email addresses.");
        
	 var rulesData = {
                user_email: {required: true,multiemail:true}, 
                cc_email: {multiemail:true}, 
                subject: {required: true},
                description:{required:true},
                
		};
            var messagesData = {
                user_email: {required: 'Please enter email',multiemail:'Please enter valid email'}, 
                cc_email: {required: 'Please enter last name',multiemail:'Please enter valid email'}, 
                subject: {required: 'Please enter subject'},
                description:{required:'Please enter description'},
            };
		 
	 jQuery("#frmSendEmail").validate({
		onkeyup:false,
                ignore:[],
		rules:rulesData,
		messages:messagesData,
		errorClass: "error"
	 });
	 
    }
});

function printMainChart(divId, labelsArrStr, label, dataArrStr) {
    var data = {
        labels: labelsArrStr,
        datasets: [{
            label: label,
            fill: true,
            backgroundColor: 'rgba(200,240,250,0.2)',
            borderColor: 'rgb(60, 163,185)',
            data: dataArrStr,
        }]
    };

    var config = {
        type: 'line',
        data: data,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                duration: 2000,
                onComplete: function(animation) {
                    saveGraphImage(divId);
                },
            },
            title: {
                display: true,
                text: label
            },
            legend: {
                display: false
                //                    position: 'right',
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }],
                xAxes: [{
                    //                            type: 'time',
                    ticks: {
                        autoSkip: true,
                        maxTicksLimit: 15
                    }
                }]
            }
        }
    };
    var canvas = document.getElementById(divId);
    var context = canvas.getContext('2d');
    window.audience.sessionGraph = new Chart(context, config);
}

function saveGraphImage(divId) {
    if (divId == 'myChart3') {
        var photo1 = document.getElementById('myChart1').toDataURL("image/jpg");
        var photo2 = document.getElementById('myChart2').toDataURL("image/jpg");
        var photo3 = document.getElementById('myChart3').toDataURL("image/jpg");
		/*var photo4 = document.getElementById('myChart4').toDataURL("image/jpg");
		var photo5 = document.getElementById('myChart5').toDataURL("image/jpg");*/
        jQuery.ajax({
            method: 'POST',
            url: window.location.href,
            data: {
                myChart1: photo1,
                myChart2: photo2,
                myChart3: photo3,
				/*myChart4: photo4,
				myChart5: photo5,*/
                save_graph_image: 'true',
            }
        });
    }
}
function printSmallChart(divId,labelsArrStr,label,dataArrStr)
{
    var data = {
        labels: labelsArrStr,
        datasets: [
            {
                label: label,
                fill: true,
                backgroundColor: 'rgba(54, 162, 235,0.2)',
                borderColor: 'rgb(54, 162, 235)',
                data: dataArrStr,
            }
        ]
    };
    
    var config = {
            type: 'line',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,				animation: {					duration: 2000,					onComplete: function(animation) {						saveGraphImage(divId);					},				},
                title: {
                    display: false,
                    text: label
                }, legend: {
                    display: false
//                    position: 'right',
                },
                tooltips: {enabled: false},
                scales: {
                    xAxes: [{
                            ticks: {
                                display: false
                            }, showLines: false,
                            gridLines: {
                                display: false
                            }
                        }],
                    yAxes: [{
                            ticks: {
                                display: false, beginAtZero: true
                            }, showLines: false,
                            gridLines: {
//                                 display:false
                            }
                        }]
                }
            }
        };
        var canvas = document.getElementById(divId);
        var context = canvas.getContext('2d');
        window.audience.sessionGraph = new Chart(context, config);
}
function printEnquiryChart(divId,graphArr,label)
{
    var data = {
        labels: graphArr.labels,
        datasets: [{
            label: 'Parts Enquiry',
            fill: false,
            backgroundColor: 'rgb(60, 163,185)',
            borderColor: 'rgb(60, 163,185)',
            data: graphArr.Enqcounts,
        }/*, {
            label: 'Callback Request',
            fill: false,
            backgroundColor: 'rgb(255, 195,7)',
            borderColor: 'rgb(255, 195,7)',
            data: graphArr.Callbackcounts,
        }, {
            label: 'Quotation Request',
            fill: false,
            backgroundColor: 'rgb(230, 115,115)',
            borderColor: 'rgb(230, 115,115)',
            data: graphArr.Quotecounts,
        }*/]
    };
    
    var config = {
            type: 'line',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,				animation: {					duration: 2000,					onComplete: function(animation) {						saveGraphImage(divId);					},				},
                title: {
                    display: false,
                    text: label
                }, legend: {
                    display: true,
                    position: 'bottom',
                },
                tooltips: {enabled: false},
                scales: {
                    xAxes: [{
                            ticks: {
                                display: false
                            }, showLines: false,
                            gridLines: {
                                display: false
                            }
                        }],
                    yAxes: [{
                            ticks: {
                                display: true, beginAtZero: true
                            }, showLines: false,
                            gridLines: {
//                                 display:false
                            }
                        }]
                }
            }
        };
        var canvas = document.getElementById(divId);
        var context = canvas.getContext('2d');
        window.audience.sessionGraph = new Chart(context, config);
}
function printMachineEnquiryChart(divId,graphArr,label)
{
    var data = {
        labels: graphArr.labels,
        datasets: [{
            label: 'Machine Enquiry',
            fill: false,
            backgroundColor: 'rgb(60, 163,185)',
            borderColor: 'rgb(60, 163,185)',
            data: graphArr.Enqcounts,
        } ]
    };
    
    var config = {
            type: 'line',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,				animation: {					duration: 2000,					onComplete: function(animation) {						saveGraphImage(divId);					},				},
                title: {
                    display: false,
                    text: label
                }, legend: {
                    display: false,
                    position: 'bottom',
                },
                tooltips: {enabled: false},
                scales: {
                    xAxes: [{
                            ticks: {
                                display: false
                            }, showLines: false,
                            gridLines: {
                                display: false
                            }
                        }],
                    yAxes: [{
                            ticks: {
                                display: true, beginAtZero: true
                            }, showLines: false,
                            gridLines: {
//                                 display:false
                            }
                        }]
                }
            }
        };
        var canvas = document.getElementById(divId);
        var context = canvas.getContext('2d');
        window.audience.sessionGraph = new Chart(context, config);
}
function printClickChart(divId,graphArr,label)
{
    var data = {
        labels: graphArr.labels,
        datasets: [{
            label: 'Parts View',
            fill: false,
            backgroundColor: 'rgb(60, 163,185)',
            borderColor: 'rgb(60, 163,185)',
            data: graphArr.viewCounts,
        }, {
            label: 'Parts Click',
            fill: false,
            backgroundColor: 'rgb(255, 195,7)',
            borderColor: 'rgb(255, 195,7)',
            data: graphArr.clickCounts,
        }]
    };
    
    var config = {
            type: 'line',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,				animation: {					duration: 2000,					onComplete: function(animation) {						saveGraphImage(divId);					},				},
                title: {
                    display: false,
                    text: label
                }, legend: {
                    display: true,
                    position: 'bottom',
                },
                tooltips: {enabled: false},
                scales: {
                    xAxes: [{
                            ticks: {
                                display: false
                            }, showLines: false,
                            gridLines: {
                                display: false
                            }
                        }],
                    yAxes: [{
                            ticks: {
                                display: true, beginAtZero: true
                            }, showLines: false,
                            gridLines: {
//                                 display:false
                            }
                        }]
                }
            }
        };
        var canvas = document.getElementById(divId);
        var context = canvas.getContext('2d');
        window.audience.sessionGraph = new Chart(context, config);
}

function printMachineClickChart(divId,graphArr,label)
{
    var data = {
        labels: graphArr.labels,
        datasets: [{
            label: 'Machine View',
            fill: false,
            backgroundColor: 'rgb(60, 163,185)',
            borderColor: 'rgb(60, 163,185)',
            data: graphArr.viewCounts,
        }, {
            label: 'Machine Click',
            fill: false,
            backgroundColor: 'rgb(255, 195,7)',
            borderColor: 'rgb(255, 195,7)',
            data: graphArr.clickCounts,
        }]
    };
    
    var config = {
            type: 'line',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,				animation: {					duration: 2000,					onComplete: function(animation) {						saveGraphImage(divId);					},				},
                title: {
                    display: false,
                    text: label
                }, legend: {
                    display: true,
                    position: 'bottom',
                },
                tooltips: {enabled: false},
                scales: {
                    xAxes: [{
                            ticks: {
                                display: false
                            }, showLines: false,
                            gridLines: {
                                display: false
                            }
                        }],
                    yAxes: [{
                            ticks: {
                                display: true, beginAtZero: true
                            }, showLines: false,
                            gridLines: {
//                                 display:false
                            }
                        }]
                }
            }
        };
        var canvas = document.getElementById(divId);
        var context = canvas.getContext('2d');
        window.audience.sessionGraph = new Chart(context, config);
}

function blankGraph(divId,labelsArrStr,label,dataArrStr)
{
    var ctx = document.getElementById(divId);
    var aa = true;
    if(divId == 'myChart1')
    {
        aa = false;
    }
   

    var data = {
        labels: labelsArrStr,
        datasets: [
            {
                label: label,
                fill: false,
                lineTension: 0,
                backgroundColor: "rgba(255,255,255,1)",
                borderColor: "rgba(0, 176, 236,1)",
                borderWidth: 2,
                borderCapStyle: 'butt',
                borderDash: [],
                borderDashOffset: 0.0,
                borderJoinStyle: 'miter',
                pointBorderColor: "rgba(0, 176, 236,1)",
                pointBackgroundColor: "rgba(255,255,255,0)",
                pointBorderWidth: 10,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba(0, 176, 236,1)",
                pointHoverBorderColor: "rgba(220,220,220,1)",
                pointHoverBorderWidth: 2,
                pointRadius: 1,
                pointHitRadius: 1,
                data: dataArrStr,
                spanGaps: false
                
            }
        ]
    };
    
    var myLineChart = new Chart(ctx, {
        type: 'line',
        data: data,
         options: {			animation: {					duration: 2000,					onComplete: function(animation) {						saveGraphImage(divId);					},				},
             title: {
                    display: false,
                    text: label
                }, legend: {
                    display: false
//                    position: 'right',
                },
            scales: {
                yAxes: [{
                    ticks: {
                        stepSize: 1,
                        beginAtZero:true
                    }
                  
                }]
             
//             xAxes: [{
//                type: 'time',
//                time: {
//                  displayFormats: {
//                    'millisecond': 'DD MMM',
//                    'second': 'DD MMM',
//                    'minute': 'DD MMM',
//                    'hour': 'DD MMM',
//                    'day': 'DD MMM',
//                    'week': 'DD MMM',
//                    'month': 'DD MMM',
//                    'quarter': 'DD MMM',
//                    'year': 'DD MMM',
//                  }
//                }
//              }],
            },
            maintainAspectRatio: aa,
        }
    });
    
}


function loadDaterangepicker() {
        jQuery('.ui-datepicker-trigger').click(function() {
            jQuery(this).parent().find('input').click();
        });
        var options = {};
            options.showDropdowns = true;
//            options.showWeekNumbers = true;
//            options.showISOWeekNumbers = true;


//            options.timePicker = true;


//            options.timePicker24Hour = true;


//            options.timePickerIncrement = parseInt(jQuery('#timePickerIncrement').val(), 10);

//            options.timePickerSeconds = true;

            options.autoApply = true;


//            options.dateLimit = {days: 7};


        options.ranges = {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            'Last 6 Month': [moment().subtract(6, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        };



//        jQuery('#rtl-wrap').show();
        options.locale = {
            direction: 'ltr',
            format: 'DD-MM-YYYY',
            separator: ' To ',
            applyLabel: 'Apply',
            cancelLabel: 'Cancel',
//            fromLabel: 'From',
//            toLabel: 'To',
            customRangeLabel: 'Custom',
            daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
            monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            firstDay: 1
        };


        options.linkedCalendars = false;

        options.autoUpdateInput = true;

        options.showCustomRangeLabel = true;

        options.alwaysShowCalendars = true;

//        options.parentEl = ".mobRight";
//console.log(moment().subtract(29, 'days'))
        options.startDate = moment().subtract(29, 'days');
        options.endDate = moment();
//        options.minDate = jQuery('#minDate').val();
        options.maxDate = moment();

        options.opens = "left";

        options.drops = "down";

        options.buttonClasses = "btn btn-sm";


//        options.applyClass = 'btn-success';


//        options.cancelClass = 'btn-default';

        jQuery('#date_range').daterangepicker(options, function(start, end, label) {
//            console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
             
        });

    }
    
function load_part_select() {

    var selectors = jQuery("#filter_dashboard_user");
    var get_url = window.location.href;
    selectors.select2({
        minimumInputLength: 1,
        width: "100%",
        allowClear: true,
        placeholder: "Search Username Or Business Name",
        openOnEnter: false,
        ajax: {
            url: get_url,
            dataType: 'json',

            data: function (params) {
              return {
                user_name: params.term, // search term
                action :"searchUserForDashboard",
                fromInsTbl : 'true',
              };
            },
            processResults: function (data, params) {

              params.page = params.page || 1;

              return {
                results: data.items,
              };
            },
            cache: false
          },
    });

      selectors.on("select2:select", function(e) {  
          jQuery("#refineGraph").trigger("click");
          jQuery('#dahboard-user').val(jQuery("#filter_dashboard_user").val());
      });
      selectors.on("select2:unselecting", function(e) {  
          selectors.val('');
          jQuery("#refineGraph").trigger("click");
          jQuery('#dahboard-user').val('');
          var stateObj = { foo: "dashboard" };
          history.pushState(stateObj, "page 2", "dashboard");
      });
}