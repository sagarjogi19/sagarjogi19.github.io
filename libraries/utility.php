<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Utility {

    /**
     * Encrypts password
     * 
     * @param string $pass
     * @return string
     * 
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    public static function encryptPass($pass) {
        $cryptKey = 'qJB0rGtIn5UB1xG03efyCp';
        $qEncoded = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($cryptKey), $pass, MCRYPT_MODE_CBC, md5(md5($cryptKey))));
        return( $qEncoded );
    }

    /**
     * Decrypts password
     * 
     * @param string $pass
     * @return string
     * 
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    public static function decryptPass($pass) {
        $cryptKey = 'qJB0rGtIn5UB1xG03efyCp';
        $qDecoded = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($cryptKey), base64_decode($pass), MCRYPT_MODE_CBC, md5(md5($cryptKey))), "\0");
        return( $qDecoded );
    }

    /**
     * Encrypt code for cookie value
     *  return string $value 
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    public static function encryptCookie($value) {
        return base64_encode(serialize(json_encode($value)));
    }

    /**
     * Decrypt code for cookie value
     *   return array
     * @author Kushan Antani<kushan.datatechmedia@gmail.com>
     */
    public static function decryptCookie($value) {
        return json_decode(unserialize(base64_decode($value)), true);
    }

    /**
     * Common mail function for entire site
     * @param type $to pass mail to
     * @param type $from_name pass from name
     * @param type $from_email pass from email
     * @param type $subject pass subject
     * @param type $content pass content
     * @param type $cc pass cc emails as array
     * @param type $bcc pass bcc emails as array
     * @param type $emailtype pass true for Text format email
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    public static function sendMail($to, $from_name, $from_email, $subject, $content, $attachment=NULL, $cc = array(), $bcc = array(), $emailType = false) {
        //Set parameters for mail
        $CI = setCodeigniterObj();
        $config['mailtype'] = 'html';
        if ($emailType == true) {
            $config['mailtype'] = 'text';
        }
         $CI->load->library('email');
         $CI->email->initialize($config);
         $CI->email->from($from_email, $from_name);
         $CI->email->to($to);
        if (count($cc) > 0) {
             $CI->email->cc($cc);
        }
        if (count($cc) > 0) {
             $CI->email->bcc($bcc);
        }
         $CI->email->subject($attachment);
         $CI->email->subject($subject);
         $CI->email->message($content);
         $status=$CI->email->send();
         return $status;
    }

    /**
     * Load Email templates load html template
     * @param type $subject pass subject
     * @param type $content pass email content
     * @param type $template pass custom template if need
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    public static function loadTemplate($subject, $content, $template = "default.php") {
        $PATH = base_url();
        $CI = setCodeigniterObj();
        $SITE_LOGO = "<img src='" . getLogo() . "' style='margin-bottom:10px;' border='0' width='109' height='80' alt='" . $CI->config->item('site_name') . "' title='" . $CI->config->item('site_name') . "'/>";
        $HEADER = $subject;
        $contactData = "<tbody>";
        if (is_array($content)) {
            foreach ($content as $key => $value) {
                if (!empty($value)) {
                    $contactData .= "<tr>
			                   <td style='color:#000;font-family:Arial, Helvetica, sans-serif;padding:10px;border-right:1px solid #ccc;border-bottom:1px solid #ccc;width:34%;'><strong>" . $key . " :</strong></td>
               				    <td style='font-family:Arial, Helvetica, sans-serif;padding:10px;border-bottom:1px solid #ccc;width:66%'>" . stripslashes($value) . "</td>
			                  </tr>";
                } else {
                    $contactData .= "<tr>
				                   <td><b>" . $key . " :</b></td>
                                                       </tr>";
                }
            }
        } else {
            $contactData = '<tr><td style="padding:10px;border-bottom:1px solid #ccc">' . $content . '</td></tr>';
        }
        $contactData .= '</tbody>';

        $BODY_CONTENT = $contactData;
        $FOOTER = '<td align="left" style="text-align:left; font-size: 12px;"><strong>Address:</strong> ' . $CI->config->item('site_address') . '<br />
                  <strong>Phone:</strong> ' . $CI->config->item('site_phone') . '</td>
                <td align="right" style="text-align:left; width: 250px; font-size: 12px;"><strong>Email:</strong> <a href="mailto:' . $CI->config->item('site_email') . '" style="color: #0068AD;">' . $CI->config->item('site_email') . '</a><br />
                  <strong>Website:</strong> <a href="' . base_url() . '" target="_blank"  style="color: #0068AD;">' . base_url() . '</a></td>';
        $content = file_get_contents(FCPATH . "/email_template/" . $template);
        $content = addslashes($content);
        eval("\$content = \"$content\";");
        return stripslashes($content);
    }
     public static function loadCustomerMailTempleate($subject, $arrContactData) {
//Set Mail Header

        $arrTemplateHeader['livePath'] = base_url();
        $arrTemplateHeader['logoImagePath'] = getTemplateLivePath() . "/images/logo.png";
        $arrTemplateHeader['logoImageWidth'] = "";
        $arrTemplateHeader['logoImageHeight'] = "";
        $arrTemplateHeader['headerText'] = $subject;
       
//Set Footer 
//        $arrTemplateFooter['footerText'].='<td align="center" style="text-align:left; font-size: 12px;font-family:Arial, Helvetica, sans-serif; text-align:center;"><strong>Thank You</strong></td>';
        $content = Utility::mailCustomerTemplate($arrTemplateHeader, $arrContactData, $arrTemplateFooter, FCPATH . "/email_template/contact_us_customer.php");
        return $content;
      
    }

    /* Do not allow non logged user to access machine class   
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */

    public static function checkLogin() {
      
        if (isUserLoggedIn() == false) { 
                redirect('user/login');
        }  
    }
    /* Do not allow access restrict access of controller  
     * Function is dual purpose. If need to redirect then pass nothing in $returnVal. Need to do display show hide pass 1 in $returnVal
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    public static function hasAccess($currentAction="",$returnVal=0){
         $role_id = getUserInfo('role_id');
            $CI = setCodeigniterObj();
            $freeUserDisAllow = array("category_list","category_add","make_list","make_add","user_list","user_add");
            if($currentAction==""){
                $last = $CI->uri->total_segments();
                $currentAction=$CI->uri->segment($last); 
            }
            
            if($role_id==2 && in_array($currentAction,$freeUserDisAllow)==true){
                 if($returnVal==1){
                     return false;
                 }
                 else {
                    redirect('user/dashboard');
                 }
            } 
       return true;     
    }

    /**
     * Returns image url.
     * @author Kushan Antani <kushan.datatechmedia@gmail.com> 
     */
    public static function getResizeURL($imageName, $size, $userId, $recordId, $imageFolder) {
        return base_url() . 'image-catalog/' . $imageName . '/' . $size . '/' . $userId . '/' . $recordId . '/' . $imageFolder;
    }

    /**
     * Create Slug String
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    public static function getSlug($value, $index = "", $table, $aliasCol = "alias", $indexCol = "id") {

        $slug = Utility::getCleanSlugString($value);
        $slug = Utility::checkUniqueSlug($slug, $index, $table, $aliasCol, $indexCol);

        return $slug;
    }

    public static function checkUniqueSlug($slug, $id = 0, $table, $aliasCol, $indexCol) {
        $CI = setCodeigniterObj();
        $index = 1;
        if ($id == 0)
            $index = 1;
        $CI->db->select('id');
        $CI->db->like($aliasCol, $slug);
        if ($id != 0)
            $CI->db->where($indexCol . "!=", $id);

        $CI->db->from($table);

        $cnt = $CI->db->count_all_results();
        if (($cnt) > 0)
            $slug = $slug . '-' . $cnt;

        return $slug;
    }

    public static function getCleanSlugString($string) {
        if ($string) {
            $string = preg_replace("`\[.*\]`U", "", $string);
            $string = preg_replace('`&(amp;)?#?[a-z0-9]+;`i', '-', $string);
            $string = htmlentities($string, ENT_COMPAT, 'utf-8');
            $string = preg_replace("`&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);`i", "\\1", $string);
            $string = preg_replace(array("`[^a-z0-9]`i", "`[-]+`"), "-", $string);
        }
        return strtolower(trim($string, '-'));
    }

    public static function getMaxId($table, $col = "id") {
        $CI = setCodeigniterObj();
        $CI->db->select_max($col);
        $CI->db->from($table);
        $dataId = $CI->db->get();
        $max = $dataId->row_array();
        return (int) $max[$col] + 1;
    }

    /**
     * Get and set search session
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    public static function setSearchSession($moduleName) {
        $CI = setCodeigniterObj();
        //Set session if data is posted
        if (count($CI->input->post()) != 0) {
            $CI->session->set_userdata($moduleName, json_encode($CI->input->post()));
        } else if ($CI->input->get('reset') != "") {
            $CI->session->unset_userdata($moduleName);
        }
        //Get session data
        return $CI->session->userdata($moduleName);
    }

    /**
     * Get List Total Count
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    public static function getPageCount($dbCount, $totalCount) {
        return ceil($dbCount / $totalCount);
    }

    /**
     * Set Paypal Details
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
   public static function setPaypalDetails() {
        $CI = setCodeigniterObj();
        $PayPalApiUsername = $CI->config->item('PayPalApiUsername');
        $PayPalApiPassword = $CI->config->item('PayPalApiPassword');
        $PayPalApiSignature = $CI->config->item('PayPalApiSignature');
        $PayPalMode = $CI->config->item('PayPalMode');

        return array('PayPalApiUsername' => $PayPalApiUsername, 'PayPalApiPassword' => $PayPalApiPassword, "PayPalApiSignature" => $PayPalApiSignature, 'PayPalMode' => $PayPalMode);
    }
  
  /**
   * Set Parts Price
   * @author Kushan Antani <kushan.datatechmedia@gmail.com>
   */  
  public static function getPartsPrice(){
       $CI = setCodeigniterObj();
      $eachPrice=$CI->config->item('parts_price');
      $getGST = ($eachPrice * 10)/100;
      $getSubtotal=$eachPrice-$getGST;
      $setPriceArray=array("total"=>$eachPrice,"subtotal"=>$getSubtotal,"gst"=>$getGST);
      return $setPriceArray;
  }
  
  /**
   * Check Captcha
   * @author Kushan Antani <kushan.datatechmedia@gmail.com>
   */
  public static function checkCaptcha($sessionVal,$num){  
        $CI = setCodeigniterObj();
        $num = Utility::decryptPass($num);
        $sessionData=$CI->session->userdata($sessionVal);
 
        if ($sessionData == $num) {
            return TRUE;
        } else {
            return FALSE;
        } 
   }
   public static function displayPrice($priceType, $price, $price_to, $isGST = "", $page = "") {
      $currency = "$";
      $showPrice = "";
      $html = "";
      $price = str_replace(".00", "", number_format($price, 2));
      $price_to = str_replace(".00", "", number_format($price_to, 2));
      if ($priceType == "n") {
         $showPrice = "Price Negotiable";
      } else if ($priceType == "c") {
         $showPrice = "P.O.A";
      } else if ($priceType == "r") {
         $showPrice = "<span class='price_small_text'>Starts from</span> " . "<sup>" . $currency . "</sup>" . $price;
         $showPrice .= " - " . "<sup>" . $currency . "</sup>" . $price_to;
      } else {
         $showPrice = "<sup>" . $currency . "</sup>" . $price;
      }
      $html = "<span>";
      // if ($priceType == 'f' || $priceType=='r') { $html.="<sup>".$currency."</sup>"; } 
      $html .= $showPrice;
      $html .= '</span>';
      if ($priceType == 'f' && $isGST == 1) {
         $html .= "<small class='span_title price_small_text'>Including GST</small>";
      } else if ($priceType == 'f' && $isGST == 0) {
         $html .= "<br /><small class='span_title price_small_text'>Excluding GST</small>";
      }

      return $html;
   }

   public static function calculateDays($date) {
      $timeAgo = strtotime($date);
      $curTime = time();
      $timeElapsed = $curTime - $timeAgo;
      $seconds = $timeElapsed;
      $minutes = round($timeElapsed / 60);
      $hours = round($timeElapsed / 3600);
      $days = round($timeElapsed / 86400);
      $weeks = round($timeElapsed / 604800);
      $months = round($timeElapsed / 2600640);
      $years = round($timeElapsed / 31207680);
      // Seconds
      if ($seconds <= 60) {
         return "Just now";
      }
      //Minutes
      else if ($minutes <= 60) {
         if ($minutes == 1) {
	 return "One minute ago";
         } else {
	 return "$minutes minutes ago";
         }
      }
      //Hours
      else if ($hours <= 24) {
         if ($hours == 1) {
	 return "An hour ago";
         } else {
	 return "$hours hrs ago";
         }
      }
      //Days
      else if ($days <= 7) {
         if ($days == 1) {
	 return "yesterday";
         } else {
	 return "$days days ago";
         }
      }
      //Weeks
      else if ($weeks <= 4.3) {
         if ($weeks == 1) {
	 return "A week ago";
         } else {
	 return "$weeks weeks ago";
         }
      }
      //Months
      else if ($months <= 12) {
         if ($months == 1) {
	 return "A month ago";
         } else {
	 return "$months months ago";
         }
      }
      //Years
      else {
         if ($years == 1) {
	 return "one year ago";
         } else {
	 return "$years years ago";
         }
      }
   }
    public static function formatMachineAddress($address = "", $suburb = "", $state = "", $postcode = "") {
      if (trim($address) != "") {
         $address = '<span>' . $address . '</span>';
      }
      return Utility::formatAddress('<span>' . $address . '</span>', '<span>' . $suburb . '</span>', '<span>' . $state . '</span>', '<span>' . $postcode . '</span>');
   }

   public static function formatAddress($address = "", $suburb = "", $state = "", $postcode = "", $addSpanTag = false) {

      $finalAddress = "";
      if (trim($address) != "") {
         $finalAddress .= $address . " ";
      }
      if (trim($suburb) != "") {
         $finalAddress .= $suburb . " ";
      }
      if (trim($state) != "") {
         $state = Utility::shortFormatState($state);
         $finalAddress .= $state . " ";
      }
      if (trim($postcode) != "") {
         $finalAddress .= $postcode . " ";
      }

      if ($state != '' && $postcode != '' && $addSpanTag == false) {
         //$formatAdd =  implode(',&nbsp;&nbsp;',array_filter(array($address,$suburb,$state)));
         // if($postcode != '')
         //   $formatAdd .= '&nbsp;&nbsp;'  .$postcode;
         $formatAdd = trim($finalAddress);

         return $formatAdd;
      } else {
         //  $formatAdd =  implode(',&nbsp;&nbsp;</span><span>',array_filter(array($address,$suburb,$state)));
         //  if($postcode != '')
         //$formatAdd .= '&nbsp;&nbsp;'  .$postcode;
         $formatAdd = trim($finalAddress);
         return "<span>" . $formatAdd . "</span>";
      }
   }

   public static function shortFormatState($state = "") {
    
      $stateArr = array(
          'New South Wales' => 'NSW',
          'Victoria' => 'VIC',
          'Western Australia' => 'WA',
          'Queensland' => 'QLD',
          'South Australia' => 'SA',
          'Tasmania' => 'TAS',
          'Northern Territory' => 'NT',
          'Australian Capital Territory' => 'ACT'
      );
//      print_r($stateArr);exit;
      
      if ($state != "") {
         return $stateArr[strip_tags($state)];
      } else {
         return $stateArr;
      }
   }
   public static function mailCustomerTemplate($arrTemplateHeader, $arrContactData, $arrTemplateFooter, $templateFile) {

        $content = "";
   
        $PATH = $arrTemplateHeader['livePath'];
        if (!empty($arrTemplateHeader['logoImagePath'])) {
             $SITE_LOGO = "<img  src='" . $arrTemplateHeader['logoImagePath'] . "' alt='Worthy Parts' style='display:block;color:#000;text-decoration:none;font-family:Helvetica,arial,sans-serif;font-size:16px;width: 109px;height:80px;' border='0'>";
             $SITE_LOGO1 = "<img alt='Worthy Parts'  src='" . $arrTemplateHeader['logoImagePath'] . "' style='color:rgb(0,0,0);text-decoration:none;font-family:Helvetica,arial,sans-serif;font-size:16px;padding:7px 15px 15px;' width='109' height='80' border='0'>";
             $HEADER_HIDE = '';
        } else {
            $SITE_LOGO = "";
            $HEADER_HIDE = "none";
        }
        $HEADER = $arrTemplateHeader['headerText'];
        $YEAR=date('Y');
        $contactData = "<tbody><tr>";
        /*foreach ($arrContactData as $key => $value) {
            if (!empty($value)) {
                $contactData .= "<tr>
			                   <td style='color:#000;font-family:Arial, Helvetica, sans-serif;padding:10px;border-right:1px solid #ccc;border-bottom:1px solid #ccc;width:34%;'><strong>" . ucwords($key) . " :</strong></td>
               				    <td style='font-family:Arial, Helvetica, sans-serif;padding:10px;border-bottom:1px solid #ccc;width:66%'>" . stripslashes($value) . "</td>
			                  </tr>";
            } else {
                $contactData .= "<tr>
				                   <td><b>" . ucwords($key) . " :</b></td>
                                                       </tr>";
            }
        }*/
        if(isset($arrContactData['Name']) && !empty($arrContactData['Name'])){
             $contactData .= ' <td style="padding:5px 5px 5px 5px" bgcolor="">
                                                                        <div>
                                                                            <span style="font-family:Arial,Helvetica,sans-serif"> 
                                                                                <span style="font-size:14px;font-weight: bold; font-family:Arial,Helvetica,sans-serif">Contact Person:</span>
                                                                                <span style="font-size:14px; font-family:Arial,Helvetica,sans-serif">'.$arrContactData['Name'].'</span>
                                                                            </span>
                                                                        </div> 
                                                                     </td>';
        }
         if(isset($arrContactData['Phone']) && !empty($arrContactData['Phone'])){
             $contactData .= ' <td style="padding:5px 5px 5px 5px" bgcolor="">
                                                                        <div>
                                                                            <span style="font-family:Arial,Helvetica,sans-serif"> 
                                                                                <span style="font-size:14px;font-weight: bold; font-family:Arial,Helvetica,sans-serif">Phone:</span>
                                                                                <span style="font-size:14px; font-family:Arial,Helvetica,sans-serif">'.$arrContactData['Phone'].'</span>
                                                                            </span>
                                                                        </div> 
                                                                     </td></tr>';
        } else {
              $contactData .= ' </tr>';
        }
        if(isset($arrContactData['Email']) && !empty($arrContactData['Email'])){
             $contactData .= ' <tr><td style="padding:5px 5px 5px 5px" bgcolor="">
                                                                        <div>
                                                                            <span style="font-family:Arial,Helvetica,sans-serif"> 
                                                                                <span style="font-size:14px;font-weight: bold; font-family:Arial,Helvetica,sans-serif">Email:</span>
                                                                                <span style="font-size:14px; font-family:Arial,Helvetica,sans-serif">'.$arrContactData['Email'].'</span>
                                                                            </span>
                                                                        </div> 
                                                                     </td>';
        }
         if(isset($arrContactData['Suburb']) && !empty($arrContactData['Suburb'])){
             $contactData .= ' <td style="padding:5px 5px 5px 5px" bgcolor="">
                                                                        <div>
                                                                            <span style="font-family:Arial,Helvetica,sans-serif"> 
                                                                                <span style="font-size:14px;font-weight: bold; font-family:Arial,Helvetica,sans-serif">Suburb:</span>
                                                                                <span style="font-size:14px; font-family:Arial,Helvetica,sans-serif">'.$arrContactData['Suburb'].'</span>
                                                                            </span>
                                                                        </div> 
                                                                     </td></tr>';
        }
         if(isset($arrContactData['Message']) && !empty($arrContactData['Message'])){
             $contactData .= ' <tr>
                                                                      <td colspan="2" style="padding:5px 5px 5px 5px" bgcolor="">
                                                                        <div>
                                                                            <span style="font-family:Arial,Helvetica,sans-serif"> 
                                                                                <span style="font-size:14px;font-weight: bold; font-family:Arial,Helvetica,sans-serif;width: 55px;display: inline-block;vertical-align: top;">Enquiry:</span>
                                                                                <span style="width: calc(100% - 60px);display: inline-block;vertical-align: top; font-size:14px; font-family:Arial,Helvetica,sans-serif">'.$arrContactData['Message'].'</span>
                                                                            </span>
                                                                        </div> 
                                                                     </td> ';
        }
        $contactData .= '</tr></tbody>';

        $BODY_CONTENT = $contactData;
        $MACHINE_NAME = '<a href="'.$arrContactData['Part URL'].'" style="margin-bottom: 5px;display: inline-block;color:#0068ad"><b>'.$arrContactData['Part Name'].'</b></a>';
        if(isset($arrContactData['Part Code']) && !empty($arrContactData['Part Code'])){
        $STOCKID = '<table  style="table-layout:fixed" width="100%" cellspacing="0" cellpadding="0" border="0">
                                                                           <tbody>
                                                                              <tr>
                                                                                 <td style="padding:0px 0px 0px 0px" valign="top" height="100%" bgcolor="">
                                                                                    <table  style="table-layout:fixed" width="100%" cellspacing="0" cellpadding="0" border="0">
                                                                                       <tbody>
                                                                                          <tr>
                                                                                             <td style="padding:0px 0px 0px 0px" bgcolor="#ffffff">
                                                                                                 <div>
                                                                                                     <span style="font-family:Arial,Helvetica,sans-serif;display: inline-block;vertical-align: top;width: 80px;font-size: 14px;color:#000000;font-weight: bold;">Part Code:</span> 
                                                                                                     <span style="font-family:Arial,Helvetica,sans-serif;display: inline-block; vertical-align:top;width: calc(100% - 86px); font-size: 14px;line-height: 20px; color:#000000;">'.$arrContactData['Part Code'].'</span>
                                                                                                 </div>
                                                                                             </td>
                                                                                          </tr>
                                                                                       </tbody>
                                                                                    </table>
                                                                                 </td>
                                                                              </tr>
                                                                           </tbody>
                                                                        </table>';
        }
          if(isset($arrContactData['Conditions']) && !empty($arrContactData['Conditions'])){
        $CONDITION = '<table  style="table-layout:fixed" width="100%" cellspacing="0" cellpadding="0" border="0">
                                                                           <tbody>
                                                                              <tr>
                                                                                 <td style="padding:0px 0px 0px 0px" valign="top" height="100%" bgcolor="">
                                                                                    <table  style="table-layout:fixed" width="100%" cellspacing="0" cellpadding="0" border="0">
                                                                                       <tbody>
                                                                                          <tr>
                                                                                             <td style="padding:0px 0px 0px 0px" bgcolor="#ffffff">
                                                                                                <div>
                                                                                                    <span style="font-family:Arial,Helvetica,sans-serif;display: inline-block;vertical-align: top;width: 80px;font-size: 14px;color:#000000;font-weight: bold;">Condition:</span> 
                                                                                                    <span style="font-family:Arial,Helvetica,sans-serif;display: inline-block; vertical-align:top;width: calc(100% - 86px); font-size: 14px;line-height: 20px; color:#000000;">'.$arrContactData['Conditions'].'</span>
                                                                                                </div>
                                                                                             </td>
                                                                                          </tr>
                                                                                       </tbody>
                                                                                    </table>
                                                                                 </td>
                                                                              </tr>
                                                                           </tbody>
                                                                        </table>
';
        }
         if(isset($arrContactData['Seller']) && !empty($arrContactData['Seller'])){
        $SELLER = ' <table  style="table-layout:fixed" width="100%" cellspacing="0" cellpadding="0" border="0">
                                                                           <tbody>
                                                                              <tr>
                                                                                 <td style="padding:0px 0px 0px 0px" valign="top" height="100%" bgcolor="">
                                                                                    <table  style="table-layout:fixed" width="100%" cellspacing="0" cellpadding="0" border="0">
                                                                                       <tbody>
                                                                                          <tr>
                                                                                             <td style="padding:0px 0px 0px 0px" bgcolor="#ffffff">
                                                                                                 <div>
                                                                                                     <span style="font-family:Arial,Helvetica,sans-serif;display: inline-block;vertical-align: top;width: 80px;font-size: 14px;color:#000000;font-weight: bold;">Seller:</span> 
                                                                                                     <span style="font-family:Arial,Helvetica,sans-serif;display: inline-block; vertical-align:top;width: calc(100% - 86px); font-size: 14px;line-height: 20px; color:#000000;">'.$arrContactData['Seller'].'</span>
                                                                                                 </div>
                                                                                             </td>
                                                                                          </tr>
                                                                                       </tbody>
                                                                                    </table>
                                                                                 </td>
                                                                              </tr>
                                                                           </tbody>
                                                                        </table>';
        }
          if(isset($arrContactData['Price']) && !empty($arrContactData['Price'])){
              $PRICE=$arrContactData['Price'];
          }
          
        
        $FOOTER = $arrTemplateFooter['footerText'];
        $content = file_get_contents($templateFile);
        $content = addslashes($content);
        eval("\$content = \"$content\";");
        //echo $content;exit;
        return stripslashes($content);
    }
}

?> 