<?php

/** WordPress Administration Bootstrap */
require_once __DIR__ . '/../../../wp-admin/admin.php';

class CustomerQuestionnaire {

	private $_display_flg = NULL ;
	private $_sex = NULL ;

	public function register( ) {
		try {

            // リクエストパラメータのセットする
			$this->set_param();

			// エラーチェックを行う
			$err_lists = $this->check_validation();
			if($err_lists) throw new \Exception();

			// DB登録処理
			global $wpdb;
			$wpdb->insert(
				'customer_questionnaire',
				array(
					'initial_name'  => $this->_initial_name,
					'age'           => $this->_age,
					'sex'           => $this->_sex,
					'join_trigger'  => $this->_join_trigger,
					'impression'    => $this->_impression,
					'thoughts'      => $this->_thoughts,
					'future_goals'  => $this->_future_goals,
					'img_pass'      => $this->_img_pass,
					'display_flg'   => $this->_display_flg,
				// ),array(
				// 	'%d', //instructor_id
				// 	'%s', //comment
				)
			);

			add_settings_error( 'settings_errors', 'settings_errors', '登録が完了しました。', 'success' );
			// add_settings_error()した内容を、DBに一時保存する
			set_transient( 'settings_errors', get_settings_errors(), 30 );

			// Redirect back to the settings page that was submitted.
			$goback = add_query_arg( 'settings-updated', 'true', '../../../wp-admin/admin.php?page=customerQuestionnaire' );
			wp_redirect( $goback );
			exit;

		} catch (\Exception $e) {
			// If no settings errors were registered add a general 'updated' message.
			foreach($err_lists as $err_list){
				add_settings_error( 'settings_errors', 'settings_errors', $err_list, 'error' );
			}

			// add_settings_error()した内容を、DBに一時保存する
			set_transient( 'settings_errors', get_settings_errors(), 30 );

			$date = array(
				'settings-updated' => true,
				'initial_name'     => $this->_initial_name,
				'age'              => $this->_age,
				'sex'              => $this->_sex,
				'join_trigger'     => $this->_join_trigger,
				'impression'       => $this->_impression,
				'thoughts'         => $this->_thoughts,
				'future_goals'     => $this->_future_goals,
				'img_pass'         => $this->_img_pass,
				'display_flg'      => $this->_display_flg,
			);
			// Redirect back to the settings page that was submitted.
			$goback = add_query_arg( $date, wp_get_referer() );
			wp_redirect( $goback );
			exit;
		}
	}

	public function update() {
		try {
			// リクエストパラメータのセットする
			$this->set_param();

			// エラーチェックを行う
			$err_lists = $this->check_validation();
			if($err_lists) throw new \Exception();

			global $wpdb;
			$wpdb->update(
				'customer_questionnaire',
				array(
					'initial_name'  => $this->_initial_name,
					'age'           => $this->_age,
					'sex'           => $this->_sex,
					'join_trigger'  => $this->_join_trigger,
					'impression'    => $this->_impression,
					'thoughts'      => $this->_thoughts,
					'future_goals'  => $this->_future_goals,
					'img_pass'      => $this->_img_pass,
					'display_flg'   => $this->_display_flg,
				),
				// where句
				array( 'id' => $_POST['id'] ),
			);

			add_settings_error( 'settings_errors', 'settings_errors', '更新が完了しました。', 'success' );
			// add_settings_error()した内容を、DBに一時保存する
			set_transient( 'settings_errors', get_settings_errors(), 30 );

			// Redirect back to the settings page that was submitted.
			$goback = add_query_arg( 'settings-updated', 'true', '../../../wp-admin/admin.php?page=customerQuestionnaire' );
			wp_redirect( $goback );
			exit;

		} catch (\Exception $e) {
			$getMessage = $e->getMessage();

			// If no settings errors were registered add a general 'updated' message.
			foreach($err_lists as $err_list){
				add_settings_error( 'settings_errors', 'settings_errors', $err_list, 'error' );
			}

			// add_settings_error()した内容を、DBに一時保存する
			set_transient( 'settings_errors', get_settings_errors(), 30 );

			// Redirect back to the settings page that was submitted.
			$goback = add_query_arg( 'settings-updated', 'true', wp_get_referer() );
			wp_redirect( $goback );
			exit;
		}
	}

	public function set_param(){
		$this->_initial_name     = $_POST['initial_name'] ;
		$this->_age              = $_POST['age'] ;
        if(!is_null($_POST["sex"])){
            $this->_sex          = $_POST['sex'] ;
        }
		$this->_join_trigger     = $_POST['join_trigger'] ;
		$this->_impression       = $_POST['impression'] ;
		$this->_thoughts         = $_POST['thoughts'] ;
		$this->_future_goals     = $_POST['future_goals'] ;
		$this->_img_pass         = $_POST['img_pass'] ;
        if(!is_null($_POST["display_flg"])){
            $this->_display_flg  = $_POST['display_flg'] ;
        }
	}

	public function check_validation(){
		$err_lists = [];
		if(!$this->_initial_name) array_push($err_lists,'イニシャル名が入力されていません');
		if(!$this->_join_trigger) array_push($err_lists,'きっかけが入力されていません');
		if(!$this->_impression) array_push($err_lists,'印象が入力されていません');
		if(!$this->_thoughts) array_push($err_lists,'感想が入力されていません');
		if(!$this->_future_goals) array_push($err_lists,'目標が入力されていません');
		if(!$this->_img_pass) array_push($err_lists,'画像パスが入力されていません');
		if(is_null($this->_display_flg)) array_push($err_lists,'HPへの表示を選択してください');

		return $err_lists ;
	}

	public function delete() {
		try {
			$ID = $_POST['ID'];

			global $wpdb;
			$wpdb->update(
				'customer_questionnaire',
				array(
						'del_flg' => '1'
				),
				array( 'id' =>  $ID )   // where句
			);

			add_settings_error( 'settings_errors', 'settings_errors', '削除が完了しました。', 'success' );
			// add_settings_error()した内容を、DBに一時保存する
			set_transient( 'settings_errors', get_settings_errors(), 30 );
			$goback = add_query_arg( 'settings-updated', 'true', '../../../wp-admin/admin.php?page=customerQuestionnaire' );
			wp_redirect( $goback );

			exit;
		} catch (\Exception $e) {
			add_settings_error( 'settings_errors', 'settings_errors', '異常が発生しました。', 'error' );
			// add_settings_error()した内容を、DBに一時保存する
			set_transient( 'settings_errors', get_settings_errors(), 30 );
		} finally{
			$goback = add_query_arg( 'settings-updated', 'true', '../../../wp-admin/admin.php?page=customerQuestionnaire' );
			wp_redirect( $goback);
			exit;
		}
	}
}

$CustomerQuestionnaire = new CustomerQuestionnaire();
if ($_SERVER['REQUEST_METHOD'] === 'POST') { //POSTが渡されたら
	if($_POST['update'] )$CustomerQuestionnaire -> update();
	if($_POST['register'] )$CustomerQuestionnaire -> register();
	if($_POST['delete'] )$CustomerQuestionnaire -> delete();
}
