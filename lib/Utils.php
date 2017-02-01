<?php

final class Utils {

    public static function createLink($controller, $action, array $params = array()) {
        $params = array_merge(array('controller' => $controller), $params);
        $params = array_merge(array('action' => $action), $params);
        return 'index.php?' . http_build_query($params);
    }

    public static function objectSort($objectarray, $field) {
        for ($a = 0; $a < (count($objectarray)); $a++) {
            for ($b = 0; $b < (count($objectarray)); $b++) {
                $value_a = call_user_func(array($objectarray[$a], $field));
                $value_b = call_user_func(array($objectarray[$b], $field));
                if ($value_a < $value_b) {
                    $temp = $objectarray[$a];
                    $objectarray[$a] = $objectarray[$b];
                    $objectarray[$b] = $temp;
                }
            }
        }
        return $objectarray;
    }

    public static function CompareDates($date1, $date2) {

        $f_date1 = strtotime($date1);
        $f_date2 = strtotime($date2);


        if ($f_date1 > $f_date2) {
            return 1;
        } else if ($f_date2 > $f_date1) {
            return 2;
        }
//they are equal
        return 0;
    }

    public static function formatDate(DateTime $date = null) {
        if ($date === null) {
            return '';
        }
        return $date->format('m/d/Y');
    }

    public static function formatDateTime(DateTime $date = null) {
        if ($date === null) {
            return '';
        }
        return $date->format('m/d/Y H:i');
    }

    public static function redirect($controller, $action, array $params = array()) {
        header('Location: ' . self::createLink($controller, $action, $params));
        die();
    }

    public static function getUrlParam($name) {
        if (!array_key_exists($name, $_GET)) {
            throw new Exception('URL parameter "' . $name . '" not found.');
        }
        return $_GET[$name];
    }

    public static function capitalize($string) {
        return ucfirst(strtolower($string));
    }

    public static function escape($string) {
        return htmlspecialchars($string, ENT_QUOTES);
    }

