<?php
class Enrollment
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        $stmt = $this->db->prepare(
            "SELECT e.*, s.name AS student_name, s.nim, c.name AS course_name, c.code
             FROM enrollments e
             JOIN students s ON e.student_id = s.id
             JOIN courses c ON e.course_id = c.id
             ORDER BY e.id DESC"
        );
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM enrollments WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($student_id, $course_id, $status, $grade, $enrolled_at)
    {
        $stmt = $this->db->prepare(
            "INSERT INTO enrollments (student_id, course_id, status, grade, enrolled_at) VALUES (?, ?, ?, ?, ?)"
        );
        return $stmt->execute([$student_id, $course_id, $status, $grade, $enrolled_at]);
    }

    public function update($id, $student_id, $course_id, $status, $grade, $enrolled_at)
    {
        $stmt = $this->db->prepare(
            "UPDATE enrollments SET student_id = ?, course_id = ?, status = ?, grade = ?, enrolled_at = ? WHERE id = ?"
        );
        return $stmt->execute([$student_id, $course_id, $status, $grade, $enrolled_at, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM enrollments WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
