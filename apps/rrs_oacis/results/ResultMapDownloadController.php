<?php
namespace rrsoacis\apps\rrs_oacis\results;

use rrsoacis\system\Config;
use rrsoacis\component\common\AbstractController;
use rrsoacis\apps\rrs_oacis\results\model\ResultGeneration;
use rrsoacis\apps\rrs_oacis\results\model\ResultTeam;
use rrsoacis\apps\rrs_oacis\results\model\ResultHelper;
use rrsoacis\apps\rrs_oacis\results\model\ResultDownload;
use rrsoacis\apps\rrs_oacis\competition\SessionManager;

class ResultMapDownloadController extends AbstractController{

	public function anyIndex($session= null,$mapName= null){

		//$zipDate = self::downloadMap($session,$mapName);
		$zipDate = self::downloadMap($session,str_replace('.tar.gz','',$mapName));

		header('Content-Type: application/x-tar; name="' . $mapName);
		header('Content-Disposition: attachment; filename="' . $mapName);
		header('Content-Length: '.strlen($zipDate));
		echo $zipDate;

		//echo 'aaa';

	}

	public static function downloadMap($simulationID= null,$mapName= null){

		//Download Map data

		$data = SessionManager::getSessions();

		for($k=0;$k<count($data);$k++){

			if( $data[$k]["name"]!= $simulationID )continue;

				for($j=0;$j<count($data[$k]["maps"]);$j++){

				$mapDateName= $data[$k]["maps"][$j]["name"];
				$mapAliasDateName= $data[$k]["maps"][$j]["alias"];
				if( $mapAliasDateName!= $mapName ) continue;

				//MapのDownload

				$mapDir = Config::$ROUTER_PATH.Config::MAPS_DIR_NAME;
				$path = $mapDir . '/' . $mapDateName;


				$shell = shell_exec('cd '.$path. ';tar cfvz '.$mapAliasDateName.'.tar.gz .');

				$zipDate = @file_get_contents($path.'/'.$mapAliasDateName.'.tar.gz');



				shell_exec('cd '.$path. ';rm '.$mapAliasDateName.'.tar.gz');

				return $zipDate;


			}



		}


	}

}

