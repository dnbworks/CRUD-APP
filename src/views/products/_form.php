

<?php if(!empty($errors)) { ?>
    <div class="alert alert-danger">
        <?php foreach($errors as $error) { ?>
            <div><?php echo $error?></div>
        <?php } ?>
    </div>
<?php } ?>

<form action="" method="post" enctype="multipart/form-data">
    <?php if (is_file($product['image']) && filesize($product['image']) > 0): ?>
        <img src="/<?php echo $product['image'] ?>" alt="<?php echo $product['title'] ?>" class="updated-image">
    <?php endif; ?>

    <div class="form-group">
        <label>Product Image</label><br>
        <input type="file" name="image">
    </div>
    <div class="form-group">
        <label>Product title</label>
        <input type="text" name="title" class="form-control" value="<?php echo $product['title']; ?>">
    </div>
    <div class="form-group">
        <label>Product description</label>
        <textarea class="form-control" name="description"><?php echo $product['description']; ?></textarea>
    </div>
    <div class="form-group">
        <label>Product price</label>
        <input type="number" step=".01" name="price" class="form-control" value="<?php echo $product['price']; ?>">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>