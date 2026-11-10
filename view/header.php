<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Course Management System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>Course Management System</h1>
    <nav>
        <a href="index.php?page=courses" class="<?= $page === 'courses' ? 'active' : '' ?>">Courses</a>
        <a href="index.php?page=instructors" class="<?= $page === 'instructors' ? 'active' : '' ?>">Instructors</a>
        <a href="index.php?page=students" class="<?= $page === 'students' ? 'active' : '' ?>">Students</a>
        <a href="index.php?page=enrollments" class="<?= $page === 'enrollments' ? 'active' : '' ?>">Enrollments</a>
    </nav>
</header>
<main>
<?php if ($flash): ?>
    <div class="flash <?= e($flash['type']) ?>"><?= e($flash['msg']) ?></div>
<?php endif; ?>
