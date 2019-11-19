<?php
$req = $PDO->prepare('UPDATE users(username,password,email) SET username=:name, password=:hash, email=:email WHERE email=:email');