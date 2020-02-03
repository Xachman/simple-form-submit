<?php

namespace App;

class Form {
    private $inputs = [];
    private $form;
    public function __construct() {
        $this->form = new \SimplePHPForm(); 
    }
    public function addInput($type, $name, $data, $array, $label, $help, $error){
        $this->form->Add($type, $name, $data, $array, $label, $help, $error);
        
        $this->inputs[$name] = [
            'type' => $type,
            'name' => $name,
            'data' => $data,
            'data_validation_flags' => $array,
            'label' => $label,
            'help' => $help,
            'error' => $error
        ];
        
        $this->assembleValues();
    }

    public function get($name) {
        return $this->inputs[$name]['value'];
    }

    public function validate() {
        return $this->form->Validate();
    }

    public function displayJSONErrors() {
        return $this->form->DisplayJSONErrors();
    }

    private function assembleValues() {
        foreach($_POST as $key => $value) {
            foreach($this->inputs as $iKey => $iValues) {
                if($key == 'simplephpform_'.$iKey) {
                    $this->inputs[$iKey]['value'] = $value;
                }
            }
        }
    }
}