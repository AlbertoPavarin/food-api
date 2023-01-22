<?php
Class Class_{
    protected $conn;
    protected $table_name='`class`';

    public $year;
    public $section;
    
    public function __construct($db)
    {
        $this->conn=$db;
    }

    public function getClasses() // Ottiene le classi  
    {
        $query = "SELECT id, year, section FROM $this->table_name";

        $stmt = $this->conn->query($query);

        return $stmt;
    }
    public function setClass($year,$section)  
    {
        $query = "insert into class(year,section) values(".$year.",'$section')";

        $stmt = $this->conn->query($query);

        return $stmt;
    }


    public function getClass($id) // Ottiene la class che ha l'id passato alla funzione   
    {
        $query = "SELECT id, year, section 
        FROM $this->table_name
        WHERE id=$id";

        $stmt = $this->conn->query($query);

        return $stmt;
    }
}
?>