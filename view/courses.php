<h2>Courses</h2>

<form method="post" action="index.php?page=courses" class="card">
    <h3><?= $editData ? 'Edit Course' : 'Tambah Course' ?></h3>
    <input type="hidden" name="action" value="<?= $editData ? 'update' : 'create' ?>">
    <input type="hidden" name="id" value="<?= e($editData['id'] ?? '') ?>">

    <label>Kode</label>
    <input type="text" name="code" value="<?= e($editData['code'] ?? '') ?>" required>
    <label>Nama Mata Kuliah</label>
    <input type="text" name="name" value="<?= e($editData['name'] ?? '') ?>" required>
    <label>SKS</label>
    <input type="number" name="credits" min="1" max="6" value="<?= e($editData['credits'] ?? 3) ?>" required>
    <label>Dosen Pengampu</label>
    <select name="instructor_id" required>
        <option value="">-- Pilih Dosen --</option>
        <?php foreach ($instructor->getAll() as $i): ?>
            <option value="<?= e($i['id']) ?>" <?= (($editData['instructor_id'] ?? '') == $i['id']) ? 'selected' : '' ?>>
                <?= e($i['name']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit"><?= $editData ? 'Update' : 'Simpan' ?></button>
    <?php if ($editData): ?><a class="btn-cancel" href="index.php?page=courses">Batal</a><?php endif; ?>
</form>

<table>
    <tr><th>ID</th><th>Kode</th><th>Nama</th><th>SKS</th><th>Dosen</th><th>Aksi</th></tr>
    <?php foreach ($course->getAll() as $row): ?>
    <tr>
        <td><?= e($row['id']) ?></td>
        <td><?= e($row['code']) ?></td>
        <td><?= e($row['name']) ?></td>
        <td><?= e($row['credits']) ?></td>
        <td><?= e($row['instructor_name']) ?></td>
        <td>
            <a href="index.php?page=courses&edit=<?= e($row['id']) ?>">Edit</a>
            <form method="post" action="index.php?page=courses" class="inline" onsubmit="return confirm('Hapus data ini?')">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?= e($row['id']) ?>">
                <button type="submit" class="danger">Hapus</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
