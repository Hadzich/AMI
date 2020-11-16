<!DOCTYPE html>
<html>
  <head> 
    <title>Semantic UI</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.13/semantic.min.css">
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
        // this connections should be in confg files
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
      $action = new \PAMI\Message\Action\PJSIPShowAorsAction();
      $result = $pamiClient->send($action);

      $result = (array) $result->getevents();
      $dir    = '/opt/lampp/htdocs/recordings/';
      $files  = scandir($dir);
      foreach ($result as $key => $value) 
      {
        $breakdown = $value->getKeys();
        if (!empty($breakdown['objectname'])){
            echo ' <div class="ui cards">
            <div class="card">
              <div class="content">
                <div class="header">'.$breakdown['objectname'].'</div>
                <div class="meta">Recordings</div>
                <div class="description">
                 ';
            $exist =0;
            foreach($files as $audio ){
                
                if(preg_match("/{$breakdown['objectname']}/i", $audio)) {
                    $exist =1;
                    echo '<audio controls>
                        <source src="/recordings/'.$audio.'" type="audio/wav">
                        Your browser does not support the audio element.
                        </audio><br>';
                }
            }
            if ($exist == 0) {
                echo ' <div class="ui message">
                <div class="header">
               No data found
              </div>
               
              </div>';
            }
            echo '          </div>
                        </div>
                    </div>
                </div>';
        }
      }
     
?>

</body>
</html>
