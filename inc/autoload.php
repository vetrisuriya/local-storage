<?php
spl_autoload_register(function($class) {
    require("./class/".lcfirst($class).".php");
});
?>