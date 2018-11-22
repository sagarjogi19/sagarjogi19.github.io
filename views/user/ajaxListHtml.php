 <?php 
 if(count($notifications)!=0) {
 foreach($notifications as $notification) {   ?>
    <li> 
         <a  href="javascript:;" title="Discard" class="discardNoti" data-id="<?php echo $notification->id; ?>"><span class="cross trans"></span></a>
         <a href="<?php echo setLink($notification->url_param); ?>" class="notDesc"  >
        <div class="innerCartNav">
          <p><span class="codeTitle"><?php echo $notification->name;  ?></span> </p>
          <p><span class="codeDate"><i class="fa fa-calendar" aria-hidden="true"></i> <?php echo $notification->created_date; ?></span></p>
          <p><?php echo $messageData[$notification->description]; ?></p>
        </div>
         </a>
    </li> 
 <?php } 
 } else {
 ?>
    <li>No Records Found</li>
 <?php } ?>

 