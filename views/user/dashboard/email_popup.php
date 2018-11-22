<div class="popupMain" id="sendEmail">
    <div class="overlayer"></div>
    <div class="popBody">
        <div class="poptitle popTBlue">
            <h2 class="dircTitle ">Send Email</h2>
            <a href="javascript:;" class="closePopup"></a>
        </div>
        <div class="popDetails cusClass">
           <form class="form-horizontal" id="frmSendEmail" name="frmSendEmail" method="post" action="<?php echo setLink('user/send_dashboad_email'); ?>">
                <input type="hidden" name="dahboard-user" id="dahboard-user"  value="">
                <div class="col-md-14 col-sm-14 col-xs-14">
                    <div class="inputBox">
                        <label class="star">Email</label>
                        <input type="text" class="inputFils" id="user_email" name="user_email" value="" title="Email">
                        <small>Please use a comma to separate multiple email addresses</small>
                    </div>
                </div>
                <div class="col-md-14 col-sm-14 col-xs-14">
                    <div class="inputBox">
                        <label class="">CC Email</label>
                        <input type="text" class="inputFils" id="cc_email" name="cc_email" value="" title="CC Email">
                        <small>Please use a comma to separate multiple email addresses</small>
                    </div>
                </div>
                <div class="col-md-14 col-sm-14 col-xs-14">
                    <div class="inputBox">
                        <label class="star">Subject</label>
                        <input type="text" class="inputFils" id="subject" name="subject" value="Dashboard Report From Worthy Parts" title="Subject">
                    </div>
                </div>
                <div class="col-md-14 col-sm-14 col-xs-14">
                    <div class="inputBox">
                        <label class="star">Message</label>
                        <textarea name="description" id="description" title="Description" class="inputFils msgBox" placeholder="Description">Please find attached dashboard report from worthy parts</textarea>
                    </div>
                </div>
                
                <div class="col-md-14 col-sm-14 col-xs-14">
                    <div class="stepsBtn inputBox"><button class="btn skyBlueBtn" type="submit" title="Submit">Submit</button></div>
                </div>
            </form>
        </div>
    </div>
</div>