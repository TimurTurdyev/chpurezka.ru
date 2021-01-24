<?php
namespace App\Admin\FormFields;

use TCG\Voyager\FormFields\AbstractHandler;

class JsonTableFieldHandler extends AbstractHandler
{
    protected $codename = 'json_table_field';
    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
        return view('voyager::formfields.json_table_field', [
            'row'             => $row,
            'options'         => $options,
            'dataType'        => $dataType,
            'dataTypeContent' => $dataTypeContent,
        ]);
    }
}