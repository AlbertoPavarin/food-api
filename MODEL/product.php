<?php
require("base.php");
class ProductController extends BaseController
{
    public function GetProduct($product_id) //mostra un singolo prodotto

    {
        $sql = "SELECT distinct p.id ,p.name, p.price, t.name as 'Tag', p.description, p.nutritional_value, p.quantity, p.active
                from product p
                left join product_tag pt on pt.product=p.id
                left join tag t on t.id=pt.tag
                where p.id = " . $product_id . ";";

        $result = $this->conn->query($sql);
        $this->SendOutput($result, JSON_OK);
    }
    public function GetArchiveProducts() //mostra tutti i prodotti

    {
        $sql = "SELECT distinct p.id ,p.name, p.price, t.name as 'Tag', p.description, p.nutritional_value, p.quantity, p.active
                from product p
                left join product_tag pt on pt.product=p.id
                left join tag t on t.id=pt.tag
                ";

        $result = $this->conn->query($sql);
        $this->SendOutput($result, JSON_OK);
    }
    public function GetArchiveIngredients($product_ID) //mostra gli ingredienti di un singolo prodotto

    {
        $sql = "select i.name, i.quantity, i.description
        from product p
        inner join product_ingredient pi2 on p.ID = pi2.product
        inner join ingredient i on i.ID = pi2.ingredient
        inner join product_tag pt on pt.product = p.id
        inner join tag t on t.id = pt.tag
        where p.ID = " . $product_ID . ";";

        $result = $this->conn->query($sql);
        $this->SendOutput($result, JSON_OK);
    }
    function getProductAllergen($product){
        $sql = "select distinct a.name, a.id
        from allergen a
        inner join product_allergen pa on a.id = pa.allergen
        inner join product p on pa.product = ".$product."
        order by a.id;";

        $result = $this->conn->query($sql);
        $this->SendOutput($result, JSON_OK);

    }
    public function getIngredientById($ingredient_ID)
    {
        $sql = "SELECT i.id ,i.name , i.price as 'price', i.extra , i.quantity , i.description
                from ingredient i
                where i.id =" . $ingredient_ID . ";";

        $result = $this->conn->query($sql);
        $this->SendOutput($result, JSON_OK);
    }
    public function GetIngredient($ingredient_ID)
    {
        $sql = "SELECT i.id as 'ID',i.name as 'Nome ingrediente', i.price as 'price', i.extra as 'extra', i.quantity as 'Quantita', i.description as 'Descrizione',p.name as 'Prodotto in cui e contenuto'
                from ingredient i
                left join product_ingredient pi on pi.ingredient=i.id
                left join product p on p.id=pi.product 
                where i.id =" . $ingredient_ID . ";";

        $result = $this->conn->query($sql);
        $this->SendOutput($result, JSON_OK);
    }
    function getActiveProductByTag($tag){
        $sql="select distinct p.id, p.name, p.description, p.price,p.quantity, p.nutritional_value
        from product p 
        inner join product_tag pt ON pt.product = p.id and pt.tag =".$tag." and p.active =1
        order by p.id ;";
        $result = $this->conn->query($sql);
        $this->SendOutput($result, JSON_OK);
    }
    public function CheckIngredient() //Mostro ingredienti disponibili e loro quantità
    {
        $sql = "select distinct i.name, i.price,i.quantity
                from ingredient i
                order by i.id;";

        $result = $this->conn->query($sql);
        $this->SendOutput($result, JSON_OK);
    }
    public function CheckProduct() //Mostro prodotti disponibili e loro quantità

