<?php
namespace rrsoacis\apps\manual_post;

use rrsoacis\system\Config;
use rrsoacis\component\common\AbstractController;
use rrsoacis\manager\AppManager;

class ManualPostMainController extends AbstractController
{
    public function get()
    {
        $apps = AppManager::getApps();
        include(dirname(__FILE__).'/ManualPostMainView.php');
    }
}
?>
