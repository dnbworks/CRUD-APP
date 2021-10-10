<div class="container my-50">
    <p>
        <a href="/products/create" class="btn btn-success">Add Product</a>
    </p>
    <form>
        <div class="input-group mb-3">
        <input type="text" name="search" class="form-control" placeholder="Search for products" value="<?php echo $keyword ?>">
        <div class="input-group-append">
            <button class="btn btn-success" type="submit">Search</button>
        </div>
        </div>
    </form>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Image</th>
            <th scope="col">Title</th>
            <th scope="col">Price</th>
            <th scope="col">Create Date</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($products as $i => $product) { ?>
            <tr>
                <th scope="row"><?php echo $i + 1 ?></th>
                <td>
                    <?php if($product['image']): ?>   
                        <img src="/<?php echo $product['image'] ?>" alt="<?php echo $product['title'] ?>" class="thumb-image ">
                    <?php else: ?>
                        <img src="/images/profile.jpg" class="thumb-image ">
                    <?php endif; ?>
                </td>
                <td><?php echo $product['title'] ?></td>
                <td><?php echo $product['price'] ?></td>
                <td><?php echo $product['create_date'] ?></td>
                <td>
                    <a href="products/update?id=<?php echo $product['id'] ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                    <form action="/products/delete" method="post" style="display:inline-block">
                        <input type="hidden" name="id" value="<?php echo $product['id'] ?>">
                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

    <?= $links ?>
</div>