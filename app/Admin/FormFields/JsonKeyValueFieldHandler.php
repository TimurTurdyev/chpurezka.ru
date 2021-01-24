<?php


namespace App\Admin\FormFields;

use TCG\Voyager\FormFields\AbstractHandler;

class JsonKeyValueFieldHandler extends AbstractHandler
{
    protected $codename = 'json_key_value_field';

    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
        return view('voyager::formfields.json_key_value_field', [
            'row' => $row,
            'options' => $options,
            'dataType' => $dataType,
            'dataTypeContent' => $dataTypeContent,
        ]);
    }
}