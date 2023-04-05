<?php
/*********************************************************************
    open.php

    New tickets handle.

    Peter Rotich <peter@osticket.com>
    Copyright (c)  2006-2013 osTicket
    http://www.osticket.com

    Released under the GNU General Public License WITHOUT ANY WARRANTY.
    See LICENSE.TXT for details.

    vim: expandtab sw=4 ts=4 sts=4:
**********************************************************************/


require('client.inc.php');
define('SOURCE','Web'); //Ticket source.
 
$ticket = null;
$errors=array();
if ($_POST) {
    $vars = $_POST;
   
     
        $arr=array();
        foreach($vars as $key => $val) {
            array_push($arr,$val);
        }
      
        if(strpos($arr[2], "@") !== false){
 if(strpos($arr[2], "@fpt.edu.vn") !== false){
             
        }else{
        $errors['err']=sprintf("vui lòng sử dụng email fpt.edu.vn");
                  
        }
        }
       
   
  
   
    $vars['deptId']=$vars['emailId']=0; //Just Making sure we don't accept crap...only topicId is expected.
    if ($thisclient) {
        $vars['uid']=$thisclient->getId();
    } elseif($cfg->isCaptchaEnabled()) {
        if(!$_POST['captcha'])
            $errors['captcha']=__('Enter text shown on the image');
        elseif(strcmp($_SESSION['captcha'], md5(strtoupper($_POST['captcha']))))
            $errors['captcha']=sprintf('%s - %s', __('Invalid'), __('Please try again!'));
    }
 
    $tform = TicketForm::objects()->one()->getForm($vars);
    $messageField = $tform->getField('message');
    $attachments = $messageField->getWidget()->getAttachments();
    if (!$errors) {
        $vars['message'] = $messageField->getClean();
        if ($messageField->isAttachmentsEnabled())
            $vars['files'] = $attachments->getFiles();
    }

    // Drop the draft.. If there are validation errors, the content
    // submitted will be displayed back to the user
    Draft::deleteForNamespace('ticket.client.'.substr(session_id(), -12));
  
    //Ticket::create...checks for errors..
    $user_id= UserEmailModel::getIdByEmail($arr[2]);
   

    
    if(($ticket=Ticket::create($vars, $errors, SOURCE))){
       
        $msg=__('Support ticket request created');
        // Drop session-backed form data
        unset($_SESSION[':form-data']);
       
        //Logged in...simply view the newly created ticket.
        if ($thisclient && $thisclient->isValid()) {
            // Regenerate session id
          
            $thisclient->regenerateSession();
            
            @header('Location: tickets.php?id='.$ticket->getId());
        } else $ost->getCSRF()->rotate();
           
           
         
        $user_id= UserEmailModel::getIdByEmail($arr[2]);
            $checkAccountResult= UserAccount::lookupById($user_id);
             
            if($user_id>0 && !$checkAccountResult){
                $account = new UserAccount();
                $account->set('user_id',$user_id);
                $account->set('status',1);
                $account->set('timezone','Asia/Jakarta');
                $account->set('passwd', Passwd::hash('Son28121998'));
                $account->set('extra','{"browser_lang":"vi"}');
                date_default_timezone_set("Asia/Ho_Chi_Minh");
                $account->set('registered',date('Y-m-d H:i:s'));
                $account->save(true);
            }
    }else{

        
        $errors['err'] = $errors['err'] ?: sprintf('%s %s',
            __('Unable to create a ticket.'),
            __('Correct any errors below and try again.'));
             
    }
   
}

//page
$nav->setActiveNav('new');
if ($cfg->isClientLoginRequired()) {
    
    if ($cfg->getClientRegistrationMode() == 'disabled') {
        
        Http::redirect('view.php');
    }
    elseif (!$thisclient) {
       
        require_once 'secure.inc.php';
    }
    elseif ($thisclient->isGuest()) {
       
        require_once 'login.php';
        exit();
    }
    
}

require(CLIENTINC_DIR.'header.inc.php');
if ($ticket
    && (
        (($topic = $ticket->getTopic()) && ($page = $topic->getPage()))
        || ($page = $cfg->getThankYouPage())
    )
) {
   
    // Thank the user and promise speedy resolution!
    echo Format::viewableImages(
        $ticket->replaceVars(
            $page->getLocalBody()
        ),
        ['type' => 'P']
    );
}
else {
    
    require(CLIENTINC_DIR.'open.inc.php');
}
require(CLIENTINC_DIR.'footer.inc.php');
?>
