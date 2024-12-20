<?php
    // If the lights button is pressed toggle the lights ON/OFF
    if (isset($_POST['lights']))
    {
      $light_val = trim(file_get_contents("lights.dat"));
      if ($light_val == 1) {
        $light_val = 0;
      } else {
        $light_val = 1;
      }
      $f = fopen("lights.dat",'w');
      fwrite($f, $light_val);
      fclose($f);
      $api_key = trim(file_get_contents("lights_api_key.dat"));

      $body = [
        "requestId" => "uuid", 
        "payload" => [
              "sku" => "H61A8", 
              "device" => "10:C4:35:33:30:34:16:FF", 
              "capability" => [
                  "type" => "devices.capabilities.on_off", 
                  "instance" => "powerSwitch", 
                  "value" => $light_val 
              ] 
            ] 
      ];
      $ch = curl_init('https://openapi.api.govee.com/router/api/v1/device/control');
      curl_setopt_array($ch, array(
          CURLOPT_POST => TRUE,
          CURLOPT_RETURNTRANSFER => TRUE,
          CURLOPT_HTTPHEADER => array(
              'Govee-API-Key: '.$api_key, 
              'Content-Type: application/json'
          ),
          CURLOPT_POSTFIELDS => json_encode($body)
      ));
      $response = curl_exec($ch); 
    }
    // If the ON button is pressed update the on_off state file with ON
    if (isset($_POST['button_off']))
    {
      $f = fopen("on_off.dat",'w');
      fwrite($f, strval(120));
      fclose($f);
    }
    // If the OFF button is pressed update the on_off state file with OFF
    if (isset($_POST['button_on']))
    {
      $f = fopen("on_off.dat",'w');
      fwrite($f, strval(FALSE));
      fclose($f);
    }
    // If the UP button is pressed increse the set point by 2 degress and write to disk
    if (isset($_POST['button_up']))
    {
      $f = fopen("set_point.dat", 'r');
      $temp = floatval(stream_get_line($f, 0));
      fclose($f);
      $temp = min(185, $temp + 5);
      $f = fopen("set_point.dat",'w');
      fwrite($f, $temp);
      fclose($f);
    }
    // If the DN button is pressed decrease the set point by 2 degress and write to disk
    if (isset($_POST['button_dn']))
    {
      $f = fopen("set_point.dat", 'r');
      $temp = floatval(stream_get_line($f, 0));
      fclose($f);
      $temp = max(70, $temp - 5);
      $f = fopen("set_point.dat",'w');
      fwrite($f, $temp);
      fclose($f);
    }
    /*
      Check to see if we are on or off.  If off turn off the relay.
      If on check to see if set point is above the current temp by at least 2 degrees.
      If so turn on the relay.
      If on but current temp is at least 2 degress above the set point turn off the relay
    */
    $f1 = fopen("on_off.dat", 'r');
    $on_off = boolval(stream_get_line($f1,0));
    $f2 = fopen("set_point.dat", 'r');
    $set_point = floatval(stream_get_line($f2, 0));
    $f3 = fopen("temp.dat", 'r');
    $temp = floatval(stream_get_line($f3, 0));
    if ($on_off) {
      if ($temp < $set_point - 1) {
        exec('sudo /usr/bin/python /home/sauna/www/sauna_pi_gpio_screen/rpi_on.py');
        $f4 = fopen("heater_status.dat", 'w');
        fwrite($f4, strval(TRUE));
        fclose($f4);
        // 28 and 29 are the other relays
      } elseif ($temp > $set_point + 1) {
        exec('sudo /usr/bin/python /home/sauna/www/sauna_pi_gpio_screen/rpi_off.py');
        $f4 = fopen("heater_status.dat", 'w');
        fwrite($f4, strval(FALSE));
        fclose($f4);
      };
    } else {
      exec('sudo /usr/bin/python /home/sauna/www/sauna_pi_gpio_screen/rpi_off.py');
      $f4 = fopen("heater_status.dat", 'w');
      fwrite($f4, strval(FALSE));
      fclose($f4);     
    }
    fclose($f1);
    fclose($f2);
    fclose($f3);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="refresh" content="10">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title>Sauna Controller</title>
