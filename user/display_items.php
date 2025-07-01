<?php
$items = $conn->query("SELECT * FROM recommended_items");
?>

<div class="container mt-5">
    <h3>Recommended Items</h3>
    <div class="row">
        <?php while ($item = $items->fetch_assoc()) { ?>
            <div class="col-md-4">
                <div class="card">
                    <img src="<?= $item['logo_applied_path'] ?>" class="card-img-top" alt="<?= $item['item_name'] ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= $item['item_name'] ?></h5>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
