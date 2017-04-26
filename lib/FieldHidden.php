<?php

final class FieldHidden extends Field {

    public function ShowField() {
        print $this->ReturnField();
    }

    public function ReturnField() {
        $html_string = '<input type="hidden" ';
        if ($this->getId()) {
            $html_string .= 'id="' . $this->getId() . '" ';
        }
        if ($this->getName()) {
            $html_string .= 'name="' . $this->getName() . '" ';
        }
        if ($this->getValue() !== null) {
            $html_string .= 'value ="' . $this->getValue() . '" ';
        }
        $html_string .= '>' . PHP_EOL;
        return $html_string;
    }

}
