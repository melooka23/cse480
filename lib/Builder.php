<?php

Class Builder {

  protected $_query = '';
  protected $_where = array();
  protected $_parameters = array();
  protected $_bindings = array();

  public function where($col, $val, $op) {
    return call_user_func_array(array($this, 'and_where'), func_get_args());
  }

  public function and_where($col, $op = "=", $value = null) {

    if ($col instanceof \Closure) {
      $this->and_where_open();
      $col($this);
      $this->and_where_close();
      return $this;
    }
    if (is_array($col)) {

      foreach ($col as $key => $val) {

        if (is_array($val)) {

          $this->and_where($val[0], $val[1], $val[2]);
        } else {
          $this->and_where($key, '=', $val);
        }
      }
    } else {
      if (func_num_args() === 2) {
        $value = $op;
        $op = '=';
      }
      $this->_where[] = array('AND' => array($col, $op, $value));
    }

    return $this;
  }

  public function or_where($col, $op = '=', $value = null) {
    if ($col instanceof \Closure) {
      $this->or_where_open();
      $col($this);
      $this->or_where_close();
      return $this;
    }
    if (is_array($col)) {

      foreach ($col as $key => $val) {

        if (is_array($val)) {

          $this->or_where($val[0], $val[1], $val[2]);
        } else {
          $this->or_where($key, '=', $val);
        }
      }
    } else {
      if (func_num_args() === 2) {
        $value = $op;
        $op = '=';
      }
      $this->_where[] = array('OR' => array($col, $op, $value));
    }

    return $this;
  }

  public function and_where_open() {
    $this->_where[] = array('AND' => '(');

    return $this;
  }

  public function and_where_close() {
    $this->_where[] = array('AND' => ')');

    return $this;
  }

  public function or_where_open() {
    $this->_where[] = array('OR' => '(');

    return $this;
  }

  public function or_where_close() {
    $this->_where[] = array('OR' => ')');

    return $this;
  }

  public function compile() {
    if (!empty($this->_where)) {
      $this->_query .= ' WHERE ' . $this->compile_conditions($this->_where);
    }
    return $this->_query;
  }

  protected function compile_conditions(array $conditions) {
    $last_condition = NULL;
    $i = 0;
    $sql = '';
    foreach ($conditions as $group) {
      // Process groups of conditions
      foreach ($group as $logic => $condition) {
        if ($condition === '(') {
          if (!empty($sql) AND $last_condition !== '(') {
            // Include logic operator
            $sql .= ' ' . $logic . ' ';
          }

          $sql .= '(';
        } elseif ($condition === ')') {
          $sql .= ')';
        } else {
          if (!empty($sql) AND $last_condition !== '(') {
            // Add the logic operator
            $sql .= ' ' . $logic . ' ';
          }

          // Split the condition
          list($column, $op, $value) = $condition;

          if ($value === NULL) {
            if ($op === '=') {
              // Convert "val = NULL" to "val IS NULL"
              $op = 'IS';
            } elseif ($op === '!=') {
              // Convert "val != NULL" to "valu IS NOT NULL"
              $op = 'IS NOT';
            }
          }

          // Database operators are always uppercase
          $op = strtoupper($op);

          if (($op === 'BETWEEN' OR $op === 'NOT BETWEEN') AND is_array($value)) {
            // BETWEEN always has exactly two arguments
            list($min, $max) = $value;

            if (is_string($min) AND array_key_exists($min, $this->_parameters)) {
              // Set the parameter as the minimum
              $min = $this->_parameters[$min];
            }

            if (is_string($max) AND array_key_exists($max, $this->_parameters)) {
              // Set the parameter as the maximum
              $max = $this->_parameters[$max];
            }

            // Quote the min and max value
            $value = $this->quote($min) . ' AND ' . $this->quote($max);
          } else {
            if (is_string($value) AND array_key_exists($value, $this->_parameters)) {
              // Set the parameter as the value
              $value = $this->_parameters[$value];
            }

            //create unique binding marker as :columnvalue
            $marker = ":" . $column . $i;
            $this->_bindings[":" . $column . $i] = $value;

            $i++;
            //set value to binding marker
            $value = $marker;
          }

          // Append the statement to the query
          $sql .= $column . ' ' . $op . ' ' . $value;
        }

        $last_condition = $condition;
      }
    }

    return $sql;
  }

  public function quote($value) {
    $result = "'" . str_replace("'", "''", $value) . "'";
    return $result;
  }

  public function getQuery() {
    return $this->_query;
  }

  public function getWhereClause() {
    return $this->_where;
  }

  public function getBindings() {
    return $this->_bindings;
  }

  public function reset() {
    $this->_bindings = array();
    $this->_parameters = array();
    $this->_where = array();
    $this->_query = '';
  }

}

?>
