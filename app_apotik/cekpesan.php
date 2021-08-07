<?php
session_start();
?>

<script language="javascript">
  function audio() {
    var audio = new Audio('');
    audio.play();
  }
</script>

<script>
  function notifyMe() {
    // Let's check if the browser supports notifications
    if (!("Notification" in window)) {
      alert("This browser does not support desktop notification");
    }

    // Let's check if the user is okay to get some notification
    else if (Notification.permission === "granted") {
      // If it's okay let's create a notification
      var options = {
        body: "This is the body of the notification",
        icon: "icon.jpg",
        dir: "ltr"
      };
      var notification = new Notification("Hi there", options);
    }

    // Otherwise, we need to ask the user for permission
    // Note, Chrome does not implement the permission static property
    // So we have to check for NOT 'denied' instead of 'default'
    else if (Notification.permission !== 'denied') {
      Notification.requestPermission(function(permission) {
        // Whatever the user answers, we make sure we store the information
        if (!('permission' in Notification)) {
          Notification.permission = permission;
        }

        // If the user is okay, let's create a notification
        if (permission === "granted") {
          var options = {
            body: "This is the body of the notification",
            icon: "icon.jpg",
            dir: "ltr"
          };
          var notification = new Notification("Hi there", options);
        }
      });
    }

    // At last, if the user already denied any notification, and you
    // want to be respectful there is no need to bother them any more. AND waktu_registrasi = '$dateNow'
  }
</script>

<?php

include_once "library/inc.connection.php";
include_once "library/inc.library.php";

$dateNow = date("Y-m-d");

$pageSql = "SELECT * FROM order_obat_komp WHERE status_order = '1' AND status_racik ='0'";
$pageQry = mysql_query($pageSql, $koneksidb) or die("error paging: " . mysql_error());
$j    = mysql_num_rows($pageQry);


if ($j > 0) {
  echo $j;
  echo '<script type="text/javascript">audio();</script>';
} else if ($j == 0) {
  echo 0;
}
?>