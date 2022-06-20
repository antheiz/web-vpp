<?php 

require_once "core/init.php";

unset($_SESSION['username']);
Redirect::to('index');