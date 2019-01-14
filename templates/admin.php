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



script('system', 'Chart.min');
script('system', 'admin');

style('system', 'admin');

function FormatBytes($byte) {
	$unim = array('B','KB','MB','GB','TB','PB');
	$count = 1;
	while ($byte>=1024) {
		$count++;
		$byte = $byte/1024;
	}
	return number_format($byte,2,'.','.').' '.$unim[$count];
}

?>

<div class="section"><h2><?php echo('<img class="infoicon" src="'.image_path('system', 'server.svg').'">'); p($_['hostname']); ?></h2>

	<p>
		<?php p($l->t('Operating System').': '); ?>
		<span class="info"><?php p($_['osname']); ?></span>
	</p><p>
		<?php p($l->t('CPU').': '); ?>
		<span class="info"><?php p($_['cpu']); ?></span>
	</p><p>
		<?php p($l->t('Memory').': '); ?>
		<span class="info"><?php p($_['memory']); ?></span>
	</p><p>
		<?php p($l->t('Server time').': '); ?>
		<span class="info" id="servertime"></span>
	</p><p>
		<?php p($l->t('Uptime').': '); ?>
		<span class="info" id="uptime"></span>
	</p><p>
		<?php p($l->t('Time Servers').': '); ?>
		<span class="info" id="timeservers"></span>

	</p>

	<button id="reboot" name="reboot">Reboot</button>
	<button id="shutdown" name="shutdown">Shutdown</button>

<?php if($_['rootcommandsavailable']) { ?>
	<button class="triggerreboot" id="reboot"><?php p($l->t('Reboot')); ?></button>
	<div class="modalreboot">
	    <div class="modalreboot-content">
	        <span class="rebootclose-button">×</span>
	        <h1><?php p($l->t('Please enter root password for reboot.')); ?></h1>
			<form method="post">
				<input type="password" name="pwd">
				<input type="hidden" name="todo" value="reboot">
				<input type="submit" value="<?php p($l->t('Reboot')); ?>">
			</form>
	    </div>
	</div>

	<button class="triggershutdown" id="shutdown"><?php p($l->t('Shutdown')); ?></button>
	<div class="modalshutdown">
	    <div class="modalshutdown-content">
	        <span class="shutdownclose-button">×</span>
	        <h1><?php p($l->t('Please enter root password for shutdown.')); ?></h1>
			<form method="post">
				<input type="password" name="pwd">
				<input type="hidden" name="todo" value="shutdown">
				<input type="submit" value="<?php p($l->t('Shutdown')); ?>">
			</form>
	    </div>
	</div>
<?php } else { ?>
	<br /><p><h1><?php p($l->t('The \'expect\' command line tool is not installed. Commands that require root permissions are not available.')); ?></h1></p>
<?php } ?>


</div>

<div class="section"><h2><?php echo('<img class="infoicon" src="'.image_path('system', 'hdd-o.svg').'">'); p($l->t('Disk')); ?></h2>
	<p>
		<?php
		foreach ($_['diskinfo'] as $disk) {

			echo('<div class="infobox">');

			echo('<div class="diskchart-container">');
			echo('<canvas id="DiskChart" class="DiskChart" width="50" height="50"></canvas>');
			echo('</div>');

			echo('<h3>'.basename($disk['device']).'</h3>');
			echo('<p>');
			p($l->t('Mount').': ');
			echo('<span class="info">'.$disk['mount'].'</span>');
			echo('</p><p>');
			p($l->t('Filesystem').': ');
			echo('<span class="info">'.$disk['fs'].'</span>');
			echo('</p><p>');
			p($l->t('Size').': ');
			echo('<span class="info">'.FormatBytes($disk['used']+$disk['available']).'</span>');
			echo('</p><p>');
			p($l->t('Available').': ');
			echo('<span class="info">'.FormatBytes($disk['available']).'</span>');
			echo('</p><p>');
			p($l->t('Available').': ');
			echo('<span class="info">'.$disk['percent'].'</span>');
			echo('</p></div>');
		}
		?>
		<div class="smallinfo"> <?php p($l->t('You will get a notification once one of your disks is nearly full.')); ?></div>
	</p>
</div>

<div class="section"><h2><?php echo('<img class="infoicon" src="'.image_path('system', 'sort.svg').'">'); p($l->t('Network')); ?></h2>
	<p>

		<p>
			<?php p($l->t('Hostname').': '); ?>
			<span class="info"><?php p($_['networkinfo']['hostname']); ?></span>
		</p><p>
			<?php p($l->t('DNS').': '); ?>
			<span class="info"><?php p($_['networkinfo']['dns']); ?></span>
		</p><p>
			<?php p($l->t('Gateway').': '); ?>
			<span class="info"><?php p($_['networkinfo']['gateway']); ?></span>
		</p><p>


<?php

		foreach ($_['networkinterfaces'] as $interface) {
				echo('<div class="infobox">');
				echo('<h3>'.$interface['interface'].'</h3>');
				echo('<p>');
				p($l->t('Status').': ');
				echo('<span class="info">'.$interface['status'].'</span>');
				echo('</p><p>');
				p($l->t('Speed').': ');
				echo('<span class="info">'.$interface['speed'].' '.$interface['duplex'].'</span>');
				echo('</p><p>');

				if(!empty($interface['mac'])) {
					p($l->t('MAC').': ');
					echo('<span class="info">'.$interface['mac'].'</span>');
					echo('</p><p>');
				}
				p($l->t('IPv4').': ');
				echo('<span class="info">'.$interface['ipv4'].'</span>');
				echo('</p><p>');
				p($l->t('IPv6').': ');
				echo('<span class="info">'.$interface['ipv6'].'</span>');
				echo('</p></div>');

		}


		?>
	</p>
</div>
