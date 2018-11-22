<?php

defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('max_execution_time', 0);
ini_set('post_max_size', '256M');
require('UploadHandler.php');

class Fileuploader {

    public $url;
    public $absPath;
   
    public function __construct() { 
        $this->url = base_url() . 'media/worthyparts/';
        $this->absPath = FCPATH . '/media/worthyparts/';
    }

    public function uploadFile($folder, $user, $record_id) { 
        $ci=setCodeigniterObj();
        if ($ci->input->post('croppedImage')!="") { 
            $filename = basename($ci->input->post('filename'));
            if (strpos($filename, "^") !== false) {
                $imageName = substr($filename, strpos($filename, "#") + 1, strlen($filename));
                $filename = $imageName;
            }
            $name = str_replace(".", date('dmyhis') . ".", $filename);
            $info = pathinfo($name);
            $name = "";
            $name = $info['filename'] . ".png";
            $imgURL = base_url() . $user . '/' . $record_id . '/' . $folder . '/' . $name;
            $imgAbsPath = $this->absPath . $user . '/' . $record_id . '/' . $folder;
            if (file_exists($this->absPath  . $user) == false) {
                mkdir($absPath . $user, 0777, true);
            }
            if (file_exists($imgAbsPath) == false) {
                mkdir($imgAbsPath, 0777, true);
            }
            file_put_contents(
                    $imgAbsPath . '/' . $name, base64_decode(
                            str_replace('data:image/png;base64,', '', $ci->input->post('croppedImage'))
                    )
            );
            echo $imgURL . "," . $name;
            exit;
        }
        $upload_handler = new UploadHandler(array('upload_dir' => $this->absPath.$user.'/'.$record_id.'/'.$folder.'/','upload_url' =>$this->url.$user.'/'.$record_id.'/'.$folder.'/'));
         
    }

}

?> 