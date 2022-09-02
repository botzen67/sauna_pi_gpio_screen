<?php
    if (isset($_POST['button_on']))
    {
        exec('gpio write 25 1');
        exec('gpio mode 25 out');
        // exec('gpio write 28 1');
        // exec('gpio mode 28 out');
        // exec('gpio write 29 1');
        // exec('gpio mode 29 out');
    
    }
    if (isset($_POST['button_off']))
    {
        exec('gpio write 25 0');
        exec('gpio mode 25 out');
        // exec('gpio write 28 0');
        // exec('gpio mode 28 out');
        // exec('gpio write 29 0');
        // exec('gpio mode 29 out');
    }
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="refresh" content="10">
<title>Sauna Controller</title>
<style rel="stylesheet" type="text/css">
.button {
  background-position: top center;
  background-repeat: no-repeat;
  width: 275px;
  height: 200px;
  border: 0px;
  margin: 7px 0 5px 7px;
  padding: 3px 0 6px 0;
  cursor: hand;
  cursor: pointer;
  font-family: Tahoma;
  font-size: 50px;
}
#b1c {
  background-color: #ff0000;
  background: url(off.jpg) no-repeat;
  color: #0000ff; 
}
#b2c {
  background-color: #00ff00;
  background: url(on.jpg) no-repeat;
  color: #ff0000; 
}
#b3c {
  background-color: #ff0000;
  color: #ffffff; 
}
#b4c {
  background-color: #008000;
  color: #ffffff; 
}
</style>
</head>
<body bgcolor="#000000">
    <form method="post">
    <p align=left>
    <?php
        $state = exec('gpio read 25');
        if ($state) {
        echo('<button class="button" id="b3c" name="button_off" value="OFF">OFF</button>');
        } else {
        echo('<button class="button" id="b4c" name="button_on" value="ON">ON</button>');
        }
    ?>
    </p>
    </form>
</body>
</html>
