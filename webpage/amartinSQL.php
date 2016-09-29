<?php
    class amartinSQL
    {
        // --FIELDS--
        private $select;            // array of column names
        private $from;              // array of table names
        private $where = array();   // array of conditionals
        private $group_by;          // array of grouping instructions

        // --PRIVATE METHODS--
        private function formatSelect()
        {
            // generate SELECT statement
            $i = 0;
            $result = "SELECT";
            foreach ($this->select as $select)
            {
                $result .= " " . $select;
                if (++$i < count($this->select))
                    $result .= ",";
            }

            return $result;
        }

        private function formatFrom()
        {
            // generate FROM clause
            $i = 0;
            $result = "FROM";
            foreach ($this->from as $from)
            {
                $result .= " " . $from;
                if (++$i < count($this->from))
                    $result .= ",";
            }

            return $result;
        }

        private function formatWhere()
        {
            // append WHERE conditionals
            $i = 0;
            $result = "WHERE";
            foreach ($this->where as $block)
            {
                $result .= " (";

                $j = 0;
                foreach ($block as $clause)
                {
                    $result .= " " . $clause;
                    if (++$j < count($block))
                        $result .= " OR";
                }

                $result .= " )";

                if (++$i < count($this->where))
                    $result .= " AND";
            }

            return $result;
        }

        private function formatGroupBy()
        {
            // generate FROM clause
            $i = 0;
            $result = "GROUP BY";
            foreach ($this->group_by as $group_by)
            {
                $result .= " " . $group_by;
                if (++$i < count($this->group_by))
                    $result .= ",";
            }

            return $result;
        }

        // --INTERFACE--
        public function select($select)      { $this->select = $select;      }
        public function from($from)          { $this->from = $from;          }
        public function where($where)        { $this->where[] = $where;      }
        public function group_by($group_by)  { $this->group_by = $group_by;  }

        public function clear() { unset($select, $from, $where, $group_by); }

        public function getQuery($pretty_print = false)
        {
            // returns a string of the current query
            // if the current query is invalid, returns NULL

            if (!$this->select or !$this->from)
                return;
            
            $result = $this->formatSelect();
            $result .= " " . $this->formatFrom();
            
            if ($this->where[0])
                $result .= " " . $this->formatWhere();

            $result .= $this->formatGroupBy();

            return $result;
        }
        
        // --STATIC METHODS--
        public static function escape($string, $char = '`') { return $char . $string . $char; }
    }
?>