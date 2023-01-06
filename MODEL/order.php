<?php 
    Class Order
    {
        protected $conn;
        protected $table_name = "`order`";

        protected $user_ID;
        protected $total_price;
        protected $date_hour_sale;
        protected $break_ID;
        protected $status_ID;
        protected $pickup_ID;
        protected $json;


        //chi deve calcolare il prezzo totale del carrello? quelli che fanno il carrello

        public function __construct($db)
        {
            $this->conn = $db;
        }

        function getArchiveOrder() // Ottiene tutti gli ordini
        {
            $query = "SELECT * FROM $this->table_name";

            $stmt = $this->conn->query($query);

            return $stmt;
        }

        function getOrder($id) // Ottiene l'ordine con l'id passato alla funzione
        {
            $query = "SELECT * FROM $this->table_name WHERE id = $id";

            $stmt = $this->conn->query($query);

            return $stmt;
        }

        function getArchiveOrderStatus($id) // Ottiene gli ordini in base allo stato
        {
            $query = "SELECT * FROM $this->table_name WHERE status = $id";

            $stmt = $this->conn->query($query);

            return $stmt;
        }

        function getArchiveOrderBreak($id) // Ottiene gli ordini in base alla ricreazione
        {
            $query = "SELECT * FROM $this->table_name WHERE break = $id";

            $stmt = $this->conn->query($query);

            return $stmt;
        }

        function getArchiveOrderUser($id) // Ottiene gli ordini in base allo user
        {
            $query = "SELECT * FROM $this->table_name WHERE user = $id";

            $stmt = $this->conn->query($query);

            return $stmt;
        }

        function delete($id){ // Annulla un ordine

            $query = "UPDATE $this->table_name SET status = 3 WHERE id = $id";

            $stmt = $this->conn->query($query);

            return $stmt;
        }

        
        function setStatus($id){ // setta lo stato di un ordine a 2, pronto

            $query = "UPDATE $this->table_name SET status = 2 WHERE id = $id";

            $stmt = $this->conn->query($query);

            return $stmt;
        }


        /*
            Esempio body da passare alla funzione

            {
                "user_ID": 1,
                "total_price": 15.50,
                "break_ID": 1,
                "status_ID": 1,
                "pickup_ID": 1,
                "products": [
                        {"ID": 1, "quantity": 1},
                        {"ID": 2, "quantity": 1},
                        {"ID": 3, "quantity": 2}
                    ],
                "json": {
                "user_ID": 1,
                "total_price": 15.50,
                "break_ID": 1,
                "status_ID": 1,
                "pickup_ID": 1,
                "products": [
                        {"name": "panino al prosciutto", "price": 3, "quantity":1},
                        {"name": "panino al salame", "price": 3, "quantity":1},
                        {"name": "panino proteico", "price": 3, "quantity":2}
                    ]
                }
            }
        */
        /*
        'id' => $id,
        'user' => $user,
        'created' => $created,
        'pickup' => $pickup,
        'break' => $break,
        'status' => $status,
        'json' => json_decode($json)
        */
        function setOrder($user_ID, $break_ID, $status_ID, $pickup_ID, $json){ // Crea un ordine di vetrina

            $query = "INSERT INTO $this->table_name (`user`,break, status, pickup, json)
                      VALUES (?, ?, ?, ?, ?)";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('iiiis', $user_ID,  $break_ID, $status_ID, $pickup_ID, $json);
            if ($stmt->execute())
            {
                return $stmt;
            }
            else
            {
                return "";
            }
        }

        function getArchiveOrderByClass($year, $section)
        {
            $query = "SELECT o.id, c.`section`, c.`year`, o.created, o.pickup, o.break, o.status, o.json
            FROM $this->table_name o
            INNER JOIN user_class uc ON o.`user` = uc.`user`
            INNER JOIN class c ON c.id = uc.class
            WHERE c.`year` = ". (int)$year .   " AND c.`section` = '" . $section. "'";

            return $this->conn->query($query);;
        }

        function getActiveOrderByClass($year, $section)
        {
            $query = "SELECT o.id, c.`section`, c.`year`, o.created, o.pickup, o.break, o.status, o.json
            FROM $this->table_name o
            INNER JOIN user_class uc ON o.`user` = uc.`user`
            INNER JOIN class c ON c.id = uc.class
            WHERE c.`year` = ". (int)$year .   " AND c.`section` = '" . $section. "' AND o.status = 1";

            return $this->conn->query($query);;
        }
    }
?>