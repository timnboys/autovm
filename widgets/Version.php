<?php

namespace app\widgets;

use Yii;
use yii\base\Widget;

class Version extends Widget
{
    public function run()
    {
        $current = @file_get_contents(Yii::getAlias('@app/config/version.php'));
        $new = $current + 1;

        $path = "http://update.autovm.net/news/$new.zip";

        $content = @file_get_contents($path);

        if ($content) {
            $update = true;
        } else {
            $update = false;
        }

        return $this->render('version', compact('current', 'new', 'update'));
    }
}