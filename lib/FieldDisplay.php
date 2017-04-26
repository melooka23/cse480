<?php

final class FieldDisplay extends Field {

    public function ShowField() {
        print $this->ReturnField();
    }

    public function ReturnField() {
        $html_string = "";
        $html_string .= '<div';
        if ($this->getStyle())
            $html_string = ' style="' . $this->getStyle() . '"';
        if ($this->getId())
            $html_string = ' id="' . $this->getId() . '"';    
        if ($this->getName())
            $html_string = ' name="' . $this->getName() . '"';
        if ($this->getOnClick())
            $html_string = ' onclick="' . $this->getOnClick() . '"';
        $html_string .= '>';
        $html_string .= $this->getValue();
        if ($this->getOutOther())
            $html_string .= $this->getOutOther();
        $html_string .= '</div>' . PHP_EOL;
        return $html_string;
    }

}
