<?php
define('__MLC_AUTH__', dirname(__FILE__));
define('__MLC_AUTH_V__', '2.0');
define('__MLC_AUTH_CORE__', __MLC_AUTH__ . '/_core');
if(!defined('__MLC_UTIL__')){
	MLCApplication::InitPackage('MLCUtil');
}

define('__MLC_AUTH_CORE_CTL__', __MLC_AUTH_CORE__ . '/ctl');
define('__MLC_AUTH_CORE_MODEL__', __MLC_AUTH_CORE__ . '/model');
define('__MLC_AUTH_CORE_VIEW__', __MLC_AUTH_CORE__ . '/view');
define('__MLC_AUTH_CORE_API__', __MLC_AUTH_CORE__ . '/api');

define('__MLC_AUTH_DATA_LAYER__', __MLC_AUTH_CORE_MODEL__ . '/data_layer');

//MLCApplicationBase::$arrClassFiles['MDEDBDriver'] = __MLC_AUTH__CORE_MODEL__ . '/MDEDBDriver.class.php';


MLCApplicationBase::$arrClassFiles['MLCAuthDriver'] = __MLC_AUTH_CORE__ . '/MLCAuthDriver.class.php';
//CTL
//if(defined('__MJAX__')){
	
	MLCApplicationBase::$arrClassFiles['MLCForgotPassPanel'] = __MLC_AUTH_CORE_CTL__ . '/MLCForgotPassPanel.class.php';
	MLCApplicationBase::$arrClassFiles['MLCLoginPanel'] = __MLC_AUTH_CORE_CTL__ . '/MLCLoginPanel.class.php';
	MLCApplicationBase::$arrClassFiles['MLCResetPasswordPanel'] = __MLC_AUTH_CORE_CTL__ . '/MLCResetPasswordPanel.class.php';
	MLCApplicationBase::$arrClassFiles['MLCSignUpPanel'] = __MLC_AUTH_CORE_CTL__ . '/MLCSignUpPanel.class.php';
	MLCApplicationBase::$arrClassFiles['MLCSignUpPanelBase'] = __MLC_AUTH_CORE_CTL__ . '/MLCSignUpPanelBase.class.php';
    MLCApplicationBase::$arrClassFiles['MLCShortSignUpPanel'] = __MLC_AUTH_CORE_CTL__ . '/MLCShortSignUpPanel.class.php';
    MLCApplicationBase::$arrClassFiles['MLCInvitePanel'] = __MLC_AUTH_CORE_CTL__ . '/MLCInvitePanel.class.php';
//Admin panels
MLCApplicationBase::$arrClassFiles['AuthUserEditPanel'] = __MLC_AUTH_CORE_CTL__ . '/admin_panel/AuthUserEditPanel.class.php';
MLCApplicationBase::$arrClassFiles['AuthRollListPanel'] = __MLC_AUTH_CORE_CTL__ . '/admin_panel/AuthRollListPanel.class.php';

//API
MLCApplicationBase::$arrClassFiles['MLCApiAuthUser'] = __MLC_AUTH_CORE_API__ . '/MLCApiAuthUser.class.php';

require_once(__MLC_AUTH_CORE_CTL__ . '/_events.inc.php');
//}
require_once(__MLC_AUTH_CORE__ . '/_exception.inc.php');
require_once(__MLC_AUTH_CORE__ . '/_enum.inc.php');
require_once(__MLC_AUTH_DATA_LAYER__ . '/base_classes/Conn.inc.php');

//MLCAuthDriver::SetCookieDomain($_SERVER['SERVER_NAME']);
