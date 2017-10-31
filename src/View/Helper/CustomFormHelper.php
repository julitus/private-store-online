<?php
// extended FormHelper, this goes in src/View/Helper
namespace App\View\Helper;

use Cake\View\Helper;

class CustomFormHelper extends Helper\FormHelper
{
	public function create($context = null, array $options = []) {
    	
    	$options['templates'] = ['inputContainer' => '<div class="form-group">{{content}}</div>'];
    	return parent::create($context, $options);
    }

    public function input($fieldName, array $options = []) 
    {
        if (!isset($options['escape'])) {
            $options['escape'] = false;
        }
        return parent::input($fieldName, $options);
    }
}