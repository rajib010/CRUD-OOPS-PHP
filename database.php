<?php
class Database
{

    private $host = 'localhost';
    private $user = 'root';
    private $password = '';
    private $db_name = 'mydatabase';
    private $mysqli = '';


    //make the connection directly...
    public function __construct()
    {
        $this->mysqli = mysqli_connect($this->host, $this->user, $this->password, $this->db_name);
        if ($this->mysqli) {
            echo "connected successfully...";
        } else {
            echo "connection failed";
            die();
        }
    }


    //function for insert into tables...

    public function insert($table, $params = array())
    {
        $table_columns = implode(' , ', array_keys($params));
        $table_values = implode(' , ', $params);
        $sql = "INSERT INTO $table($table_columns) VALUES($table_values)";
        $result = $this->mysqli->query($sql);

        //check if inserted
        if ($result) {
            echo "inserted successfully";
        } else {
            echo "Error inserting data: ";
        }
    }

    //function to update from tables..
    public function update($table, $params = array(), $where = null)
    {
        $args = array();

        foreach ($params as $key => $value) {
            $args[] = "$key = '$value'";
        }
        $sql = "UPDATE $table SET " . implode(', ', $args);
        if ($where != null) {
            $sql .= "WHERE $where";
        }
        $result = $this->mysqli->query($sql);

        if ($result) {
            echo $this->mysqli->affected_rows . "rows affected";
        } else {
            echo "update unsuccessful...";
        }
    }


    //function to delete from tables
    //DELETE FROM $TABLE WHERE ID=ID

    public function delete($table, $where = null)
    {
        $sql = "DELETE FROM $table";
        if ($where != null) {
            $sql .= " WHERE $where";
        }
        $result = $this->mysqli->query($sql);

        if ($result) {
            echo $this->mysqli->affected_rows . " rows deleted successfully";
        } else {
            echo "delete unsuccessful";
        }
    }

    //function to select the valuess...

    public function select($table,$row='*',$join=null,$where=null,$order=null,$limit=null){
        $sql="SELECT $row FROM $table ";
        //checking if other parameters are given
        if($join!=null){
            $sql .= " Join $join";
        } 
        if($where!=null){
            $sql .= " WHERE $where";
        } 
        if($order!=null){
            $sql .= " ORDER BY $order";
        } 
        if($limit!=null){
            $sql .= " LIMIT $limit";
        } 

        $result=$this->mysqli->query($sql);
        //if result exists
        if($result){
            //printing each result
            while($row=$result->fetch_assoc()){
                print_r($row);
            }
        }else{
            echo "Error fetching data";
        }
    }

    //close the connection....
    public function __destruct()
    {
        if ($this->mysqli) {
            $this->mysqli->close();
        }
    }
}
