<?php
/**
 * Created by PhpStorm.
 * User: k14041kk
 * Date: 2017/10/06
 * Time: 14:04
 */
namespace rrsoacis\apps\investigation;

use rrsoacis\system\Config;
use rrsoacis\component\common\AbstractController;
use rrsoacis\manager\AppManager;
use rrsoacis\manager\MapManager;
use rrsoacis\manager\AgentManager;

class InvestigationMainController extends AbstractController
{
    public function get()
    {

        $maps = MapManager::getMaps();
        $agents = AgentManager::getAgents();


        $apps = AppManager::getApps();
        include(dirname(__FILE__).'/InvestigationMainView.php');
    }
}
?>
