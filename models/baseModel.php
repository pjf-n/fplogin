<?php

abstract class BaseModel {

    /**
     * @var string the name of the table
     */
    protected $table;

    /**
     * @var PDO the pdo instance storing the connection
     */
    protected $db;

    /**
     * @var array the schema of the table, this needs to be extended
     */
    protected $schema = array();

    public function __construct( $db = null ) {

        // TODO: Ideally need to check the type before assigning
        if( $db !== null ) {
            $this->db = $db;

        // TODO: Ideally need to check the type and that it exists
        } else {

            // Use global $db reference
            // TODO: Find neater method
            global $db;
            $this->db = $db;
        }
    }

    public function _sleep() {
        return array();
    }

    public function _wakeup() {
        $this->db = $_SESSION['db'];
    }

    /**
     * Gets a single record
     *
     * TODO: Very limited, can only query by id, need to add where clauses
     *
     * @param $id int the id of the record to retrieve
     * @return array the data for the record
     */
    public function get($id) {

        $statement = $this->db->prepare("select * from $this->table where id = :id");
        $statement->execute(array(':id' => $id));
        $row = $statement->fetch();

        return $row;
    }

    /**
     * Gets all records
     *
     * @return array the records found
     */
    public function getAll() {

        $statement = $this->db->prepare("select * from $this->table");
        $statement->execute();
        $rows = $statement->fetchAll();

        return $rows;
    }

    /**
     * Updates a record
     *
     * TODO: Very limited, can only query by id, need to add where clauses
     *
     * @param $id int the record to update
     * @param $data array the data to update on the record
     * @return bool true on success, false on failure
     */
    public function update($id, $data) {

        $query = '';

        foreach( $data as $key => $val ) {

            if( in_array( $key, $this->schema ) ) {
                $query .= $key . "='" . $val . "'";
            }
        }

        $statement = $this->db->prepare("update $this->table set $query where id = :id");
        $result = $statement->execute(array( 'id' => $id ));

        return $result;
    }

    /**
     * Creates a new record
     *
     * @param $data array the data to add to the record
     * @return bool|string true on success, error message on failure
     */
    public function create($data) {

        $keys = array();
        $values = array();

        foreach( $data as $key => $val ) {

            if( in_array( $key, $this->schema ) ) {
                $keys[$key] = ':'.$key;
                $values[':'.$key] = $val;
            }
        }

        $keyString = '(' . join(',', str_replace(':','',$keys)) . ')';
        $valueString = '(' . join(',', $keys) . ')';

        $statement = $this->db->prepare("insert into $this->table $keyString values $valueString");
        $result = $statement->execute($values);

        // Return error message
        if( $result == false ) {
            $error = $statement->errorInfo();
            return $error[2];
        }

        // Return true
        return $result;
    }

    /**
     * Deletes a record
     *
     * @param $id int the record to delete
     * @return bool true on success, false on failure
     */
    public function destroy($id) {

        $statement = $this->db->prepare("delete from $this->table where id = :id");
        $result = $statement->execute(array('id'=>$id));

        return $result;
    }

    /**
     * Get the last inserted ID
     *
     * @return int the last ID inserted
     */
    public function getInsertId() {

        $id = $this->db->lastInsertId();

        return $id;
    }
}