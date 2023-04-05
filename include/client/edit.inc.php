<?php

if(!defined('OSTCLIENTINC') || !$thisclient || !$ticket || !$ticket->checkUserAccess($thisclient)) die('Access Denied!');

?>

<h1>
    <?php echo sprintf(__('Chỉnh sửa yêu cầu  #%s'), $ticket->getNumber()); ?>
</h1>

<form action="tickets.php" method="post">
    <?php echo csrf_token(); ?>
    <input type="hidden" name="a" value="edit"/>
    <input type="hidden" name="id" value="<?php echo Format::htmlchars($_REQUEST['id']); ?>"/>
<table width="98%">
    <tbody id="dynamic-form">
    <select class="custom-select" style="width: 98%;" id="topicId" name="topicId" onchange="javascript:
                        var data = $(':input[name]', '#dynamic-form').serialize();
                   
                  
                    $.ajax(
                      'ajax.php/form/help-topic/' + this.value,
                      {
                        data: data,
                        dataType: 'json',
                        success: function(json) {
                           
                        
                          var dom = document.createElement('div');
                          dom.innerHTML = json.html;
                     var text=   dom.getElementsByTagName('textarea');
                     var drop= dom.getElementsByClassName('filedrop');
                      dom.removeChild(text[0]);
                      dom.removeChild(drop[0]);
                     $('#dynamic-form').empty().append(dom);
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

    </tbody>
</table>
<hr>
<p style="text-align: center;">
    <input type="submit" value="<?php echo __('Update') ?>"/>
    <input type="reset" value="<?php echo __('Reset') ?>"/>
    <input type="button" value="<?php echo __('Cancel') ?>" onclick="javascript:
        window.location.href='index.php';"/>
</p>
</form>
 