<?php
/**
 * @author Frank Karlitschek <frank@nextcloud.com>
 *
 * @license AGPL-3.0
 *
 * This code is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License, version 3,
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License, version 3,
 * along with this program.  If not, see <http://www.gnu.org/licenses/>
 *
 */

namespace OCA\System;

use bantu\IniGetWrapper\IniGetWrapper;
use OCP\AppFramework\Http;
use OCP\AppFramework\Http\DataResponse;
use OCP\Http\Client\IClientService;
use OCP\IConfig;
use OCP\IDBConnection;
use OCP\IL10N;
use OCA\System\OperatingSystems\Unknown;
use OCA\System\OperatingSystems\Ubuntu;

class Os {


	/** @var IClientService */
	protected $clientService;

	/** @var IConfig */
	protected $config;

	/** @var IDBConnection */
	protected $connection;

	/** @var IniGetWrapper */
	protected $phpIni;

	/** @var \OCP\IL10N */
	protected $l;

	/** @var */
	protected $backend;

	/**
	 * Os constructor.
	 *
	 * @param IClientService $clientService
	 * @param IConfig $config
	 * @param IDBConnection $connection
	 * @param IniGetWrapper $phpIni
	 * @param IL10N $l
	 */
	public function __construct(IClientService $clientService, IConfig $config, IDBConnection $connection, IniGetWrapper $phpIni, IL10N $l) {
		$this->clientService = $clientService;
		$this->config = $config;
		$this->connection = $connection;
		$this->phpIni = $phpIni;
		$this->l = $l;

		$detectedOs = $this -> detectOs();
		switch ($detectedOs) {
			case 'ubuntu':
				$this->backend = new Ubuntu();
				break;
			default:
				$this->backend = new Unknown();
				break;
		}
	}


	/**
	 * @return string
	 */
	public function detectOs() {
		$release = shell_exec('cat /etc/*-release');
		if(stripos($release,'ubuntu')) {
			return('ubuntu');
		} elseif(stripos($release,'debian')) {
			return('debian');
		} elseif(stripos($release,'suse')) {
			return('suse');
		} elseif(stripos($release,'fedora')) {
			return('fedora');
		} elseif(stripos($release,'centos')) {
			return('centos');
		} else {
			return('unknown');
		}
	}


	/**
	 * @return bool
	 */
	public function supported() {
		$data = $this -> backend -> supported();
		return $data;
	}

	/**
	 * @return string
	 */
	public function getHostname() {
		$data = $this -> backend -> getHostname();
		return $data;
	}

	/**
	 * @return string
	 */
	public function getOSName() {
		$data = $this -> backend -> getOSName();
		return $data;
	}

	/**
	 * @return string
	 */
	public function getMemory() {
		$data = $this -> backend -> getMemory();
		return $data;
	}

	/**
	 * @return string
	 */
	public function getCPUName() {
		$data = $this -> backend -> getCPUName();
		return $data;
	}

	/**
	 * @return string
	 */
	public function getTime() {
		$data = $this -> backend -> getTime();
		return $data;
	}

	/**
	 * @return string
	 */
	public function getUptime() {
		$data = $this -> backend -> getUptime();
		return $data;
	}

	/**
	 * @return string
	 */
	public function getTimeServers() {
		$data = $this -> backend -> getTimeServers();
		return explode("\n",$data);
	}

	/**
	 * @return string
	 */
	public function getDiskInfo() {
		$data = $this -> backend -> getDiskInfo();
/*
		// debug data
		$data = array();

		$item['device'] = 'device1';
		$item['fs'] = 'ext';
		$item['used'] = 1000000;
		$item['available'] = 2000000;
		$item['percent'] = '30%';
		$item['mount'] = '/data';
		$data[] = $item;

		$item['device'] = 'device2';
		$item['fs'] = 'ext';
		$item['used'] = 2000000;
		$item['available'] = 1000000;
		$item['percent'] = '10%';
		$item['mount'] = '/data222';
		$data[] = $item;


		$item['device'] = 'device3';
		$item['fs'] = 'ext4';
		$item['used'] = 10000000;
		$item['available'] = 50000000;
		$item['percent'] = '90%';
		$item['mount'] = '/data3';
		$data[] = $item;
*/
		return $data;
	}


	/**
	 * @return string
	 */
	public function getDiskData() {
		$disks = $this -> backend -> getDiskInfo();
		$data = array();
		$i = 0;
		foreach($disks as $disk){
			$data[$i] = array(round(($disk['used'])/1024/1024,1),round($disk['available']/1024/1024,1));
			$i++;
		}

//		debug data
//		$data = array('0'=>array(1,2),'1'=>array(4,5),'2'=>array(3,1));

		return $data;
	}

	/**
	 * @return string
	 */
	public function getNetworkInfo() {
		$data = $this -> backend -> getNetworkInfo();
		return $data;
	}

	/**
	 * @return string
	 */
	public function getNetworkInterfaces() {
		$data = $this -> backend -> getNetworkInterfaces();
		return $data;
	}

	/**
	* @return bool
	*/
	public function RootCommandsAvailable() {
		$data = $this -> backend -> RootCommandsAvailable();
		return $data;
	}

	/**
	 * @return string
	 */
	public function Reboot($pwd) {
		$data = $this -> backend -> reboot($pwd);
		return $data;
	}

	/**
	 * @return string
	 */
	public function Shutdown($pwd) {
		$data = $this -> backend -> shutdown($pwd);
		return $data;
	}

}
