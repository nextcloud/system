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

return [
	'ocs' => [
		['name' => 'Endpoint#Reboot', 'url' => '/api/v1/reboot', 'verb' => 'POST'],
		['name' => 'Endpoint#Shutdown', 'url' => '/api/v1/shutdown', 'verb' => 'POST'],
		['name' => 'Endpoint#DiskData', 'url' => '/api/v1/diskdata', 'verb' => 'GET'],
	],
];
