<?php
/**
 * @copyright Copyright (c) 2018, Frank Karlitschek frank@nextcloud.com>
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

/** @var $l \OCP\IL10N */
/** @var $_ array */

script('system', 'admin');
style('system', 'admin');
?>

<div id="system" class="section">
	<h2><?php p($l->t('Unsupported Operating System')); ?></h2>

	<p>
	<?php p($l->t('Unfortunatel your Operating System is not yet supported by this app. You can easily help to fix this by contributing a driver for your operating system. You can also help with testing this app with your operating system and report issues. You can find more information on Github ')); ?>

	<br /><br /><button href="https://github.com/nextcloud/system">Nextcloud System App</button> 
	</p>



</div>
