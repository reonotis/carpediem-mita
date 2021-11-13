<?php
/*
Plugin Name: CustomerQuestionnaire
Plugin URI:
Description: お客様の声を設定する
Version: 1.0.0
Author: Reon Fujisawa
License: GPLv2
*/




use \plgin\customer_questionnaire_parent;

/**
 * プラグイン本体
 *
 */
class Customer_questionnaire
//  extends customer_questionnaire_parent
{
    const NOT_INSTALLED = 0 ;   // 初期設定未実施
    const INITIALLY_SET = 1 ;   // plugin無効化 初期設定済み　
    const ACTIVATION    = 2 ;   // plugin有効化

    private $_table_name = "customer_questionnaire" ;   // テーブル名

    /**
     * コンストラクタ
     *
     * ウィジェットの初期化、WPフック・ショートタグなどの登録を行う。
     */
    public function __construct()
    {
        // プラグインが有効化されたときに実行されるメソッドを登録
        if (function_exists('register_activation_hook'))
        {
            register_activation_hook(__FILE__, array(&$this, 'activationHook'));
        }

        // プラグインが停止されたときに実行されるメソッドを登録
        if (function_exists('register_deactivation_hook'))
        {
            register_deactivation_hook(__FILE__, array(&$this, 'deactivationHook'));
        }

        // プラグインがアンインストールされたときに実行されるメソッドを登録
        if (function_exists('register_uninstall_hook'))
        {
            register_uninstall_hook(__FILE__, array(&$this, 'uninstallHook'));
        }

        // ウィジェットの初期化
        $this->initWidgets();

        // アクションフックの設定
        add_action('init', array(&$this, 'initActionHook'));

        // フィルターフックの設定
        add_filter('the_content', array(&$this, 'theContentFilterHook'));

        // ショートコードの設定
        add_shortcode('show_customer_questionnaire', array(&$this, 'fnc_show_customer_questionnaire'));
    }

    /**
     * プラグインが有効化されたときに実行されるメソッド
     *
     * @return void
     */
    public function activationHook() {

        // フラグがなければ初回有効時と判断して、初期設定を実施する
        if (! get_option('customer_questionnaire_plugin_installed')) {
            // オプション値の登録
            add_option('customer_questionnaire_plugin_installed', self::NOT_INSTALLED );
            // インストール済みフラグをセット
            update_option('customer_questionnaire_plugin_installed', self::NOT_INSTALLED);

            global $wpdb;

            // テーブルの作成
            $sql = "CREATE TABLE ". $this->_table_name ." (
                        `id`           int(10)      NOT NULL AUTO_INCREMENT COMMENT 'ID',
                        `initial_name` varchar(100) NOT NULL           COMMENT 'イニシャルネーム',
                        `age`          int(10)      NOT NULL           COMMENT '年齢',
                        `sex`          int(10)      NOT NULL           COMMENT '性別',
                        `join_trigger` varchar(200) NOT NULL           COMMENT 'きっかけ',
                        `impression`   varchar(200) NOT NULL           COMMENT '印象',
                        `thoughts`     varchar(200) NOT NULL           COMMENT '感想',
                        `future_goals` varchar(200) NOT NULL           COMMENT '目標',
                        `img_pass`     varchar(200) DEFAULT NULL       COMMENT '画像パス',
                        `display_flg`  int(1)       NOT NULL DEFAULT 0 COMMENT '表示フラグ',
                        `del_flg`      int(1)       NOT NULL DEFAULT 0 COMMENT '削除フラグ',
                        UNIQUE KEY id (id)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

                    ALTER TABLE ". $this->_table_name ."
                    ADD PRIMARY KEY (`id`);
            ";
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta($sql);


            // $ALTER_sql = "ALTER TABLE ". $this->_table_name ."
            // ADD PRIMARY KEY (`id`);";
            // dbDelta($ALTER_sql);

            // option を初期設定済みに更新
            update_option('customer_questionnaire_plugin_installed', self::INITIALLY_SET);
        }

        // option plugin有効化 に更新
        update_option('customer_questionnaire_plugin_installed', self::ACTIVATION);
    }

    /**
     * プラグインが停止されたときに実行されるメソッドx
     *
     * @return void
     */
    public function deactivationHook() {
        // option plugin無効化 初期設定済み　に更新する
        update_option('customer_questionnaire_plugin_installed', self::INITIALLY_SET);
    }

    /**
     * プラグインが削除(アンインストール)されたときに実行されるメソッド
     *
     * unisntall.phpがある場合、unisntall.phpが優先的に実行されるので注意
     *
     * @return void
     */
    public function uninstallHook() {
        // オプション値の削除など・・・

        $sql = "DROP TABLE IF EXISTS " . $this->_table_name ;
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta($sql);

        // インストール済みフラグを削除する
        delete_option('customer_questionnaire_plugin_installed');
    }

    /**
     * ウィジェットの登録
     *
     * @return void
     */
    public function initWidgets() {
        // ウィジェットの登録とか・・・
        // require_once __DIR__ . '/widgets/Sample.php';
        // add_action('widgets_init', create_function('', 'return register_widget("My_Widget_Sample");'));

        add_action('admin_menu', 'dejimono_CategoryCreatorMenu');

        /* 管理画面呼び出し */
        function dejimono_CategoryCreatorMenu() {
            add_menu_page(
                'Customer questionnaire',          //（文字列） （必須） メニューが選択されたとき、ページのタイトルタグに表示されるテキスト。
                'お客様の声',                       //（文字列） （必須） メニューとして表示されるテキスト
                'administrator',                   //（文字列） （必須） メニューを表示するために必要な権限。注:ユーザーレベルは非推奨ですので使用しないでください。
                'customerQuestionnaire',      //（文字列） （必須） メニューのスラッグ名。一意であり、小文字の英数字、ダッシュ、下線のみを含む必要があります。これは sanitize_key() /en と互換の文字セットです。
                'func_customerQuestionnaire_list', //（文字列） （オプション） メニューページを表示する際に実行される関数
                'dashicons-admin-comments'         //（文字列） （オプション） メニューのアイコンを示す URL
            );
        }

        /* 管理画面表示部 */
        function func_customerQuestionnaire_list() {
            include_once 'display.php';
        }

        // 管理画面のサブメニュー
        function add_custom_submenu_page_cou(){
            add_submenu_page('customerQuestionnaire', 'Customer questionnaire', 'お客様の声登録', 'manage_options', 'register_customer_questionnaire', 'add_register_customer_questionnaire_page', 2);
            // add_submenu_page('customerQuestionnaire', 'Customer questionnaire', '編集', 'manage_options', 'edit_customer_questionnaire', 'add_edit_customer_questionnaire_page', 3);
        }
        function add_register_customer_questionnaire_page(){
            include 'create.php';
        }
        // function add_edit_customer_questionnaire_page(){
        //     include 'create.php';
        // }
        add_action('admin_menu', 'add_custom_submenu_page_cou');


    }

    /**
     * initアクションフック
     *
     * @return void
     */
    public function initActionHook() {
        // initアクションの処理・・・
    }

    /**
     * the_contentフィルターフック
     *
     *
     * @param string $content 変更前のコンテンツ
     * @return string 変更後のコンテンツ
     */
    public function theContentFilterHook($content) {
        // the_contentフィルターフックの処理・・・
        return $content;
    }

    /* ショートコード */
    function fnc_show_customer_questionnaire($atts) {
        $pairs = array(
            'id' => '',
        );
        $atts = shortcode_atts( $pairs, $atts );

        if(empty($atts['id'])){
            return "idが指定されていません";
        }else{
            // TODO IDのvalidationチェックが必要
            $id = $atts['id'];
            // JSとか必要ならここで登録
            wp_enqueue_script(
                'customer_questionnaire_handle_js',
                plugin_dir_url( __FILE__ ) . '/js/main.js',
                array( 'jquery' ),
                false,
                true
            );

            wp_enqueue_style(
                'parent-customer_questionnaire_handle_css',
                plugin_dir_url( __FILE__ ) . '/css/style.css',
                array(),
                '1.1.1'
            );

            global $wpdb;

            $query="SELECT *
                FROM " . $this->_table_name . "
                WHERE id = $id
                AND del_flg = 0
                AND display_flg = 1
            ";
            $results = $wpdb->get_row($query);

            if(empty($results)){
                return "データを取得できません";
            }

            $out = '<div class="cq_content" >';
                $out .= '<div class="cq_initialNameArea" >'. $this->set_name_age_sex($results->initial_name, $results->age, $results->sex) .'</div>';
                $out .= '<div class="cq_textArea" >';
                    $out .= '<div class="cq_textContent" >';
                        $out .= '<div class="cq_textWrapper" >きっかけ</div>';
                        $out .= '<div class="cq_textBody" >'.$results->join_trigger.'</div>';
                    $out .= '</div>';
                    $out .= '<div class="cq_textContent" >';
                        $out .= '<div class="cq_textWrapper" >印象</div>';
                        $out .= '<div class="cq_textBody" >'.$results->impression.'</div>';
                    $out .= '</div>';
                    $out .= '<div class="cq_textContent" >';
                        $out .= '<div class="cq_textWrapper" >感想</div>';
                        $out .= '<div class="cq_textBody" >'.$results->thoughts.'</div>';
                    $out .= '</div>';
                    $out .= '<div class="cq_textContent" >';
                        $out .= '<div class="cq_textWrapper" >目標</div>';
                        $out .= '<div class="cq_textBody" >'.$results->future_goals.'</div>';
                    $out .= '</div>';
                $out .= '</div>';
                $out .= '<div class="cq_imgArea" id="cq_imgArea_' . $results->id . '" ><img src="'. $results->img_pass .'"></div>';
            $out .= '</div>';


            return $out;
        }
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

}

// グローバル変数にPlugin_Sampleインスタンスを生成するだけ
$customerQuestionnaire = new Customer_questionnaire();
