<?php
session_start();
if (isset($_GET['requested'])) {
    // return requested value
    print json_encode($_SESSION[$_GET['requested']]);
} else {
    // nothing requested, so return all values
    print json_encode($_SESSION);
}
?>