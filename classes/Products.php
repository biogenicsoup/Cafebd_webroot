<?php
include 'Product.php';

class Products
{
    public mysqli $con;

    function __construct($con)
    {
        $this->con = $con;
    }

    /**
     * Returns a list of Product objects
     * @return Product[]
     */
    function get_products()
    {
        $sql = "SELECT p.id FROM product p";
        $product_list = prepared_select($this->con, $sql, [])->fetch_all(MYSQLI_ASSOC);
        $products = array();

        foreach ($product_list as $row)
        {
            $products[] = new Product($row['id'],$this->con);
        }
        return $products;
    }

    function get_products_list()
    {
        $sql = "SELECT id, name FROM product ORDER BY name";
        return prepared_select($this->con, $sql, [])->fetch_all(MYSQLI_ASSOC);
    }
    
    function get_testtype_list()
    {
        $sql = "SELECT id, name FROM testtype ORDER BY id";
        return prepared_select($this->con, $sql, [])->fetch_all(MYSQLI_ASSOC);
    }
}