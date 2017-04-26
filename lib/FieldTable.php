<?php

final class FieldTable extends Field {

    protected $table_sort = 1;
    protected $nav;
    protected $nav_field;
    protected $hidden_first_row;
    protected $new_window;

    public function ShowField() {
        print $this->ReturnField();
    }

    public function ReturnField() {
        $html_string = "";
        if ($this->getLabel()) {
            $html_string .= '<label class="col-lg-8 control-label">' . $this->getLabel() . '</label>';
        }
        //if ($this->GetTableSort() !== 0 && $this->getId()) {
            // $html_string .= '<script>';
            // $html_string .= '$(document).ready(function(){';
            // $html_string .= '$("#' . $this->getId() . '").tablesorter({';
            // $html_string .= 'widgets: ["zebra"], widgetZebra: { css: [ "alt", "" ] }';
            // $html_string .= '});});';
            // $html_string .= '</script>';
        //}
        if ($this->getClass()) {
            $html_string .= '<div class="' . $this->getClass() . '">';
        }
        if (is_array($this->getValue())) {
            $html_string .= '<table ';
            if ($this->getId()) {
                $html_string .= 'id="' . $this->getId() . '" ';
            }
            if ($this->getName()) {
                $html_string .= 'name="' . $this->getName() . '" ';
            }
            $html_string .= ' class="table table-hover">';
            $html_string .= '<thead>';
            $html_string .= PHP_EOL;
            $html_string .= '<tr>';

            foreach ($this->getValue() as $row) {
                foreach ($row as $field => $value) {
                    $html_string .= '<th>' . $field . '</th>';
                }
                break;
            }
            $html_string .= '</tr>';
            $html_string .= '</thead>';
            $html_string .= '<tbody';
            if ($this->getStyle()) {
                $html_string .= ' style="' . $this->getStyle() . '"';
            }
            $html_string .= '>';
            $first = 1;
            foreach ($this->getValue() as $rowid => $row) {
                $html_string .= PHP_EOL;
                $html_string .= '<tr ';
                if ($this->getHiddenFirstRow() && $first == 1) {
                    $first = 0;
                    $html_string .= 'style="display: none;" ';
                }
                if ($this->getNav() || $this->getNavField()) {
                    $html_string .= 'onclick="DoNav(\'';
                    if ($this->getNav()) {
                        $html_string .= $this->getNav();
                    }
                    if ($this->getNavField()) {
                        $html_string .= $row[$this->getNavField()];
                    }
                    if (substr($this->getNav(), -1) === '=') {
                        $html_string .= $rowid;
                    }
                    if ($this->getNewWindow()) {
                        $html_string .= '\', \'new_window';
                    }
                    $html_string .= '\')"';
                }
                $html_string .= '>';
                foreach ($row as $value) {
                    $html_string .= '<td>' . $value . '</td>';
                }
                $html_string .= '</tr>';
            }
            $html_string .= PHP_EOL;
            $html_string .= '</tbody>';
            $html_string .= '<tfoot>';
            $html_string .= '</tfoot>';
            $html_string .= '</table>';
        } else {
            $html_string .= "No Records Found";
        }
        if ($this->getClass()) {
            $html_string .= '</div>';
        }
        return $html_string;
    }

    public function setTableSort($table_sort) {
        $this->table_sort = $table_sort;
    }

    public function getTableSort() {
        return $this->table_sort;
    }

    public function setNav($nav) {
        $this->nav = $nav;
    }

    public function getNav() {
        return $this->nav;
    }

    public function setNavField($nav_field) {
        $this->nav_field = $nav_field;
    }

    public function getNavField() {
        return $this->nav_field;
    }

    public function setNewWindow($new_window) {
        $this->new_window = $new_window;
    }

    public function getNewWindow() {
        return $this->new_window;
    }

    public function setHiddenFirstRow($hidden_first_row) {
        $this->hidden_first_row = $hidden_first_row;
    }

    public function getHiddenFirstRow() {
        return $this->hidden_first_row;
    }

}
