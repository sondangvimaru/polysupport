<?php

function getvielabel($label){
    
    switch($label){
        case "Email Address":
            return "Địa chỉ email";
        case "Full Name":
            return "Họ và tên";
        case "Phone Number":
            return "Số điện thoại";
        case "Internal":
            return "a";
         
     
    }
}
// Return if no visible fields
global $thisclient;
if (!$form->hasAnyVisibleFields($thisclient))
    return;

$isCreate = (isset($options['mode']) && $options['mode'] == 'create');
?>
    <tr><td colspan="2"><hr />
    <div class="form-header" style="margin-bottom:0.5em">
    
    <!-- <h3><?php echo Format::htmlchars('Chi Tiết Yêu Câu'); ?></h3>
    <div><?php echo Format::display('Mô tả cụ thể yêu cầu của bạn tại đây'); ?></div> -->
    </div>
    </td></tr>
    
    <?php
    // Form fields, each with corresponding errors follows. Fields marked
    // 'private' are not included in the output for clients
    
    foreach ($form->getFields() as $field ) {
      $label= getvielabel( $field->getLocal('label'));
        try {
            if (!$field->isEnabled())
                continue;
        }
        catch (Exception $e) {
            // Not connected to a DynamicFormField
        }

        if ($isCreate) {
            if (!$field->isVisibleToUsers() && !$field->isRequiredForUsers())
                continue;
        } elseif (!$field->isVisibleToUsers()) {
            continue;
        }
        ?>
        <tr>
            <td colspan="2" style="padding-top:10px;">
          
            <?php
            
            if($field->getLocal('label')=="Issue Summary"){
                ?>
                <h4 style="text-align: center;">Thêm thông tin chi tiết</h4>
                <?php
            }
            if (!$field->isBlockLevel()) { ?>
                <label  id="select_label" class="title_survey"for="<?php echo $field->getFormName(); ?>"><span class="<?php
                    if ($field->isRequiredForUsers()) echo 'required'; ?>">
                <?php echo Format::htmlchars(($field->getLocal('label')=="Issue Summary")?"Tiêu Đề":$label); ?>
            <?php if ($field->isRequiredForUsers() &&
                    ($field->isEditableToUsers() || $isCreate)) { ?>
                <span class="error">*</span>
            <?php }
            ?></span><?php
                if ($field->get('hint')) { ?>
                    <br /> <em  style="color:gray;display:inline-block"><?php
                        echo Format::viewableImages($field->getLocal('hint')); ?></em>
                <?php
                } ?>
            <br/>
            <?php
            }
            if ($field->isEditableToUsers() || $isCreate) {
                $field->render(array('client'=>true));
                ?></label> <?php
                foreach ($field->errors() as $e) { ?>
                    <div class="error"><?php echo $e; ?></div>
                <?php }
                $field->renderExtras(array('client'=>true));
            } else {
                $val = '';
                if ($field->value)
                    $val = $field->display($field->value);
                elseif (($a=$field->getAnswer()))
                    $val = $a->display();

                echo sprintf('%s </label>', $val);
            }
            ?>
            </td>
        </tr>
        <?php
    }
?>
 