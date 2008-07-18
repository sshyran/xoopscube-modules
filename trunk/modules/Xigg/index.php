<?php
require '../../mainfile.php';
require './common.php';
require sprintf('%s/modules/%s/index.php', XOOPS_TRUST_PATH, $module_name);