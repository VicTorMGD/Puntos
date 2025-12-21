<table class="table table-bordered" id="productTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Categoría</th>
            <th>Precio</th>
            <th>Imagen</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $p): ?>
            <tr>
                <td><?= $p['id'] ?></td>
                <td><?= esc($p['name']) ?></td>
                <td><?= esc($p['category_name']) ?></td>
                <td>S/ <?= number_format($p['price'], 2) ?></td>
                <td>
                    <?php if ($p['image']): ?>
                        <img src="<?= base_url('uploads/' . $p['image']) ?>" width="60">
                    <?php else: ?>
                        <small>Sin imagen</small>
                    <?php endif ?>
                </td>
                <td><?= esc($p['name']) ?></td>
                <td><?= esc($p['category_name']) ?></td>
                <td>S/. <?= esc($p['price']) ?></td>
                <td>
                    <a href="<?= base_url('products/edit/' . $p['id']) ?>" class="btn btn-primary btn-sm">Editar</a>

                    <a href="#" data-url="<?= base_url('products/delete/' . $p['id']) ?>"
                        class="btn btn-danger btn-sm btn-delete">Eliminar</a>

                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>