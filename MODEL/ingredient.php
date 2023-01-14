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

    public function getIngredientAllergens($id) //Ritorna gli allergeni di un ingrediente.
    {
        $query = 'SELECT a.id, a.name FROM ingredient i INNER JOIN ingredient_allergen ia ON i.id = ia.ingredient INNER JOIN allergen a ON ia.allergen = a.id WHERE i.id = ' . $id . ' ORDER BY a.name';

        $stmt = $this->conn->query($query);
        $this->SendOutput($stmt, JSON_OK);

        return $stmt;
    }

    public function deleteIngredientFromAllAllergens($id) //Cancella l'ingrediente nella tabella molti a molti con gli allergeni.
    {
        $query = 'DELETE FROM ingredient_allergen WHERE ingredient = ' . $id;

        $stmt = $this->conn->query($query);
        $this->SendOutput($stmt, JSON_OK);

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
        $this->deleteIngredientFromAllAllergens($id); //Richiama il metodo per rimuovere l'ingrediente dalla tabella molti a molti (per permettermi poi di eliminarlo dalla tabella ingredient).
        $this->deleteIngredientFromAllProducts($id); //Richiama il metodo per rimuovere l'ingrediente dalla tabella molti a molti (per permettermi poi di eliminarlo dalla tabella ingredient).

        //$query = 'DELETE i, ia FROM' . $this-> table_name . ' i INNER JOIN ingredients_allergens ia ON i.id = ia.allergens_id WHERE i.id = ' . $id;
        $query = 'DELETE FROM ingredient i WHERE id = ' . $id;

        $stmt = $this->conn->query($query);
        $this->SendOutput($stmt, JSON_OK);

        return $stmt;
    }

    public function setIngredientAllergen($ingredient_id, $allergen_id) //Inserisce valori nella tabella ingredient_allergen.
    {
        $query = 'INSERT INTO ingredient_allergen (ingredient, allergen) VALUES(' . $ingredient_id . ', ' . $allergen_id . ')';

        $stmt = $this->conn->query($query);
        $this->SendOutput($stmt, JSON_OK);

        return $stmt;
    }

    public function createIngredient($name, $description, $price, $quantity, $allergens_ids) //Inserisce un nuovo ingrediente.
    {
        $query = 'INSERT INTO ingredient i(name, description, price, quantity) VALUES(\'' . $name . '\', \'' . $description . '\', ' . $price . ', ' . $quantity . ')';

        $stmt = $this->conn->query($query);
        $this->SendOutput($stmt, JSON_OK);

        return $stmt;

        if (count($allergens_ids) > 0); {
            $query1 = 'SELECT DISTINCT id FROM ingredient i WHERE name = \'' . $name . '\''; //Query per ritornarmi l'id dell'allergene.
            $stmt1 = $this->conn->prepare($query1);
            $stmt1->execute();
            $res = $stmt1->fetch(PDO::FETCH_ASSOC); //why

            for ($i = 0; $i < count($allergens_ids); $i++) {
                $this->setIngredientAllergen($res, $allergens_ids[$i]);
            }
        }
    }

    public function modifyIngredientName($id, $name) //Modifica il nome di un ingrediente.
    {
        $query = 'UPDATE ingredient i SET i.name = \'' . $name . '\' WHERE i.id = ' . $id;

        $stmt = $this->conn->query($query);
        $this->SendOutput($stmt, JSON_OK);

        return $stmt;
    }

    public function modifyIngredientDescription($id, $description) //Modifica la descrizione di un ingrediente.
    {
        $query = 'UPDATE ingredient i SET i.description = \'' . $description . '\' WHERE i.id = ' . $id;

        $stmt = $this->conn->query($query);
        $this->SendOutput($stmt, JSON_OK);

        return $stmt;
    }

    public function modifyIngredientPrice($id, $price) //Modifica il prezzo di un ingrediente.
    {
        $query = 'UPDATE ingredient i SET i.price = ' . $price . ' WHERE i.id = ' . $id;

        $stmt = $this->conn->query($query);
        $this->SendOutput($stmt, JSON_OK);

        return $stmt;
    }

    public function modifyIngredientQuantity($id, $quantity) //Modifica la quantità in magazzino di un ingrediente.
    {
        $query = 'UPDATE ingredient i SET i.quantity = ' . $quantity . ' WHERE i.id = ' . $id;

        $stmt = $this->conn->query($query);
        $this->SendOutput($stmt, JSON_OK);

        return $stmt;
    }
}
