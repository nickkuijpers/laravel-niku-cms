<?php

namespace Niku\Cms\Http\Controllers\Config;

use Illuminate\Support\Facades\Auth;
use Niku\Cms\Http\Controllers\ConfigController;
use Niku\Cms\Http\NikuConfig;

class ShowConfigController extends ConfigController
{
	/**
	 * Display a single post
	 */
	public function init($group)
	{
		// Lets validate if the post type exists and if so, continue.
		$postTypeModel = $this->getPostType($group);
		if(!$postTypeModel){
    		$errorMessages = 'You are not authorized to do this.';
    		return $this->abort($errorMessages);
    	}

		// Receiving the current data of the group
		$config = NikuConfig::where('group', '=', $group)
			->get()
			->keyBy('option_name')
			->toArray();

		$templates = $postTypeModel->templates;

		// Appending the key added in the config to the array
        // so we can use it very easliy in the component.
        foreach($templates as $key => $template){

	    	if(!empty($template['customFields'])){

	    		// For each custom fields
	            foreach($template['customFields'] as $ckey => $customField){
	                $templates[$key]['customFields'][$ckey]['id'] = $ckey;

	                // Adding the values to the result
	            	if(!empty($config[$ckey])){
	            		$templates[$key]['customFields'][$ckey]['value'] = $config[$ckey]['option_value'];
	            	}
	            }
	        }
	    }

		$collection = collect([
			'config' => $postTypeModel->config,
			'templates' => $templates,
		]);

		return response()->json($collection);
	}

}
