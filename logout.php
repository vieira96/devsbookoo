<?php

require 'config.php';

session_destroy();
header("Location: ".$base);
exit;