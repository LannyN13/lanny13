<?php
session_start();
session_destroy();
header("Location: ../auth1/login.php");
