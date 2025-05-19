<?php

namespace Aries\MiniFrameworkStore\Models;

use Aries\MiniFrameworkStore\Includes\Database;

class Category extends Database
{

    private $db;

    public function __construct()
    {
        parent::__construct(); // Call the parent constructor to establish the connection
        $this->db = $this->getConnection(); // Get the connection instance
    }

    public function getAll()
    {
        $sql = "SELECT * FROM product_categories";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function insert($data)
    {
        $sql = "INSERT INTO product_categories (name) VALUES (:name)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'name' => $data['name'],
        ]);

        return $this->db->lastInsertId(); // Return the ID of the newly inserted category
    }


}