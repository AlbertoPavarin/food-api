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

    public function getClass() // Ottiene la ricreazione che ha l'id passato alla funzione   
    {
        $query = "SELECT id, year, section FROM $this->table_name";

        $stmt = $this->conn->query($query);

        return $stmt;
    }
}
?>