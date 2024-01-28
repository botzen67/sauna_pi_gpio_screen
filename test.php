<?php
    // If the ON button is pressed update the on_off state file with ON
    if (isset($_POST['button_off']))
    {
      $f = fopen("on_off_test.dat",'w');
      fwrite($f, strval(TRUE));
      fclose($f);
    }
    // If the OFF button is pressed update the on_off state file with OFF
    if (isset($_POST['button_on']))
    {
      $f = fopen("on_off_test.dat",'w');
      fwrite($f, strval(FALSE));
      fclose($f);
    }
    /*
      Check to see if we are on or off.  If off turn off the relay.
      If on check to see if set point is above the current temp by at least 2 degrees.
      If so turn on the relay.
      If on but current temp is at least 2 degress above the set point turn off the relay
    */
    $f1 = fopen("on_off_test.dat", 'r');

    $on_off = boolval(stream_get_line($f1,0));
     if ($on_off) {
        exec('gpio write 22 1');
        exec('gpio mode 22 out');
        // exec('gpio write 25 1');
        // exec('gpio mode 25 out');
        // exec('gpio write 28 1');
        // exec('gpio mode 28 out');
        // exec('gpio write 29 1');
        // exec('gpio mode 29 out');
    } else {
        exec('gpio write 22 0');
        exec('gpio mode 22 out');
        // exec('gpio write 25 0');
        // exec('gpio mode 25 out');
        // exec('gpio write 28 0');
        // exec('gpio mode 28 out');
        // exec('gpio write 29 0');
        // exec('gpio mode 29 out');
    }
    fclose($f1);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
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
  background:url('on.jpg') center no-repeat;
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
  text-align: center;  
}

</style>
</head>
<body class='body'>
  <form method="post">
    <div>
      <?php
          exec('gpio write 28 1');
          $f1 = fopen("on_off_test.dat", 'r');
          $on_off = boolval(stream_get_line($f1,0));
          fclose($f1);
          // Old way of doing it: check the state of the output pin:
          // $state = exec('gpio read 25');
          // If ON show OFF button.  If OFF show ON button
          if ($on_off) {
            echo('<button class="on_off_button" id="on" name="button_on" value="ON"></button>');
          } else {
            echo('<button class="on_off_button" id="off" name="button_off" value="OFF"></button>');
          }
      ?>
    </div>
  </form>
</body>
</html>
