<?php
?>


<div class="wrap">

    <!-- 一覧画面 -->
    <h1 class="wp-heading-inline">お客様の声登録</h1>

    <?php settings_errors(); ?>
    <form name="create_customerQuestionnaire" action="../wp-content/plugins/customer_questionnaire/controller.php" method="post" >
        <?php settings_fields( 'customerQuestionnaire_settings' ); ?>
        <?php do_settings_sections( 'customerQuestionnaire_settings' ); ?>

        <table class="form-table" role="presentation" >
            <tbody>
                <tr class="form-field form-required">
                    <th scope="row"><label for="initial_name">イニシャル<span class="description" >(必須)</span></label></th>
                    <td><input name="initial_name" type="text" value="<?= $customerQuestionnaire->initial_name ?>" id="initial_name" style="width:25em;" ></td>
                </tr>
                <tr class="form-field form-required">
                    <th scope="row"><label for="age">年齢</label></th>
                    <td><input name="age" type="number" value="<?= $customerQuestionnaire->age ?>" id="age" style="width:10em;" min="3" >歳</td>
                </tr>
                <tr class="form-field form-required">
                    <th scope="row"><label for="sex">性別</label></th>
                    <td>
                        <label><input type="radio" name="sex" value="1" <?php if( $customerQuestionnaire->sex == 1 )echo " checked='checked'"; ?> >男性</label>
                        <label><input type="radio" name="sex" value="2" <?php if( $customerQuestionnaire->sex == 2 )echo " checked='checked'"; ?> >女性</label>
                    </td>
                </tr>
                <tr class="form-field form-required">
                    <th scope="row"><label for="join_trigger">きっかけ<span class="description" >(必須)</span></label></th>
                    <td><textarea name="join_trigger" id="join_trigger" style="width:25em;height:8em;" ><?= $customerQuestionnaire->join_trigger ?></textarea></td>
                </tr>
                <tr class="form-field form-required">
                    <th scope="row"><label for="impression">印象<span class="description" >(必須)</span></label></th>
                    <td><textarea name="impression" id="impression" style="width:25em;height:8em;" ><?= $customerQuestionnaire->impression ?></textarea></td>
                </tr>
                <tr class="form-field form-required">
                    <th scope="row"><label for="thoughts">感想<span class="description" >(必須)</span></label></th>
                    <td><textarea name="thoughts" id="thoughts" style="width:25em;height:8em;" ><?= $customerQuestionnaire->thoughts ?></textarea></td>
                </tr>
                <tr class="form-field form-required">
                    <th scope="row"><label for="future_goals">目標<span class="description" >(必須)</span></label></th>
                    <td><textarea name="future_goals" id="future_goals" style="width:25em;height:8em;" ><?= $customerQuestionnaire->future_goals ?></textarea></td>
                </tr>
                <tr class="form-field form-required">
                    <th scope="row"><label for="img_pass">画像パス<span class="description" >(必須)</span></label></th>
                    <td>
                        <input type="url" name="img_pass" id="img_pass" value="<?= $customerQuestionnaire->img_pass ?>" style="width:40em;" >
                </tr>
                <tr class="form-field form-required">
                    <th scope="row"><label for="display_flg">HPへの表示</label></th>
                    <td>
                        <label><input type="radio" name="display_flg" value="1" <?php if( $customerQuestionnaire->display_flg == 1 )echo " checked='checked'"; ?> >表示</label>
                        <label><input type="radio" name="display_flg" value="0" <?php if( $customerQuestionnaire->display_flg == 0 )echo " checked='checked'"; ?> >非表示</label>
                    </td>
                </tr>
            </tbody>
        </table>
        <input type="hidden" name="id" value="<?= $customerQuestionnaire->id ?>" >
        <input type="hidden" name="update" value="update" >
        <input type="submit" name="" value="更新" >
    </form>
</div>

<script type="text/javascript">
</script>