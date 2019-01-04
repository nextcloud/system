<?php
declare(strict_types=1);
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

namespace OCA\System\Controller;

use OCA\System\Os;

use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\OCSController;
use OCP\BackgroundJob\IJobList;
use OCP\IRequest;
use OCP\Notification\IManager;
use OCA\System\BackgroundJobs\MonthlyReport;

class EndpointController extends OCSController {

	/** @var OS */
	protected $os;

	/** @var IJobList */
	protected $jobList;

	/** @var IManager */
	protected $manager;

	/**
	 * @param string $appName
	 * @param IRequest $request
	 * @param Os $os
	 * @param IJobList $jobList
	 * @param IManager $manager
	 */
	public function __construct(string $appName,
								IRequest $request,
								Os $os,
								IJobList $jobList,
								IManager $manager) {
		parent::__construct($appName, $request);

		$this->os = $os;
		$this->jobList = $jobList;
		$this->manager = $manager;
	}


	/**
	 * @return DataResponse
	 */
	public function Reboot(): DataResponse {
		$result = $this->os->reboot();
		return new DataResponse();
	}

	/**
	 * @return DataResponse
	 */
	public function Shutdown(): DataResponse {
		$result = $this->os->shutdown();
		return new DataResponse();
	}

	/**
	 * @return DataResponse
	 */
	public function DiskData(): DataResponse {
		$result = $this->os->getDiskData();
		return new DataResponse($result);

	}

	/**
	 * @return DataResponse
	 */
	public function getTime(): DataResponse {
		$servertime = $this->os->getTime();
		$uptime = $this->os->getUptime();
		$timeservers = $this->os->getTimeServers()[0];
		return new DataResponse(array('servertime'=>$servertime,'uptime'=>$uptime,'timeservers'=>$timeservers));

	}

}
