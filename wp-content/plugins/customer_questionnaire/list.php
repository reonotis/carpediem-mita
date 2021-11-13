<?php



$customer_quests = $FCQ->get_customer_questionnaire_list();


?>

<div class="wrap">
    <h1 class="wp-heading-inline">コース一覧</h1>
    <a href="./admin.php?page=register_customer_questionnaire" class="page-title-action">新規追加</a>

    <?php settings_errors(); ?>
    <!-- <table class="widefat fixed striped"> -->
    <table class="widefat">
        <thead>
            <tr>
                <th>short code</th>
                <th>イニシャル</th>
                <th>画像</th>
                <th>HP表示</th>
                <th>編集</th>
                <th>削除</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if($customer_quests){
                foreach($customer_quests as $CQ){
                    ?>
                        <tr>
                            <td>
                                <?php if($CQ->display_flg){ ?>
                                    [show_customer_questionnaire id=<?= $CQ->id ?>]
                                <?php } ?>
                            </td>
                            <td><?= $FCQ->set_name_age_sex($CQ->initial_name,  $CQ->age, $CQ->sex); ?></td>
                            <td><?php if(!empty($CQ->img_pass)) echo "あり" ;?></td>
                            <td><?= ($CQ->display_flg) ? '表示' : '非表示'; ?></td>
                            <td><a href="./admin.php?page=customerQuestionnaire&ID=<?= $CQ->id ?>" >編集</a></td>
                            <td>
                                <form action="../wp-content/plugins/customer_questionnaire/controller.php" name="create_customerQuestionnaire" method="post" >
                                    <input type="hidden" name="ID" value="<?= $CQ->id ?>" >
                                    <input type="submit" name="delete" value="削除" onclick="return confirm_delete();" >
                                </form>
                            </td>
                        </tr>
                    <?php
                }

            }else{
                echo "<tr><td colspan='7'>お客様の声は登録されていません</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>





<script type="text/javascript">
    function confirm_delete(){
        return window.confirm('このデータを削除しますか？');
    }
</script>

