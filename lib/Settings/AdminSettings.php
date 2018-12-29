<?php
/**
 * @copyright Copyright (c) 2018 Frank Karlitschek <frank@nextcloud.com>
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */


namespace OCA\System\Settings;


use OCA\System\Os;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\BackgroundJob\IJobList;
use OCP\IConfig;
use OCP\IDateTimeFormatter;
use OCP\IL10N;
use OCP\Settings\ISettings;

class AdminSettings implements ISettings {

	/** @var Os */
	private $os;

	/** @var IConfig */
	private $config;

	/** @var IL10N */
	private $l;

	/** @var IDateTimeFormatter */
	private $dateTimeFormatter;

	/** @var IJobList */
	private $jobList;

	/**
	 * Admin constructor.
	 *
	 * @param Os $os
	 * @param IConfig $config
	 * @param IL10N $l
	 * @param IDateTimeFormatter $dateTimeFormatter
	 * @param IJobList $jobList
	 */
	public function __construct(Os $os,
								IConfig $config,
								IL10N $l,
								IDateTimeFormatter $dateTimeFormatter,
								IJobList $jobList
	) {
		$this->os = $os;
		$this->config = $config;
		$this->l = $l;
		$this->dateTimeFormatter = $dateTimeFormatter;
		$this->jobList = $jobList;
	}

	/**
	 * @return TemplateResponse
	 */
	public function getForm() {
		$supported = $this-> os -> supported();

		if($supported) {

			$status = $this-> os -> Reboot('password');
			error_log($status);

			$rebooting = $status;
			$rebooting = false;

			if(isset($rebooting) and $rebooting) {
				return new TemplateResponse('system', 'reboot', array());
			} elseif(isset($shutdown) and $shutdown) {
				return new TemplateResponse('system', 'shutdown', array());
			} else {
				$parameters = [
					'hostname' => $this-> os -> getHostname(),
					'osname' => $this-> os -> getOSName(),
					'memory' => $this-> os -> getMemory(),
					'cpu' => $this-> os -> getCPUName(),
					'uptime' => $this-> os -> getUptime(),
					'diskinfo' => $this-> os -> getDiskInfo(),
					'networkinfo' => $this-> os -> getNetworkInfo(),
					'networkinterfaces' => $this-> os -> getNetworkInterfaces(),
				];
				return new TemplateResponse('system', 'admin', $parameters);
			}

		} else {
			return new TemplateResponse('system', 'unsupported', array());
		}
	}

	/**
	 * @return string the section ID, e.g. 'sharing'
	 */
	public function getSection() {
		return 'system';
	}

	/**
	 * @return int whether the form should be rather on the top or bottom of
	 * the admin section. The forms are arranged in ascending order of the
	 * priority values. It is required to return a value between 0 and 100.
	 */
	public function getPriority() {
		return 90;
	}

}
