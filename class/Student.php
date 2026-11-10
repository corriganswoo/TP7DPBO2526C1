<?php
class Student
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        $stmt = $this->db->prepare("SELECT * FROM students ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM students WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($nim, $name, $email)
    {
        $stmt = $this->db->prepare("INSERT INTO students (nim, name, email) VALUES (?, ?, ?)");
        return $stmt->execute([$nim, $name, $email]);
    }

    public function update($id, $nim, $name, $email)
    {
        $stmt = $this->db->prepare("UPDATE students SET nim = ?, name = ?, email = ? WHERE id = ?");
        return $stmt->execute([$nim, $name, $email, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM students WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
