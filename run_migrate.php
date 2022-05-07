<?php

require './db/Migration.php';
require './db/DB.php';

$migration = new Migration(DB::getInstance());
$migration->migrate();