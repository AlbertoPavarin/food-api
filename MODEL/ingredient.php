<?php
require("base.php");
class IngredientController extends BaseController
{

    public function getArchiveIngredient() //Ritorna tutti gli ingredienti.
    {
        $query = 'SELECT * FROM ingredient i WHERE 1=1 ORDER BY i.name';

        $stmt = $this->conn->query($query);
        $this->SendOutput($stmt, JSON_OK);

        return $stmt;
    }

    public function getIngredient($id) //Ritorna l'ingrediente in base al suo id.
    {
        $query = 'SELECT * FROM ingredient i WHERE i.id = ' . $id;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }


    public function deleteIngredientFromAllProducts($id) //Cancella l'ingrediente nella tabella molti a molti con gli ingredienti.
    {
        $query = 'DELETE FROM product_ingredient WHERE ingredient = ' . $id;

        $stmt = $this->conn->query($query);
        $this->SendOutput($stmt, JSON_OK);

        return $stmt;
    }

    public function deleteIngredient($id) //Cancella l'ingrediente dalla tabella ingredient.
    {
        $this->deleteIngredientFromAllProducts($id); //Richiama il metodo per rimuovere l'ingrediente dalla tabella molti a molti (per permettermi poi di eliminarlo dalla tabella ingredient).

        //$query = 'DELETE i, ia FROM' . $this-> table_name . ' i INNER JOIN ingredients_allergens ia ON i.id = ia.allergens_id WHERE i.id = ' . $id;
        $query = 'DELETE FROM ingredient i WHERE id = ' . $id;

        $stmt = $this->conn->query($query);
        $this->SendOutput($stmt, JSON_OK);

        return $stmt;
    }
    
    public function updateIngredient($id, $name, $description, $price, $extra, $quantity) 
    {

        $query = "update ingredient i set i.name = '$name',i.description ='$description', i.price =".$price.",i.extra =".$extra.",i.quantity =".$quantity."   WHERE i.id = " . $id.";";

        $this->conn->query($query);
    }

    public function updateIngredientName($id, $name) //Modifica il nome di un ingrediente.
    {
        $query = "UPDATE ingredient i SET i.name = '$name' WHERE i.id = ' . $id.';";

        $stmt = $this->conn->query($query);
        $this->SendOutput($stmt, JSON_OK);

        return $stmt;
    }

    public function updateIngredientDescription($id, $description) //Modifica la descrizione di un ingrediente.
    {
        $query = "UPDATE ingredient i SET i.description ='$description' WHERE i.id = " . $id.";";

        $stmt = $this->conn->query($query);
        $this->SendOutput($stmt, JSON_OK);

        return $stmt;
    }

    public function updateIngredientPrice($id, $price) //Modifica il prezzo di un ingrediente.
    {
        $query = "UPDATE ingredient i SET i.price ='$price' WHERE i.id = " . $id.";";

        $stmt = $this->conn->query($query);
        $this->SendOutput($stmt, JSON_OK);

        return $stmt;
    }

    public function updateIngredientQuantity($id, $quantity) //Modifica la quantità in magazzino di un ingrediente.
    {
        $query = "UPDATE ingredient i SET i.quantity ='$quantity' WHERE i.id = " . $id.";";

        $stmt = $this->conn->query($query);
        $this->SendOutput($stmt, JSON_OK);

        return $stmt;
    }
    
    public function updateIngredientExtra($id, $extra) //Modifica la quantità in magazzino di un ingrediente.
    {
        $query = "UPDATE ingredient i SET i.extra ='$extra' WHERE i.id = " . $id.";";

        $stmt = $this->conn->query($query);
        $this->SendOutput($stmt, JSON_OK);

        return $stmt;
    }
}
