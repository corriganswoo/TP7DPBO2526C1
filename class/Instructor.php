<?php
class Instructor
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        $stmt = $this->db->prepare("SELECT * FROM instructors ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM instructors WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($name, $email, $expertise)
    {
        $stmt = $this->db->prepare("INSERT INTO instructors (name, email, expertise) VALUES (?, ?, ?)");
        return $stmt->execute([$name, $email, $expertise]);
    }

    public function update($id, $name, $email, $expertise)
    {
        $stmt = $this->db->prepare("UPDATE instructors SET name = ?, email = ?, expertise = ? WHERE id = ?");
        return $stmt->execute([$name, $email, $expertise, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM instructors WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
