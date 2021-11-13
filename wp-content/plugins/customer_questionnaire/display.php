<?php

class Funcs_customer_questionnaire
{
    function get_customer_questionnaire_list(){
        global $wpdb;

        $query="SELECT *
            FROM customer_questionnaire
            WHERE del_flg = 0
        ";
        $results = $wpdb->get_results($query);
        return $results;
    }

    /**
     * 名前・年齢・性別を表示する
     *
     * @param string $initial_name
     * @param int $age
     * @param int $sex
     * @return void
     */
    function set_name_age_sex($initial_name, $age, $sex) {

        $age_name = '';
        if(!empty($age)){
            $age_name = '　<span class="cq_sex" >' . $age . '歳</span>';
        }
        $sex_name = '';
        if($sex == 1){
            $sex_name = '　<span class="sex_man" >♂ 男性</span>';
        }else if($sex == 2){
            $sex_name = '　<span class="sex_woman" >♀ 女性</span>';
        }

        return $initial_name . $age_name . $sex_name;
    }

    function getCustomerQuestionnaire($id){
        global $wpdb;

        $query="SELECT *
            FROM customer_questionnaire
            WHERE id = $id
            AND del_flg = 0
        ";
        $results = $wpdb->get_row($query);
        return $results;
    }
}

$FCQ = new Funcs_customer_questionnaire;

if($_GET['ID']){
    $customerQuestionnaire = $FCQ->getCustomerQuestionnaire($_GET['ID']);
    if(empty($customerQuestionnaire)){
        include_once 'list.php';
        exit;
    }
    include_once 'edit_customer_questionnaire.php';
}else{
    include_once 'list.php';
}
?>

