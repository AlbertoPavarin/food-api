<?php
class Break_{
    protected $conn;
    protected $table_name='break';

    public $break_time;
    
    public function __construct($db)
    {
        $this->conn=$db;
    }

    public function getBreak($id) // Ottiene la ricreazione che ha l'id passato alla funzione   
    {
        $query = "SELECT id, time FROM $this->table_name WHERE id = $id";

        $stmt = $this->conn->query($query);

        return $stmt;
    }

    public function getArchiveBreak() // Ottiene tutte le ricreazioni
    {
        $query = "SELECT id, time FROM $this->table_name";

        $stmt = $this->conn->query($query);

        return $stmt;
    }

    public function setBreak($time)
    {
        $query = "INSERT INTO $this->table_name (`time`)
                  VALUES ('$time');";

        echo $query;

        return $this->conn->query($query);
    }
}
?>
