<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /includes/class/model.php
 * @author Quang Chau Tran (quangchauvn@gmail.com)
 * @Createdate 08/14/2014, 02:04 PM
 */
if (!defined('BNC_CODE')) {
    exit('Access Denied');
}
class ModelCore {
    protected $name;
    private $db;
    public function __construct($name = null, $db = null) {
        global $_B, $_CFD;

        $this->name = $name;
        $this->db   = $_B['con'];

        //Mở copy lang
        $this->cpLang = false;
        if ($this->cpLang == true) {
            $this->CopyTableLang();
        }
        //Xử lý riêng module product

        if (isset($_GET['mod']) && ($_GET['mod'] == 'product' || $_GET['mod'] == 'payment')
            && (strpos($this->name, '_brand') !== false
                || strpos($this->name, '_category') !== false
                || strpos($this->name, '_color') !== false
                || strpos($this->name, '_comment') !== false
                || strpos($this->name, '_config') !== false
                || strpos($this->name, '_form_field') !== false
                || strpos($this->name, '_order_status') !== false
                || strpos($this->name, '_people_auction') !== false
                || strpos($this->name, '_product_') !== false
                || strpos($this->name, '_properties') !== false
                || strpos($this->name, '_require_email') !== false
                || strpos($this->name, '_require_price') !== false
                || strpos($this->name, '_setting') !== false
                || strpos($this->name, '_shop') !== false
                || strpos($this->name, '_size') !== false
                || strpos($this->name, '_supplier') !== false
                || strpos($this->name, '_unit') !== false
            )
            && strpos($this->name, '.') === false) {
            $this->name = get_db_mod('product')['db_name'] . '.' . $this->name;
        } else {
            if (strpos($this->name, '.') === false) {
                $this->name = $_CFD['mod']['db_name'] . '.' . $this->name;
            } else {
                $this->name = explode('.', $this->name);

                $this->name = get_db_mod($this->name[0])['db_name'] . '.' . $this->name[1];
            }
        }
        
    }
    /*
     *@columns array(string) so truong can lay
     *@numRows int (0,limit), array (v0,v1)
     */
    public function get($as = null, $numRows = null, $columns = '*') {
        global $_B;
        if ($as == null) {
            $data = $this->db->get($this->name, $numRows, $columns);
        } else {
            $data = $this->db->get($this->name . " " . $as, $numRows, $columns);
        }
        return $data;
    }
    /**
     * A convenient SELECT * function to get one record.
     *
     * @param string  $tableName The name of the database table to work with.
     *
     * @return array Contains the returned rows from the select query.
     */
    public function getOne($as = null, $columns = '*') {
        if ($as == null) {
            return $this->db->getOne($this->name, $columns);
        } else {
            return $this->db->getOne($this->name . " " . $as, $columns);
        }

    }
    /**
     * This method allows you to specify multiple (method chaining optional) AND WHERE statements for SQL queries.
     *
     * @uses $MySqliDb->where('id', 7)->where('title', 'MyTitle');
     *
     * @param string $whereProp  The name of the database field.
     * @param mixed  $whereValue The value of the database field.
     *
     * @return MysqliDb
     */
    public function where($whereProp, $whereValue = null, $operator = null) {
        $this->db->where($whereProp, $whereValue, $operator);
    }
    /**
     * This method allows you to specify multiple (method chaining optional) OR WHERE statements for SQL queries.
     *
     * @uses $MySqliDb->orWhere('id', 7)->orWhere('title', 'MyTitle');
     *
     * @param string $whereProp  The name of the database field.
     * @param mixed  $whereValue The value of the database field.
     *
     * @return MysqliDb
     */
    public function orWhere($whereProp, $whereValue = null, $operator = null) {
        $this->db->orWhere($whereProp, $whereValue, $operator);
    }
    /**
     * This method allows you to specify multiple (method chaining optional) ORDER BY statements for SQL queries.
     *
     * @uses $MySqliDb->orderBy('id', 'desc')->orderBy('name', 'desc');
     *
     * @param string $orderByField The name of the database field.
     * @param string $orderByDirection Order direction.
     *
     * @return MysqliDb
     */
    public function orderBy($orderByField, $orderbyDirection = "DESC") {
        $this->db->orderBy($orderByField, $orderbyDirection);
    }
    /**
     * This method allows you to specify multiple (method chaining optional) GROUP BY statements for SQL queries.
     *
     * @uses $MySqliDb->groupBy('name');
     *
     * @param string $groupByField The name of the database field.
     *
     * @return MysqliDb
     */
    public function groupBy($groupByField) {
        $this->db->groupBy($groupByField);
    }
    /**
     * This method allows you to concatenate joins for the final SQL statement.
     *
     * @uses $MySqliDb->join('table1', 'field1 <> field2', 'LEFT')
     *
     * @param string $joinTable The name of the table.
     * @param string $joinCondition the condition.
     * @param string $joinType 'LEFT', 'INNER' etc.
     *
     * @return MysqliDb
     */
    public function join($as, $joinCondition, $joinType = '') {
        $this->db->join($as, $joinCondition, $joinType);
    }

    public function getLastError() {
        return $this->db->getLastError();
    }
    /**
     * A convenient num_rows
     *
     * @param string  $tableName The name of the database table to work with.
     *
     * @return int number rows from the select query.
     */
    public function num_rows() {
        return $this->db->num_rows($this->name);
        //return $this->db->withTotalCount();
    }
    public function num_rows_new() {
        return $this->db->num_rows_new();
        //return $this->db->withTotalCount();
    }
    /*
     *@data  array
     */
    public function insert($data) {
        return $this->db->insert($this->name, $data);
    }
    /*
     *@data  array
     */
    public function insert_core($data) {
        return $this->db->insert($this->name, $data);
    }
    /*
     *@data  array
     */
    public function update($data) {
        return $this->db->update($this->name, $data);
    }
    /*
     */
    public function delete() {
        return $this->db->delete($this->name);
    }

    /*
     */
    public function existTable() {
        if ($this->cpLang == false) {
            return true;
        }
        return $this->db->has($this->name);
    }
    /*
     */
    public function setTrace($enabled, $stripPrefix = null) {
        return $this->db->setTrace($enabled, $stripPrefix = null);
    }
    public function getTraces() {
        return $this->db->getTraces();
    }
    public function reset() {
        return $this->db->reset();
    }

    public function rawQuery($query) {
        return $this->db->rawQuery($query);
    }
    public function getLastQuery() {
        return $this->db->getLastQuery();
    }

    /**
     * Copy table for multilang
     * Copy table lang_tablenam from vi_tablename and ADD id_lang (id of item from vi_tablenam)
     */
    private function CopyTableLang() {
        //return;
        if ($this->db->has($this->name) === true) {
            return true;
        } else {
            //chua co bang, tien hanh nhan ban
            $langkey      = substr($this->name, 0, 3);
            $tabledefault = str_replace($langkey, 'vi_', $this->name);
            if ($this->db->table_exist($tabledefault)) {
                $this->db->rawQuery("CREATE TABLE `$this->name` LIKE `$tabledefault`");
            }
        }

    }

}
?>
