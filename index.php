<?php
    if (isset($_POST['button_on']))
    {
      $f = fopen("on_off.dat",'w');
      fwrite($f, strval(TRUE));
      fclose($f);
    }
    if (isset($_POST['button_off']))
    {
      $f = fopen("on_off.dat",'w');
      fwrite($f, strval(FALSE));
      fclose($f);
    }
    if (isset($_POST['button_up']))
    {
      $f = fopen("set_point.dat", 'r');
      $temp = floatval(stream_get_line($f, 0));
      fclose($f);
      $temp = min(130, $temp + 2);
      $f = fopen("set_point.dat",'w');
      fwrite($f, $temp);
      fclose($f);
    }
    if (isset($_POST['button_dn']))
    {
      $f = fopen("set_point.dat", 'r');
      $temp = floatval(stream_get_line($f, 0));
      fclose($f);
      $temp = max(50, $temp - 2);
      $f = fopen("set_point.dat",'w');
      fwrite($f, $temp);
      fclose($f);
    }
    $f1 = fopen("on_off.dat", 'r');
    $on_off = boolval(stream_get_line($f1,0));
    $f2 = fopen("set_point.dat", 'r');
    $set_point = floatval(stream_get_line($f2, 0));
    $f3 = fopen("temp.dat", 'r');
    $temp = floatval(stream_get_line($f3, 0));
    if ($on_off) {
      if ($temp < $set_point - 2) {
        exec('gpio write 25 1');
        exec('gpio mode 25 out');
        // 28 and 29 are the other relays
      } elseif ($temp > $set_point + 2) {
        exec('gpio write 25 0');
        exec('gpio mode 25 out');    
      };
    } else {
      exec('gpio write 25 0');
      exec('gpio mode 25 out');      
    }
    fclose($f1);
    fclose($f2);
    fclose($f3);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="refresh" content="10">
<title>Sauna Controller</title>
<style rel="stylesheet" type="text/css">
.on_off_button {
  background-position: top center;
  background-repeat: no-repeat;
  width: 275px;
  height: 200px;
  border: 0px;
  /* margin: 7px 0 5px 7px; */
  padding: 3px 0 6px 0;
  cursor: hand;
  cursor: pointer;
  font-family: 'Ariel';
  font-size: 50px;
  margin-left: auto;
  margin-right: auto;
}

.set_button {
  background-position: top center;
  background-repeat: no-repeat;
  width: 135px;
  height: 100px;
  border: 0px;
  margin: 20px 20px 20px 20px;
  padding: 10px 10px 10px 10px;
  cursor: hand;
  cursor: pointer;
  font-family: 'Ariel';
  font-size: 50px;
  margin-left: auto;
  margin-right: auto;
}

#off {
  background-color: #ff0000;
  color: #ffffff; 
}

#on {
  background-color: #007f00;
  color: #ffffff; 
}

#up {
  background-color: #ffa500;
  color: #ffffff; 
}

#dn {
  background-color: #0000ff;
  color: #ffffff; 
}

.tempdata {
  font-size: 40;
  font-family: sans-serif;
  color: #ffffff; 
  text-align: center;
}

</style>
</head>
<body bgcolor="black">

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
    <div align=center>
      <button class="set_button" id="up" name="button_up" value="UP">UP</button>
      <button class="set_button" id="dn" name="button_dn" value="DN">DN</button>
      <br/>
      <?php

          $f1 = fopen("on_off.dat", 'r');
          $on_off = boolval(stream_get_line($f1,0));
          fclose($f1);
          // $state = exec('gpio read 25');
          if ($on_off) {
          echo('<button class="on_off_button" id="off" name="button_off" value="OFF">OFF</button>');
          } else {
          echo('<button class="on_off_button" id="on" name="button_on" value="ON">ON</button>');
          }
      ?>
    </div>
  </form>
</body>
</html>
