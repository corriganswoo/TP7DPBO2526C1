<?php
class Course
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        $stmt = $this->db->prepare(
            "SELECT c.*, i.name AS instructor_name
             FROM courses c
             JOIN instructors i ON c.instructor_id = i.id
             ORDER BY c.id DESC"
        );
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM courses WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($code, $name, $credits, $instructor_id)
    {
        $stmt = $this->db->prepare("INSERT INTO courses (code, name, credits, instructor_id) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$code, $name, $credits, $instructor_id]);
    }

    public function update($id, $code, $name, $credits, $instructor_id)
    {
        $stmt = $this->db->prepare("UPDATE courses SET code = ?, name = ?, credits = ?, instructor_id = ? WHERE id = ?");
        return $stmt->execute([$code, $name, $credits, $instructor_id, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM courses WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
