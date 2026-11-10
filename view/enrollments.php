<h2>Enrollments</h2>

<form method="post" action="index.php?page=enrollments" class="card">
    <h3><?= $editData ? 'Edit Enrollment' : 'Tambah Enrollment' ?></h3>
    <input type="hidden" name="action" value="<?= $editData ? 'update' : 'create' ?>">
    <input type="hidden" name="id" value="<?= e($editData['id'] ?? '') ?>">

    <label>Mahasiswa</label>
    <select name="student_id" required>
        <option value="">-- Pilih Mahasiswa --</option>
        <?php foreach ($student->getAll() as $s): ?>
            <option value="<?= e($s['id']) ?>" <?= (($editData['student_id'] ?? '') == $s['id']) ? 'selected' : '' ?>>
                <?= e($s['nim'] . ' - ' . $s['name']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Mata Kuliah</label>
    <select name="course_id" required>
        <option value="">-- Pilih Mata Kuliah --</option>
        <?php foreach ($course->getAll() as $c): ?>
            <option value="<?= e($c['id']) ?>" <?= (($editData['course_id'] ?? '') == $c['id']) ? 'selected' : '' ?>>
                <?= e($c['code'] . ' - ' . $c['name']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Status</label>
    <select name="status">
        <?php foreach (['active', 'completed', 'dropped'] as $st): ?>
            <option value="<?= $st ?>" <?= (($editData['status'] ?? 'active') === $st) ? 'selected' : '' ?>><?= ucfirst($st) ?></option>
        <?php endforeach; ?>
    </select>

    <label>Nilai (0-100, boleh kosong)</label>
    <input type="number" name="grade" step="0.01" min="0" max="100" value="<?= e($editData['grade'] ?? '') ?>">

    <label>Tanggal Daftar</label>
    <input type="date" name="enrolled_at" value="<?= e($editData['enrolled_at'] ?? date('Y-m-d')) ?>" required>

    <button type="submit"><?= $editData ? 'Update' : 'Simpan' ?></button>
    <?php if ($editData): ?><a class="btn-cancel" href="index.php?page=enrollments">Batal</a><?php endif; ?>
</form>

<table>
    <tr><th>ID</th><th>Mahasiswa</th><th>Mata Kuliah</th><th>Status</th><th>Nilai</th><th>Tgl Daftar</th><th>Aksi</th></tr>
    <?php foreach ($enrollment->getAll() as $row): ?>
    <tr>
        <td><?= e($row['id']) ?></td>
        <td><?= e($row['nim'] . ' - ' . $row['student_name']) ?></td>
        <td><?= e($row['code'] . ' - ' . $row['course_name']) ?></td>
        <td><?= e(ucfirst($row['status'])) ?></td>
        <td><?= $row['grade'] === null ? '-' : e($row['grade']) ?></td>
        <td><?= e($row['enrolled_at']) ?></td>
        <td>
            <a href="index.php?page=enrollments&edit=<?= e($row['id']) ?>">Edit</a>
            <form method="post" action="index.php?page=enrollments" class="inline" onsubmit="return confirm('Hapus data ini?')">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?= e($row['id']) ?>">
                <button type="submit" class="danger">Hapus</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
