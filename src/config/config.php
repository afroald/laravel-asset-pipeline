<?php

return array(

    'load_paths' => glob(app_path() . '/assets/*'),

    'public_path' => public_path() . '/assets',

    'manifest_path' => storage_path() .'/meta',

    'public_url' => 'assets'

);