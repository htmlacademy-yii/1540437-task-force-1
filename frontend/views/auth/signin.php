<?php

use frontend\widgets\WSignin;

echo WSignin::widget(['isRemoteLogin' => false, 'model' => $model]);
