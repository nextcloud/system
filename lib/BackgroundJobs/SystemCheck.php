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

namespace OCA\System\BackgroundJobs;

use OC\BackgroundJob\TimedJob;
use OCA\System\AppInfo\Application;
use OCP\AppFramework\Http;

class SystemCheck extends TimedJob {

	/**
	 * MonthlyReport constructor.
	 */
	public function __construct() {
		// Run all 28 days
		//$this->setInterval(28 * 24 * 60 * 60);
		$this->setInterval(10);
	}

	protected function run($argument) {
	//	$application = new Application();
		/** @var \OCA\System\Os $os */
	//	$os = $application->getContainer()->query('OCA\System\Os');
	//	$result = $os->getDiskInfo();
			error_log('background job is running !!!!');

//		if ($result<>true) {
//			\OC::$server->getLogger()->info('System has detected a health issue with your hard disk. Please check imediately');
//			error_log('disk issue');
//		}
	}
}
