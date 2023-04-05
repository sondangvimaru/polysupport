<?php
require_once(INCLUDE_DIR . 'class.orm.php');
require_once(INCLUDE_DIR . 'class.topic.php');
class ServiceModel extends VerySimpleModel {
    static $meta = array(
        'table' => SERVICE_TABLE,
        'pk' => array('service_id'),
        'ordering' => array('service_name'),
        'joins' => array(
            'topic' => array(
                'constraint' => array( 'topic_pid' => 'Topic.topic_id'),
            ))
    );

    static function getallservice() {
       
    
        $rows = ServiceModel::objects()        
            ->values_flat('service_name')->all();
          
            
        return $rows ? $rows : array();
    }
    static function getallservicefromtopicID($topic_id) {
       
    
        $row = ServiceModel::objects()
            ->filter(array('topic_id'=>$topic_id))
            ->values_flat('service_name')->all();
          
            
        return $row ? $row : array();
    }
}
?>