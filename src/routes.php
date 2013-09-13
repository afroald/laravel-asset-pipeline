<?php

Route::get('assets/{name}', array('uses' => 'Afroald\AssetPipeline\Controllers\AssetController@fetchAsset',
                                    'as' => 'assets'))
->where('name', '[\s\S]+');