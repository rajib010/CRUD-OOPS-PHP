<?php
class Database
{
    private $host = 'localhost';
    private $user = 'root';
    private $password = '';
    private $db_name = 'mydatabase';
    private $mysqli = '';
    private $result = array();  

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

    public function insert($table, $params)
    {
        array_pop($params);
        $table_columns = implode(' , ', array_keys($params));
    
        $table_values= "'" .implode("','", $params) . "'";

        $sql = "INSERT INTO $table($table_columns) VALUES($table_values)";
        echo $sql;

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
            echo $this->mysqli->affected_rows . "rows updated";
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

    public function select($table, $row = '*', $join = null, $where = null, $order = null, $limit = null)
    {
        $sql = "SELECT $row FROM $table ";
        //checking if other parameters are given
        if ($join != null) {
            $sql .= " Join $join";
        }
        if ($where != null) {
            $sql .= " WHERE $where";
        }
        if ($order != null) {
            $sql .= " ORDER BY $order";
        }
        if ($limit != null) {
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = 1;
            }
            $start = ($page - 1) * $limit;
            $sql .= " LIMIT $start,$limit";
        }

        $result = $this->mysqli->query($sql);
        //if result exists
        if ($result) {
            //printing each result
            while ($row = $result->fetch_assoc()) {
                print_r($row) ."\n";
            }
        } else {
            echo "Error fetching data";
        }
    }

    //function for pagination...
    public function pagination($table, $join = null, $where = null, $limit = null)
    {
        if (!$limit = null) {
            $sql="SELECT COUNT(*) FROM `information`";
            if ($join != null) {
                $sql .= " JOIN $join";
            }
            if ($where != null) {
                $sql .= " WHERE $where";
            }
            $query = $this->mysqli->query($sql);
            if ($query) {
                $total_records = $query->fetch_array();
            } else {
                $total_records = 0;
            }
            $total_records = $total_records[0]; //fetching the exact number of records get from the query...
            $total_page = intval(ceil($total_records / $limit));

            $url = basename($_SERVER['PHP_SHELF']); // getting the name of the current $age from the url ...

            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = 1;
            }
            $output = "<ul class= 'pagination'>";
            if ($total_records > $limit) {
                for ($i = 1; $i <= $total_page; $i++) {
                    if ($i == $page) {
                        $cls = "class='active'";
                    } else {
                        $cls = "";
                    }
                    $output .= "<li> <a $cls href='$url?page=$i'>$i</a></li>";
                }
            }
            $output .= "</ul>";
            echo $output;
        }
    }


    //to show the results
    public function getResult(){
        $val= $this->result;
        $this->result= array();
        return $val;
    }

    //close the connection....
    public function __destruct()
    {
        if ($this->mysqli) {
            $this->mysqli->close();
        }
    }
}
