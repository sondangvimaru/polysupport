<?php
require_once(INCLUDE_DIR . 'class.service.php');
if(!defined('OSTCLIENTINC')) die('Access Denied!');
$info=array();
if($thisclient && $thisclient->isValid()) {
   
    $info=array('name'=>$thisclient->getName(),
                'email'=>$thisclient->getEmail(),
                'phone'=>$thisclient->getPhoneNumber());
}

$info=($_POST && $errors)?Format::htmlchars($_POST):$info;
 
 
$form = null;
if (!$info['topicId']) {
    if (array_key_exists('topicId',$_GET) && preg_match('/^\d+$/',$_GET['topicId']) && Topic::lookup($_GET['topicId']))
        $info['topicId'] = intval($_GET['topicId']);
    else
        $info['topicId'] = $cfg->getDefaultTopicId();
}
 
$forms = array();
if ($info['topicId'] && ($topic=Topic::lookup($info['topicId']))) {

   try{
 
//  foreach ($topic->getForms() as $F) {
//         if (!$F->hasAnyVisibleFields())
//             continue;
//         if ($_POST) {
//             $F = $F->instanciate();
//             $F->isValidForClient();
//         }
//         $forms[] = $F->getForm();
//     }
   }catch(Exception ){
   
}
   
  
}

?>
<div id="tilte_div">
<h1><?php echo 'Tạo một yêu cầu hỗ trợ mới';?></h1>
<p><?php echo'Hãy hoàn thành biểu mẫu dưới đây để gửi một yêu cầu trợ giúp mới';?></p>
</div>
<form id="ticketForm" method="post" action="open.php" enctype="multipart/form-data">


  <?php csrf_token(); ?>
  <input type="hidden" name="a" value="open">
  <table  id="new_ticket_table" cellpadding="1" cellspacing="0" border="0">
    <tbody  >
<?php

 
        if (!$thisclient) {
            $uform = UserForm::getUserForm()->getForm($_POST);
            if ($_POST) $uform->isValid();
            $uform->render(array('staff' => false, 'mode' => 'create'));
        }
        else { ?>
            <tr   ><td colspan="2"><hr /></td></tr>
        <tr  ><td ></td><?php echo __('Email'); ?>: <span id="email_create"   > <?php
            echo $thisclient->getEmail(); ?></span>  </td> </tr>
        <tr    ><td><?php echo __('Client'); ?>: <span  id="client_create"> <?php
            echo Format::htmlchars($thisclient->getName()); ?></span></td> </tr>
        <?php } ?>
    </tbody>
    <tbody>
    <tr><td colspan="2"><hr />
        <div class="form-header" style="margin-bottom:0.5em">
        <b><?php echo 'Chọn loại hỗ trợ' ?>    <font class="error">*&nbsp;<?php echo $errors['topicId']; ?></font></b>
        </div>
    </td></tr>
    <tr>
        <td colspan="2">

                <select class="custom-select" style="width: 98%;" id="topicId" name="topicId" onchange="javascript:
                        var data = $(':input[name]', '#dynamic-form').serialize();
                   
                  
                    $.ajax(
                      'ajax.php/form/help-topic/' + this.value,
                      {
                        data: data,
                        dataType: 'json',
                        success: function(json) {
                           
                          $('#dynamic-form').empty().append(json.html);
                            
                          $(document.head).append(json.media);
                         
                          var select=document.getElementsByTagName('select');
                        
                         
                          
                            if(json.list_services.length > 0 && select.length>1){
                                select[1].value='0';
                            for(var i=0; i<json.list_services.length; i++){

                                var option=document.createElement('option');
                                                          
                                
                                 option.text = json.list_services[i];
                                option.value=json.list_services[i];
                                option.setAttribute('class','form-control');
                                select[1].add(option);
                            }
                        
                           
                        }
                      
                        }
                      }
                      
                      ); 
                     
                      ">
                <option value="" selected="selected">&mdash; <?php echo  'Loại Hỗ Trợ';?> &mdash;</option>
                <?php
                if($topics=Topic::getPublicHelpTopics()) {
                    foreach($topics as $id =>$name) {
                        echo sprintf('<option value="%d" %s>%s</option>',
                                $id, ($info['topicId']==$id)?'selected="selected"':'', $name);
                    }
                } ?>
            </select>
         
        </td>
    </tr>
    </tbody>
    <tbody id="dynamic-form">
        <?php

      
        $options = array('mode' => 'create');
        foreach ($forms as $form) {
            
            include(CLIENTINC_DIR . 'templates/dynamic-form.tmpl.php');
        } ?>
    </tbody>
    <tbody>
    <?php
    if($cfg && $cfg->isCaptchaEnabled() && (!$thisclient || !$thisclient->isValid())) {
        if($_POST && $errors && !$errors['captcha'])
            $errors['captcha']=__('Please re-enter the text again');
        ?>
    <tr class="captchaRow">
        <td class="required"><?php echo __('CAPTCHA Text');?>:</td>
        <td>
            <span class="captcha"><img src="captcha.php" border="0" align="left"></span>
            &nbsp;&nbsp;
            <input   id="captcha" type="text" name="captcha" size="6" autocomplete="off">
            <em><?php echo __('Enter the text shown on the image.');?></em>
            <font class="error">*&nbsp;<?php echo $errors['captcha']; ?></font>
        </td>
    </tr>
    <?php
    } ?>
    <tr><td colspan=2>&nbsp;</td></tr>
    </tbody>
  </table>
<hr/>
  <p class="buttons" style="text-align:center;">
        <input class="button info outline" type="submit" value="<?php echo __('Create Ticket');?>">
        <input class="button info outline" type="reset" name="reset" value="<?php echo __('Reset');?>">
        <input class="button info outline" type="button" name="cancel" value="<?php echo __('Cancel'); ?>" onclick="javascript:
            $('.richtext').each(function() {
                try{
                    var redactor = $(this).data('redactor');
                if (redactor && redactor.opts.draftDelete)
                    redactor.plugin.draft.deleteDraft();
                }catch(e){
                }
               
            });
            window.location.href='index.php';">
  </p>
</form>