    public static function isValidEmail($email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            return false;
        } else {
            return true;
        }
    }

    public static function isValidDate($date) {
        if (strtotime($date) === false) {
            return false;
        } else {
            return true;
        }
    }

    public static function isValidPhone($phone) {
        if (preg_match('/^[+]?([\d]{0,3})?[\(\.\-\s]?([\d]{3})[\)\.\-\s]*([\d]{3})[\.\-\s]?([\d]{4})$/', $phone)) {
            return true;
        } else {
            return false;
        }
    }

    public static function isalpha($subject, $other = "") {
        $pattern = '/^[A-Z' . $other . ']*$/i';
        if (preg_match($pattern, $subject)) {
            return true;
        } else {
            return false;
        }
    }

    public static function isalphanum($subject, $other = "") {
        $pattern = '/^[A-Z0-9' . $other . ']*$/i';
        if (preg_match($pattern, $subject)) {
            return true;
        } else {
            return false;
        }
    }

    public static function isPositiveRealNum($subject) {
        if (is_numeric($subject) && $subject >= 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function titalize($name) {
        $name = preg_filter("/^.*\[(.*)].*$/", "$1", trim($name));
        $name = str_replace("_fk", "", $name);
        $name = str_replace('_', ' ', $name);
        $length = strlen($name);
        if ($length > 1) {
            $name[0] = strtoupper($name[0]);
            for ($i = 0; $i < $length; $i++) {
                if ($name[$i] == ' ') {
                    $name[$i + 1] = strtoupper($name[$i + 1]);
                }
            }
            return $name;
        }
    }

    public static function camelCase($var) {
        $names = explode("_", $var);
        $subnames = array();
        foreach ($names as $name) {
            if ($name == "id" || $name == "fk") {
                $subnames[] = strtoupper($name);
            } else {
                $subnames[] = self::capitalize($name);
            }
        }

        return implode("", $subnames);
    }

    public static function getDateFromDay($day, $dayDesired = 'Sunday') {
//       if (!array_search(ucfirst($dayDesired), \Constants::$WEEKDAYS)) {
//           return $day;
//       }

        return date('Y-m-d', strtotime($day . '-' . date('w', strtotime($day)) . ' days'));
    }

    public static function logToClientConsole($message) {
        echo "<script type='text/javascript'>" .
        "(function(){" .
        "console = console || {log: function(){}};" .
        "console.log(\"" . $message . "\")" .
        "})();" .
        "</script>";
    }

    public static function cleanData(&$str) {
        $str = preg_replace("/\t/", "\\t", $str);
        $str = preg_replace("/\r?\n/", "\\n", $str);
    }

    public static function selectYears($selected = "") {
        $min = 1950;
        $high = date("Y");
        $options = "<option value=''>-- Please Select --</option>";

        for ($year = $high; $year >= $min; $year--) {
            $options .= "<option";
            if ($selected == $year)
                $options .= " selected='TRUE'";
            $options .= ">" . $year . "</option>";
        }
        return $options;
    }

    public static function selectState($selected, $mode) {
        $options = "<option value=''>-- Please Select --</option>";
        $array = array();

        $array[] = array('AL', 'Alabama');
        $array[] = array('AK', 'Alaska');
        $array[] = array('AZ', 'Arizona');
        $array[] = array('AR', 'Arkansas');
        $array[] = array('CA', 'California');
        $array[] = array('CO', 'Colorado');
        $array[] = array('CT', 'Connecticut');
        $array[] = array('DE', 'Delaware');
        $array[] = array('DC', 'Dist of Columbia');
        $array[] = array('FL', 'Florida');
        $array[] = array('GA', 'Georgia');
        $array[] = array('HI', 'Hawaii');
        $array[] = array('ID', 'Idaho');
        $array[] = array('IL', 'Illinois');
        $array[] = array('IN', 'Indiana');
        $array[] = array('IA', 'Iowa');
        $array[] = array('KS', 'Kansas');
        $array[] = array('KY', 'Kentucky');
        $array[] = array('LA', 'Louisiana');
        $array[] = array('ME', 'Maine');
        $array[] = array('MD', 'Maryland');
        $array[] = array('MA', 'Massachusetts');
        $array[] = array('MI', 'Michigan');
        $array[] = array('MN', 'Minnesota');
        $array[] = array('MS', 'Mississippi');
        $array[] = array('MO', 'Missouri');
        $array[] = array('MT', 'Montana');
        $array[] = array('NE', 'Nebraska');
        $array[] = array('NV', 'Nevada');
        $array[] = array('NH', 'New Hampshire');
        $array[] = array('NJ', 'New Jersey');
        $array[] = array('NM', 'New Mexico');
        $array[] = array('NY', 'New York');
        $array[] = array('NC', 'North Carolina');
        $array[] = array('ND', 'North Dakota');
        $array[] = array('OH', 'Ohio');
        $array[] = array('OK', 'Oklahoma');
        $array[] = array('OR', 'Oregon');
        $array[] = array('PA', 'Pennsylvania');
        $array[] = array('RI', 'Rhode Island');
        $array[] = array('SC', 'South Carolina');
        $array[] = array('SD', 'South Dakota');
        $array[] = array('TN', 'Tennessee');
        $array[] = array('TX', 'Texas');
        $array[] = array('UT', 'Utah');
        $array[] = array('VT', 'Vermont');
        $array[] = array('VA', 'Virginia');
        $array[] = array('WA', 'Washington');
        $array[] = array('WV', 'West Virginia');
        $array[] = array('WI', 'Wisconsin');
        $array[] = array('WY', 'Wyoming');
        $array[] = array('AS', 'American Samoa');
        $array[] = array('GU', 'Guam');
        $array[] = array('MP', 'Northern Mariana Islands');
        $array[] = array('PR', 'Puerto Rico');
        $array[] = array('VI', 'Virgin Islands');

        foreach ($array as $pair) {
            if ($mode == 0) {
                $options .= '<option ';
                if (($selected == $pair[0]) || ($selected == $pair[1]))
                    $options .= 'selected="TRUE" ';
                $options .= '>' . $pair[0] . '</option>';
            } else {
                $options .= '<option ';
                if (($selected == $pair[1]) || ($selected == $pair[0]))
                    $options .= 'selected="TRUE" ';
                $options .= '>' . $pair[1] . '</option>';
            }
        }
        return $options;
    }

}

?>