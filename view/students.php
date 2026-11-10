<h2>Students</h2>

<form method="post" action="index.php?page=students" class="card">
    <h3><?= $editData ? 'Edit Student' : 'Tambah Student' ?></h3>
    <input type="hidden" name="action" value="<?= $editData ? 'update' : 'create' ?>">
    <input type="hidden" name="id" value="<?= e($editData['id'] ?? '') ?>">

    <label>NIM</label>
    <input type="text" name="nim" value="<?= e($editData['nim'] ?? '') ?>" required>
    <label>Nama</label>
    <input type="text" name="name" value="<?= e($editData['name'] ?? '') ?>" required>
    <label>Email</label>
    <input type="email" name="email" value="<?= e($editData['email'] ?? '') ?>" required>

    <button type="submit"><?= $editData ? 'Update' : 'Simpan' ?></button>
    <?php if ($editData): ?><a class="btn-cancel" href="index.php?page=students">Batal</a><?php endif; ?>
</form>

<table>
    <tr><th>ID</th><th>NIM</th><th>Nama</th><th>Email</th><th>Aksi</th></tr>
    <?php foreach ($student->getAll() as $row): ?>
    <tr>
        <td><?= e($row['id']) ?></td>
        <td><?= e($row['nim']) ?></td>
        <td><?= e($row['name']) ?></td>
        <td><?= e($row['email']) ?></td>
        <td>
            <a href="index.php?page=students&edit=<?= e($row['id']) ?>">Edit</a>
            <form method="post" action="index.php?page=students" class="inline" onsubmit="return confirm('Hapus data ini?')">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?= e($row['id']) ?>">
                <button type="submit" class="danger">Hapus</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
