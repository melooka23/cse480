<?php

class Field {

//MEG - TODO - Add title (works as mouseover)
    //GLOBAL Attributes
    protected $class;
    protected $id;
    protected $style;
    protected $title;
    //INPUT ATTRIBUTES
    protected $disabled;
    protected $list; //for using html5 datalsit
    protected $max; //works with number and date past i.e. 10, only called from peer review
    protected $maxlength;
    protected $min;  //works with number and date past i.e. 10, only called from peer review
    protected $name;
    protected $placeholder; //textarea text number etc.
    protected $readonly;  //textarea and text
    protected $size;
    //type - not included:
    //SUPPORTED Types:  checkbox radio submit text  hidden image
    //CURRENTLY UNSUPPORTED TYPES:   tel time url  week   range  reset search  password number  month  color date  datetime  datetime-local  email  file
    protected $value;
    //CUSTOM Fields
    protected $label;
    protected $mandatory;
    protected $validation; //all
    protected $in_other; //other
    protected $out_other; //all
    protected $help_path; //all - MEG thing, not html
    protected $onchange;
    protected $onfocus;
    protected $onblur;

    public function setClass($class) {
        $this->class = $class;
    }

    public function getClass() {
        return $this->class;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function setStyle($style) {
        $this->style = $style;
    }

    public function getStyle() {
        return $this->style;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setReadonly($readonly) {
        $this->readonly = $readonly;
    }

    public function getReadonly() {
        return $this->readonly;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }

    public function setDisabled($disabled) {
        $this->disabled = $disabled;
    }

    public function getDisabled() {
        return $this->disabled;
    }

    public function setValue($value) {
        $this->value = $value;
    }

    public function getValue() {
        return $this->value;
    }

    public function setLabel($label) {
        $this->label = $label;
    }

    public function getLabel() {
        return $this->label;
    }

    public function setAccess($access) {
        $this->access = $access;
    }

    public function getAccess() {
        return $this->access;
    }

    public function setMandatory($mandatory) {
        $this->mandatory = $mandatory;
    }

    public function getMandatory() {
        return $this->mandatory;
    }

    public function setSize($size) {
        $this->size = $size;
    }

    public function getSize() {
        return $this->size;
    }

    public function setMaxLength($maxlength) {
        $this->maxlength = $maxlength;
    }

    public function getMaxLength() {
        return $this->maxlength;
    }

    public function setValidation($validation) {
        $this->validation = $validation;
    }

    public function getValidation() {
        return $this->validation;
    }

    public function setOutOther($out_other) {
        $this->out_other = $out_other;
    }

    public function getOutOther() {
        return $this->out_other;
    }

    public function setPlaceholder($placeholder) {
        $this->placeholder = $placeholder;
    }

    public function getPlaceholder() {
        return $this->placeholder;
    }

    public function setHelpPath($help_path) {
        $this->help_path = $help_path;
    }

    public function getHelpPath() {
        return $this->help_path;
    }

    public function setMin($min) {
        $this->min = $min;
    }

    public function getMin() {
        return $this->min;
    }

    public function setMax($Max) {
        $this->max = $Max;
    }

    public function getMax() {
        return $this->max;
    }

    public function setList($list) {
        $this->list = $list;
    }

    public function getList() {
        return $this->list;
    }

    public function setOnChange($onchange) {
        $this->onchange = $onchange;
    }

    public function getOnChange() {
        return $this->onchange;
    }

    public function setOnFocus($onfocus) {
        $this->onfocus = $onfocus;
    }

    public function getOnFocus() {
        return $this->onfocus;
    }

    public function setOnBlur($onblur) {
        $this->onblur = $onblur;
    }

    public function getOnBlur() {
        return $this->onblur;
    }

}
