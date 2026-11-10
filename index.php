<?php
session_start();

require_once 'config/db.php';
require_once 'class/Instructor.php';
require_once 'class/Student.php';
require_once 'class/Course.php';
require_once 'class/Enrollment.php';

// helper untuk escape output HTML (cegah XSS)
function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

// koneksi + instansiasi class
$database   = new Database();
$db         = $database->getConnection();
$instructor = new Instructor($db);
$student    = new Student($db);
$course     = new Course($db);
$enrollment = new Enrollment($db);

// routing sederhana (whitelist halaman)
$pages = ['courses', 'instructors', 'students', 'enrollments'];
$page  = $_GET['page'] ?? 'courses';
if (!in_array($page, $pages, true)) {
    $page = 'courses';
}

// ====== HANDLE AKSI (CREATE / UPDATE / DELETE) ======
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id     = (int) ($_POST['id'] ?? 0);

    try {
        switch ($page) {
            case 'instructors':
                $name = trim($_POST['name'] ?? '');
                $email = trim($_POST['email'] ?? '');
                $expertise = trim($_POST['expertise'] ?? '');
                if ($action === 'create' || $action === 'update') {
                    if ($name === '' || $email === '' || $expertise === '') {
                        throw new InvalidArgumentException('Semua field wajib diisi.');
                    }
                }
                if ($action === 'create') $instructor->create($name, $email, $expertise);
                elseif ($action === 'update') $instructor->update($id, $name, $email, $expertise);
                elseif ($action === 'delete') $instructor->delete($id);
                break;

            case 'students':
                $nim = trim($_POST['nim'] ?? '');
                $name = trim($_POST['name'] ?? '');
                $email = trim($_POST['email'] ?? '');
                if ($action === 'create' || $action === 'update') {
                    if ($nim === '' || $name === '' || $email === '') {
                        throw new InvalidArgumentException('Semua field wajib diisi.');
                    }
                }
                if ($action === 'create') $student->create($nim, $name, $email);
                elseif ($action === 'update') $student->update($id, $nim, $name, $email);
                elseif ($action === 'delete') $student->delete($id);
                break;

            case 'courses':
                $code = trim($_POST['code'] ?? '');
                $name = trim($_POST['name'] ?? '');
                $credits = (int) ($_POST['credits'] ?? 0);
                $instructor_id = (int) ($_POST['instructor_id'] ?? 0);
                if ($action === 'create' || $action === 'update') {
                    if ($code === '' || $name === '' || $credits < 1 || $instructor_id < 1) {
                        throw new InvalidArgumentException('Semua field wajib diisi dengan benar.');
                    }
                }
                if ($action === 'create') $course->create($code, $name, $credits, $instructor_id);
                elseif ($action === 'update') $course->update($id, $code, $name, $credits, $instructor_id);
                elseif ($action === 'delete') $course->delete($id);
                break;

            case 'enrollments':
                $student_id = (int) ($_POST['student_id'] ?? 0);
                $course_id = (int) ($_POST['course_id'] ?? 0);
                $status = $_POST['status'] ?? 'active';
                $grade = ($_POST['grade'] ?? '') === '' ? null : (float) $_POST['grade'];
                $enrolled_at = $_POST['enrolled_at'] ?? date('Y-m-d');
                if ($action === 'create' || $action === 'update') {
                    if ($student_id < 1 || $course_id < 1) {
                        throw new InvalidArgumentException('Mahasiswa dan mata kuliah wajib dipilih.');
                    }
                    if (!in_array($status, ['active', 'completed', 'dropped'], true)) {
                        throw new InvalidArgumentException('Status tidak valid.');
                    }
                    if ($grade !== null && ($grade < 0 || $grade > 100)) {
                        throw new InvalidArgumentException('Nilai harus 0 - 100.');
                    }
                }
                if ($action === 'create') $enrollment->create($student_id, $course_id, $status, $grade, $enrolled_at);
                elseif ($action === 'update') $enrollment->update($id, $student_id, $course_id, $status, $grade, $enrolled_at);
                elseif ($action === 'delete') $enrollment->delete($id);
                break;
        }
        $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Operasi berhasil dijalankan.'];
    } catch (InvalidArgumentException $ex) {
        $_SESSION['flash'] = ['type' => 'error', 'msg' => $ex->getMessage()];
    } catch (PDOException $ex) {
        $msg = ($ex->getCode() === '23000')
            ? 'Gagal: data duplikat atau masih dipakai oleh data lain (foreign key).'
            : 'Terjadi kesalahan database.';
        $_SESSION['flash'] = ['type' => 'error', 'msg' => $msg];
    }

    // Post-Redirect-Get supaya form tidak ter-submit ulang saat refresh
    header("Location: index.php?page=$page");
    exit;
}

// ====== MODE EDIT (isi form dari data lama) ======
$editData = null;
if (isset($_GET['edit'])) {
    $editId = (int) $_GET['edit'];
    $models = [
        'instructors' => $instructor,
        'students'    => $student,
        'courses'     => $course,
        'enrollments' => $enrollment,
    ];
    $editData = $models[$page]->getById($editId) ?: null;
}

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

// ====== TAMPILKAN VIEW ======
include 'view/header.php';
include "view/$page.php";
include 'view/footer.php';
