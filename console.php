<?php

require './Migration.php';
require './DB.php';

$migration = new Migration(DB::getInstance());
$migration->migrate();