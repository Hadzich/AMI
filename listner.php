<!DOCTYPE html>

<html>
	<body>
		<?php
		require 'vendor/autoload.php';
		use PAMI\Client\Impl\ClientImpl as PamiClient;
		use PAMI\Message\Event\EventMessage;
		use PAMI\Listener\IEventListener;

		$pamiClientOptions = array(
			'host' => '127.0.0.1',
			'scheme' => 'tcp://',
			'port' => 5038,
			'username' => 'test',
			'secret' => 'test123',
			'connect_timeout' => 10000,
			'read_timeout' => 10000
		);
		
		$pamiClient = new PamiClient($pamiClientOptions);
		$pamiClient->open();
				
		echo "<script>";
		echo 'var conn = new WebSocket("ws://localhost:8080");';
		echo '		conn.onopen = function(e) {
					console.log("Connection established!");
					};';
		echo "</script>";
			
		$pamiClient->registerEventListener(function (EventMessage $event) {
			if ($event->getKeys()['event']=='Newchannel' || $event->getKeys()['event']=='Hangup' || $event->getKeys()['event']=='ContactStatus')  {
				echo "<script>";
				echo '
				conn.send("{ \"event\":\"'.$event->getKeys()['event'].'\", \"channel\": \"'.$event->getKeys()['channel'].'\" }");';
				echo "</script>";
			}
		});

		$running = true;
		while($running) {
			$pamiClient->process();
			echo "       ";
			usleep(1000);
		}
		$pamiClient->close();

		?>
	 </body>
</html>