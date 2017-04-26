<?php

final class FieldEMR extends Field {

    public function ShowField() {
        print $this->ReturnField();
    }

    public function ReturnField() {
        $html_string = "";
        $html_string .= '<div';
        if ($this->getStyle())
            $html_string .= ' style="' . $this->getStyle() . '"';
        if ($this->getId()){
            $html_string .= ' id="' . $this->getId() . 'display"';    
            $html_string .= ' onclick="changeColor' . $this->getId() . '();"';
        }
        $html_string .= '>';
        $html_string .= $this->getValue();
        if ($this->getOutOther())
            $html_string .= $this->getOutOther();
        
        
        
        
        $html_string .= '<input type="hidden" ';
        if ($this->getId()) {
            $html_string .= 'id="' . $this->getId() . '" ';
        }
        if ($this->getName()) {
            $html_string .= 'name="' . $this->getName() . '" ';
        }
        if ($this->getValue() !== null) {
            $html_string .= 'value ="Not Asked" ';
        }
        $html_string .= '>';
        
        $html_string .= '</div>' . PHP_EOL;
        
        $html_string .= '<script>';
        
        $html_string .= "function changeColor" . $this->getId() . "(){" . PHP_EOL;
        $html_string .= "var currColor =  document.getElementById('" .  $this->getId() . "display').style.color;" . PHP_EOL;
        $html_string .= "switch(currColor) {
                            case 'black':
                              document.getElementById('" . $this->getId() . "display').style.color = 'green';
                              document.getElementById('" . $this->getId() . "').value = 'Yes';
                           break;
                            case 'green':
                              document.getElementById('" . $this->getId() . "display').style.color = 'red';
                              document.getElementById('" . $this->getId() . "display').style.textDecoration = 'line-through';
                              document.getElementById('" . $this->getId() . "').value = 'No';
                            break;
                            case 'red':
                              document.getElementById('" . $this->getId() . "display').style.color = 'black';
                              document.getElementById('" . $this->getId() . "display').style.textDecoration = 'none';
                              document.getElementById('" . $this->getId() . "').value = 'Not Asked';
                            break;
                            default:
                            document.getElementById('" . $this->getId() . "display').style.color = 'black';
                            document.getElementById('" . $this->getId() . "display').style.textDecoration = 'none';
                            document.getElementById('" . $this->getId() . "').value = 'Not Asked';
                            }
                            }";
        
        $html_string .= '</script>';
        
        return $html_string;
    }

}