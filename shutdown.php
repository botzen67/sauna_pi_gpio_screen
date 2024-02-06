<?php
    if (isset($_POST['shutdown_button']))
    {
      exec('sudo /var/www/html/shutdown.sh');
    }
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title>Sauna Shutdown</title>
<style rel="stylesheet" type="text/css">

@font-face {
    font-family: 'prototyperegular';
    src: url('prototype-webfont.woff2') format('woff2'),
         url('prototype-webfont.woff') format('woff'),
         url('prototype.ttf') format('truetype');
    font-weight: normal;
    font-style: normal;

}

.shutdown_button {
  background-position: top center;
  background-repeat: no-repeat;
  width: 300px;
  height: 150px;
  border: 0px;
  font-family: 'prototyperegular', serif;
  font-size: 50px;
  padding: 3px 0 6px 0;
  cursor: hand;
  cursor: pointer;
  margin-left: auto;
  margin-right: auto;
}

.body {
  background-color: black;
  text-align: left;  
  font-size: 35;
  font-family: 'prototyperegular', serif;
  color: #ffffff; 
}

</style>
</head>
<body class='body'>
  <form method="post">
    <div>
      <button class="shutdown_button" id="shutdown_button" name="shutdown_button" value="shutdown_button">SHUTDOWN!</button>
    </div>
  </form>
</body>
</html>