<style rel="stylesheet" type="text/css">

@font-face {
    font-family: 'prototyperegular';
    src: url('prototype-webfont.woff2') format('woff2'),
         url('prototype-webfont.woff') format('woff'),
         url('prototype.ttf') format('truetype');
    font-weight: normal;
    font-style: normal;

}

.on_off_button {
  background-position: top center;
  background-repeat: no-repeat;
  width: 275px;
  height: 150px;
  border: 0px;
  font-family: 'prototyperegular', serif;
  font-size: 100px;
  padding: 3px 0 6px 0;
  cursor: hand;
  cursor: pointer;
  margin-left: auto;
  margin-right: auto;
}

.lights_button {
  background-position: top center;
  background-repeat: no-repeat;
  width: 100px;
  height: 100px;
  border: 0px;
  /* margin: 20px 20px 20px 20px; */
  cursor: hand;
  cursor: pointer;
  font-family: 'prototyperegular', serif;
  font-size: 60px;
  margin-left: auto;
  margin-right: auto;
  background:url('light-bulb.svg') center no-repeat;
  background-size: 100% 100%;
  background-color: #007f00;
  color: #ffffff;
}

.set_button {
  background-position: top center;
  background-repeat: no-repeat;
  width: 135px;
  height: 100px;
  border: 0px;
  margin: 20px 20px 20px 20px;
  /* padding: 10px 10px 10px 10px; */
  cursor: hand;
  cursor: pointer;
  font-family: 'prototyperegular', serif;
  font-size: 60px;
  margin-left: auto;
  margin-right: auto;
}

#off {
  /* background-color: #ff0000;
  color: #ffffff;  */
  background:url('off.jpg') center no-repeat;
  background-size: 100% 100%;
}

#on {
  /* background-color: #007f00;
  color: #ffffff;  */
  background:url('on_inactive.jpg') center no-repeat;
  background-size: 100% 100%;
}

#onactive {
  /* background-color: #007f00;
  color: #ffffff;  */
  background:url('on_active.jpg') center no-repeat;
  background-size: 100% 100%;
}

#up {
  /* background-color: #ff0000;
  color: #ffffff;  */
  background:url('up.svg') center no-repeat;
}

#dn {
  /* background-color: #0000ff;
  color: #ffffff;  */
  background:url('down.svg') center no-repeat;
}

.tempdata {
  font-size: 45;
  font-family: 'prototyperegular', serif;
  color: #ffffff; 
}

.body {
  background-color: black;
  text-align: left;  
  zoom: 130%;
}

</style>
</head>
<body class='body'>
  <div class="tempdata">
    Current: 
    <?php
      $f = fopen("temp.dat", 'r');
      $temp = floatval(stream_get_line($f, 0));
      fclose($f);
      echo $temp;
    ?> <br/>
    Setpoint:
    <?php
      $f = fopen("set_point.dat", 'r');
      $temp = floatval(stream_get_line($f, 0));
      fclose($f);
      echo $temp;
    ?> <br/>
  </div>
  <form method="post">
    <div>
      <button class="set_button" id="up" name="button_up" value="UP"></button>
      <button class="set_button" id="dn" name="button_dn" value="DN"></button>
      <br/>
      <?php
          $f1 = fopen("on_off.dat", 'r');
          $on_off = boolval(stream_get_line($f1,0));
          fclose($f1);
          // Old way of doing it: check the state of the output pin:
          // $state = exec('gpio read 25');
          // If ON show OFF button.  If OFF show ON button
          if ($on_off) {
            $f2 = fopen("heater_status.dat", 'r');
            $heater_active = boolval(stream_get_line($f2,0));
            fclose($f2);
            if ($heater_active) {
              echo('<button class="on_off_button" id="onactive" name="button_on" value="ON"></button>');
            } else {
              echo('<button class="on_off_button" id="on" name="button_on" value="ON"></button>');
            }
          } else {
            echo('<button class="on_off_button" id="off" name="button_off" value="OFF"></button>');
          }
      ?>
      <br/>
      <button class="lights_button" id="lights" name="lights" value="lights"></button>
      <br/>
      <br/>
      <a href="shutdown.php">SHUTDOWN</a>
    </div>
  </form>
</body>
</html>