    {
        $sql = "select distinct p.id,p.name, p.quantity, nv.kcal
                from product p
                left join nutritional_value nv on nv.id= p.nutritional_value
                where p.active=1;";

        /*$sql = "select distinct p.name, p.quantity
        from product p
        order by p.ID;";*/

        $result = $this->conn->query($sql);
        $this->SendOutput($result, JSON_OK);
    }
    //DA RIVEDERE POTREBBE ESSERE INUTILE
    /*public function DeleteIngredient($ingredient_ID) //Non mostra l'ingrediente finito di cui gli si passa l'id--in fase di progettazione
    {
    //delete from ingredient WHERE  ID= '$ingredient_ID';---query per eliminare record ma non si può usare causa FOREIGN KEY
    $sql = "select distinct i.name, i.available_quantity
    from ingredient i
    where i.ID<" . $ingredient_ID . " or i.ID>" . $ingredient_ID . ";";
    
    $sql = "update ingredient i
    set i.active = 0
    where i.ID=" . $ingredient_ID . ";";
    $result = $this->conn->query($sql);
    $this->CheckIngredient();
    }*/
    public function setIngredient($name, $description, $price, $extra, $quantity)
    {
        $sql = "insert into ingredient(name, description, price,extra,quantity)
        values
        ('$name','$description'," . $price . "," . $extra . "," . $quantity . ");";

        $this->conn->query($sql);
        $this->CheckIngredient();
    }
    public function setProduct($name, $price, $description, $quantity, $nutritional_value, $active)
    {
        $sql = "insert into product(name, price, description, quantity, nutritional_value,active)
                values
                ('$name' , " . $price . ", '$description' , " . $quantity . ", " . $nutritional_value . ", " . $active . ");";

        $this->conn->query($sql);
        $this->CheckProduct();
    }

    public function DeleteProduct($product_ID)
    {
        $sql = "update product p
                set p.active = 0
                where p.id = " . $product_ID . ";";

        $result = $this->conn->query($sql);
        $nRows = mysqli_affected_rows($this->conn); //ottiene il numero di righe cambiato dopo una query
        $this->SendState($result, JSON_OK);
        $this->CheckProduct();
    }

    public function ReActiveProduct($product_ID)
    {
        $sql = "update product p
                set p.active = 1
                where p.id = " . $product_ID . ";";

        $result = $this->conn->query($sql);
        $nRows = mysqli_affected_rows($this->conn);
        $this->SendState($result, JSON_OK);
        $this->CheckProduct();
    }

    public function getArchiveProductsLike($name) // mostra i panini che hanno un nome simile a quello passato
    {
        $formattedName = str_replace("+", " ", $name);
        $sql = "SELECT distinct p.id ,p.name, p.price, t.name as 'Tag', p.description, p.nutritional_value, p.quantity, p.active
        from product p
        left join product_tag pt on pt.product=p.id
        left join tag t on t.id=pt.tag
        where p.name LIKE  '%$formattedName%';
        ";

        $result = $this->conn->query($sql);
        $this->SendOutput($result, JSON_OK);
    }

    public function getArchiveProductsLikeWithTag($name, $tag)
    {
        $formattedName = str_replace("+", " ", $name);
        $sql = "SELECT distinct p.id ,p.name, p.price, t.name as 'Tag', p.description, p.nutritional_value, p.quantity, p.active
        from product p
        left join product_tag pt on pt.product=p.id
        left join tag t on t.id=pt.tag
        where p.name LIKE  '%$formattedName%' AND t.id = $tag;
        ";

        $result = $this->conn->query($sql);
        $this->SendOutput($result, JSON_OK);
    }
    public function setQuantity($product_ID,$quantity){
        $sql = "update product p
                set p.quantity =". $quantity ."
                where p.id = " . $product_ID . ";";

        $result = $this->conn->query($sql);
        $nRows = mysqli_affected_rows($this->conn);
        $this->SendState($result, JSON_OK);
        $this->CheckProduct();
    }

    public function setProductIngredient($prod_id, $ing_id)
    {
        $sql = "INSERT INTO product_ingredient (product, ingredient)
                VALUES (" . $prod_id . "," . $ing_id . ");";

        echo $sql;

        $this->conn->query($sql);
    }
}
