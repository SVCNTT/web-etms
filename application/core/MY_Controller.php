<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    // Site global layout
    public $layout_view = 'layout/default';

    // Profile info
    public $profile = null;

    // Flag authentication
    public $check_auth = FALSE;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('acl');
        $this->load->helper('url');

        /*Load language - Begin*/
        $this->load_language('common');
        /*Load language - End*/
    }

    public function check_login()
    {
        $this->profile = get_current_profile(PLATFORM);
        return $this->profile !== NULL ? $this->profile : FALSE;
    }

    public function get_idiom() {
        $this->load->library('Authentication');
        $idiom = $this->authentication->get_data('idiom');
        if ($idiom === FALSE) {
            /*Get COOKIE - Begin*/
            $idiom = $this->authentication->get_cookie('idiom');

            $default_lang = $this->config->item('language');
            $idiom = $idiom !== FALSE ? $idiom : $default_lang;
            /*Get COOKIE - End*/

            /*Set SESSION - Begin*/
            $this->authentication->set_data('idiom', $idiom, PLATFORM);
            /*Set SESSION - End*/

            /*Set COOKIE - Begin*/
            $this->authentication->set_cookie('idiom', $idiom);
            /*Set COOKIE - End*/
        }

        return $idiom;
    }

    public function load_language($file_name = '') {
        if (!empty($file_name)) {
            /*Load language - Begin*/
            $idiom = $this->get_idiom();
            $this->lang->load($file_name, $idiom);

            $common_lang = $this->lang->language;
            if (isset($common_lang) && is_array($common_lang)) {
                foreach($common_lang as $key=>$value) {
                    $key = strtoupper($key);
                    if (!defined($key)) {
                        define($key, $value);
                    }
                }
            }
            /*Load language - End*/

            return $common_lang;
        }

        return NULL;
    }

    /**
     * Set layout
     * @param string $layout_view
     * @author Ram
     */
    public function set_layout($layout_view = 'layout/default')
    {
        $this->layout_view = $layout_view;

        // Layout library loaded site wide
        $this->load->helper('url');
        $this->load->library('layout');

        /*Check login - Begin*/
        if ($this->check_login() === FALSE) {
            $this->load->helper('url');
            redirect('/');
        }
        /*Check login - End*/
    }

    /**
     * Set data for layout
     */
    public function set_data_for_layout(&$data, $version = PROJECT_VERSION)
    {
        /*Profile - Begin*/
        $data['profile'] = $this->profile;
        /*Profile - End*/

        $data['html_attr'] = isset($data['html_module']) ? 'ng-app="'.$data['html_module'].'" ng-controller="commonCtrl" ng-cloak' : '';

        $body_attr = '';
        $body_attr .= isset($data['body_id']) && !empty($data['body_id']) ? ' id="'.$data['body_id'].'" ' : '';
        $body_attr .= isset($data['body_module']) && !empty($data['body_module']) ? ' ng-controller="'.$data['body_module'].'" ' : '';
        $body_attr .= isset($data['body_ngInit']) && !empty($data['body_ngInit']) ? ' ng-init="'.$data['body_ngInit'].'" ' : '';
        $body_attr .= isset($data['body_cssClass']) && !empty($data['body_cssClass']) ? ' class="'.$data['body_cssClass'].'" ' : '';
        $data['body_attr'] = $body_attr;

        $data['header_html'] = $this->get_header_html($data['index'], $version);
        $data['footer_html'] = $this->get_footer_html($version);
    }

    public function get_header_html($index, $version) {
        $profile = $this->profile;

        $header_html = '';

        $class_menu = '';
        if (check_ACL($profile, 'admin', 'menu')) {
            $class_menu = 'classMenu';
        }

        switch($version) {
            case '':
                $header_html = '
                    <div class="header">
                        <div class="navbar navbar-default navbar-static-top navbar-menu"
                                 role="navigation">
                            <div class="container header-container '.$class_menu.'">
                                <div class="navbar-header">
                                    <img class="logo-company" src="'.STATIC_SERVER.'/img/'.CLIENT_LOGO_DEFAULT.'" />
                                </div>
                                <div class="navbar-collapse">
                ';

                        $header_html .= $this->get_menu($index);

                        $header_html .= '
                                </div>
                            </div>
                        </div>
                    </div>
                ';
                break;

            case '/v2':
                $header_html .= $this->get_menu_v2($index);
                break;
        }

        return $header_html;
    }

    public function get_menu($index)
    {
        $profile = $this->profile;
        $username = $profile['last_name'] .' '. $profile['first_name'];

        $menu_array = array(
            'dashboard' => array(
                'href' => '/DAS0100',
                'text' => '<i class="fa fa-dashboard"> </i> ' . MENU_DAS
            ),
            'client' => array(
                'href' => '/CLI0300/CLI0000001',
                'text' => '<i class="fa fa-suitcase"> </i> ' . MENU_CLI
            ),
            'store' => array(
                'href' => '/STO0100',
                'text' => '<i class="fa fa-university"></i> ' . MENU_STO
            ),
            'sale' => array(
                'href' => '/SAL0100',
                'text' => '<i class="icon-user-female"></i> ' . MENU_SAL
            ),
            'coa' => array(
                'href' => '/COA0100',
                'text' => '<i class="fa fa-clipboard"></i> ' . MENU_COA
            ),
            'che' => array(
                'href' => '/CHE0100',
                'text' => '<i class="fa fa-check-square"></i> ' . MENU_CHE
            ),
            'rec' => array(
                'href' => '/REC0100',
                'text' => '<i class="fa fa-comments"></i> ' . MENU_REC
            ),
            'kpi' => array(
                'href' => '/KPI0100',
                'text' => '<i class="fa fa-key"></i> ' . MENU_KPI
            ),
            'user' => array(
                'href' => '/USR0100',
                'text' => '<i class="fa fa-users"></i> ' . MENU_USR
            )
        );

        $menu_html = '
                    <ul class="nav navbar-nav">
        ';

        foreach ($menu_array as $key=>$menu) {
            if (check_ACL($profile, $key, 'menu')) {
                $active = $key === $index ? 'active' : '';

                $menu_html .= '
                    <li class="'.$active.'">
                        <a href="' . $menu['href'] . '">' . $menu['text'] . '</a>
                    </li>
                ';
            }
        }

        if (check_ACL($profile, 'report', 'menu')) {
            $menu_html .= '
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-print"></i> ' . MENU_RPT . '
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li>
                          <!-- /RPT0200 -->
                            <a href="#" ng-click="$parent.model.hidden.monthlyReport = true" style="cursor:pointer">
                            ' . MENU_RPT_MONTHLY_REPORT . '
                            </a>

                        </li>
                    </ul>
                </li>
            ';
        }

        $menu_html .= '</ul>';

        $menu_setting = '';
//         if (check_ACL($profile, 'admin', 'message')) {
//             $menu_setting = '
//                 <li>
//                     <a href="/SET0100">
//                     <span class="icon-envelope"></span> '. HEADER_LINK_MESSAGE.'
//                     </a>
//                 </li>
//             ';
//         }

        $menu_html .='
            <ul class="nav navbar-nav navbar-right nav-user">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="glyph-item mega icon-user"></span>
                        <span class="username" title="'.$username.'">'.$username.'</span>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li>
                            <a ng-click="$parent.model.hidden.changePassword = true" style="cursor:pointer">
                                <span class="icon-key"> </span>
                                '. HEADER_LINK_CHANGE_PASSWORD .'
                            </a>
                        </li>
                        '.$menu_setting.'
                        <li>
                            <a href="/Logout">
                            <span class="icon-power" > </span>
                            '. HEADER_LINK_LOGOUT.'
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        ';


        return $menu_html;
    }


    public function get_menu_v2($index)
    {
        $profile = $this->profile;

        $menu_array = array(
            'dashboard' => array(
                'href'  =>  '/DAS0100',
                'text'  =>  '<i class="fa fa-dashboard"> </i> ' . MENU_DAS,
                'sub'   =>  array(
                    'das_over'  =>  array(
                        'href'  =>  '/DAS0110',
                        'text'  =>  '<i class="fa fa-dashboard"> </i> ' . DAS0100_TAB_GENERATE
                    ),
                    'das_loc'   =>  array(
                        'href'  =>  '/DAS0140',
                        'text'  =>  '<i class="fa fa-dashboard"> </i> ' . DAS0100_TAB_LOCATION
                    ),
                    'das_ws'    =>  array(
                        'href'  =>  '/DAS0150',
                        'text'  =>  '<i class="fa fa-dashboard"> </i> ' . DAS0100_TAB_WORKING_SCHEDULE
                    )
                )
            ),
            'client' => array(
                'href' => '/CLI0300/CLI0000001',
                'text' => '<i class="fa fa-suitcase"> </i> ' . MENU_CLI,
                'sub'   =>  array(
                    'cli_pro_type'  =>  array(
                        'href'  =>  '/CLI0360',
                        'text'  =>  '<i class="fa fa-suitcase"> </i> ' . CLI0300_LABEL_PRODUCT_TYPE
                    ),
                    'cli_pro'   =>  array(
                        'href'  =>  '/PRO1100',
                        'text'  =>  '<i class="fa fa-suitcase"> </i> ' . CLI0300_LABEL_PRODUCT_TAB
                    ),
                    'cli_image' =>  array(
                        'href'  =>  '/CLI0350',
                        'text'  =>  '<i class="fa fa-suitcase"> </i> ' . CLI0300_LABEL_IMAGE_TAB
                    )
                )
            ),
            'store' => array(
                'href' => '/STO0100',
                'text' => '<i class="fa fa-home"></i> ' . MENU_STO
            ),
            'sale' => array(
                'href' => '/SAL0100',
                'text' => '<i class="fa fa-user"></i> ' . MENU_SAL
            ),
            'coa' => array(
                'href' => '/COA0100',
                'text' => '<i class="fa fa-clipboard"></i> ' . MENU_COA
            ),
            'che' => array(
                'href' => '/CHE0100',
                'text' => '<i class="fa fa-check-square"></i> ' . MENU_CHE
            ),
            'rec' => array(
                'href' => '/REC0100',
                'text' => '<i class="fa fa-comments"></i> ' . MENU_REC,
                'sub'   =>  array(
                    'rec_rep'   =>  array(
                        'href'  =>  '/REC0200',
                        'text'  =>  '<i class="fa fa-comments"> </i> ' . REC0100_TAB_REPORT
                    ),
                    'rec_conf'  =>  array(
                        'href'  =>  '/REC0300',
                        'text'  =>  '<i class="fa fa-comments"> </i> ' . REC0100_TAB_CONFIGURE
                    ),
                    'kpi'   =>  array(
                        'href'  =>  '/KPI0100',
                        'text'  =>  '<i class="fa fa-key"></i> ' . MENU_KPI
                    )
                )
            ),
            'user' => array(
                'href' => '/USR0100',
                'text' => '<i class="fa fa-users"></i> ' . MENU_USR
            )
        );

        $menu_html = '';

        foreach ($menu_array as $key=>$menu) {
            if (check_ACL($profile, $key, 'menu')) {

                $menu_sub = '';
                if (isset($menu['sub'])) {
                    $menu_sub .= '<ul class="sub-menu">';

                    foreach($menu['sub'] as $key_sub=>$sub) {
                        $active = $key_sub === $index ? 'active' : '';
                        $menu_sub .= ' <li class="' .$active . '">
                                            <a href="' . $sub['href'] . '">' . $sub['text'] . '</a>
                                        </li>';
                    }

                    $menu_sub .= '</ul>';
                }

                $active = $key === $index ? 'active' : '';
                $menu_html .= '
                    <li class="' .$active . '">
                        <a href="' . $menu['href'] . '">' . $menu['text'] . '</a>
                        '.$menu_sub.'
                    </li>
                ';
            }
        }


        return $menu_html;
    }


    public function get_footer_html($version) {
        $footer_html = '
            <div class="footer">
                <div class="wrapper-footer">
                    <div class="pull-left copyright">
                        '. COM0000_COPYRIGHT .'
                    </div>
                    <div class="pull-right version">
                        '. COM0000_VERSION .'
                    </div>
                </div>
            </div>
        ';

        return $footer_html;
    }

    public function create_md5($str = '') {
        return md5(md5($str.PLATFORM));
    }

    /**
     * Return ajax
     */
    public function return_json($result)
    {
        if (is_array($result)) {
            $result = json_encode($result);
        }

        return $this->output
            ->set_content_type('application/json')
            ->set_output(strval($result));
    }

    public function get_roles($is_get_all = TRUE, $key = 'roleName') {
        $result = array(
            array(
                'roleCd'    =>  ROLE_ADMIN_CD,
                $key        =>  ROLE_ADMIN
            ),
            array(
                'roleCd'    =>  ROLE_MOD_CD,
                $key        =>  ROLE_SUB_ADMIN
            ),
//            array(
//                'roleCd'    =>  ROLE_MANAGER_CD,
//                $key        =>  ROLE_MANAGER
//            ),
            array(
                'roleCd'    =>  ROLE_BU_CD,
                $key        =>  ROLE_LEADER
            ),
            array(
                'roleCd'    =>  ROLE_SALES_MANAGER_CD,
                $key        =>  ROLE_SALES_MANAGER
            ),
            array(
                'roleCd'    =>  ROLE_REGION_MANAGER_CD,
                $key        =>  ROLE_SUB_LEADER
            ),
        );

        if ($is_get_all) {
            array_unshift($result, array('roleCd'    =>  NULL, $key  =>  SEARCH_ALL));
        }

        return $result;
    }

    public function getCode($prefix = '', $len = 6, $id = 0) {
        return $prefix . date('Ymd') . str_pad($id, $len, '0', STR_PAD_LEFT);
    }

    public function sendSuccessMail() {
//        $this->load->library('email');
//
//            $this->email->from('mail@mroomsoft.com', 'Mroomsoft');
////            $this->email->from('canhld90@gmail.com', 'Mroomsoft');
//            $this->email->to('wer@mroomsoft.com');
////        $this->email->cc('another@another-example.com');
////        $this->email->bcc('them@their-example.com');
//
//            $this->email->subject('[Web] Email Contact');
//            $this->email->message($message);
//
////        Send mail
//            $this->email->send();

        /*private void sendSuccessMail(UserMst userMst) {
COM0000MailMessageDto mailDto = new COM0000MailMessageDto();
mailDto.setFrom(Configurations.getProperty(ConfigurationId.MAIL_FROM));
mailDto.setTo(userMst.getEmail());
mailDto.setSubject(Messages.getMessage(MessageId.MAIL_REG_USER_SUBJECT));
mailDto.setText(Messages.getMessage(MessageId.MAIL_REG_USER_BODY,
userMst.getLastName() + " " + userMst.getFirstName(),
userMst.getEmail()));
com0000MailLogic.sendMail(mailDto);*/
    }

}
// END Controller class

/* End of file MY_Controller.php */
/* Location: ./system/core/MY_Controller.php */
