<?php

return array(

    'load_paths' => glob(app_path() . '/assets/*'),

    'cache_path' => base_path() . '/.asset_cache',

    'public_path' => public_path() . '/assets',

    'manifest_path' => storage_path() .'/meta/assets.json',

    'public_url' => 'assets'

);