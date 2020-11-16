<!DOCTYPE html>
<html>
  <head> 
    <title>Semantic UI</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.13/semantic.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

  </head>
  <body>
  
  <div class="ui compact labeled icon menu">
      <a href="index.php" class="item">
        <i class="chart pie icon"></i>
        Board
      </a>
      <a href="users.php" class="item">
       <i class="users icon"></i>
        Users
      </a>
      <a href="extensions.php" class="item">
      <i class="microchip icon"></i>
      Confg
      </a>
    </div>
    <br>
    <br>

   
    <?php
      require 'vendor/autoload.php';
      use PAMI\Client\Impl\ClientImpl as PamiClient;
      use PAMI\Message\Event\EventMessage;
      
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

      $action = new \PAMI\Message\Action\GetConfigAction('extensions.conf',false);
      $result = $pamiClient->send($action);
          $extensionConfg = "";
          foreach ($result->getKeys() as  $key => $value) {
            if ($key !='response' && $key !='actionid'){
              $extensionConfg .= "$value <br>";
            }
          }
      ?>

     <div class="ui message">
      <div class="header">
        Extensions.confg
      </div>
      <p><?php echo $extensionConfg; ?></p>
    </div>

    <script type="text/javascript">
    $(document).ready(function(){
		var conn = new WebSocket('ws://localhost:8080');
		conn.onopen = function(e) {
		    console.log("Connection established!");
       conn.send("");
		};

		conn.onmessage = function(e) {
		};

		conn.onclose = function(e) {
			console.log("Connection Closed!");
		}

		$("#send").click(function(){
			 var userId 	= "ID usera";
			 var msg 	= $("#testid").val();
			 var data = {
			 	userId: userId,
			 	msg: msg
			 };
			conn.send(JSON.stringify(data));
		});


	})
</script>

  </body>
</html>
