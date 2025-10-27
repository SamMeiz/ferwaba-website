<?php
require_once __DIR__ . '/../includes/config.php';
require_login();

$id = isset($_GET['id']) && ctype_digit($_GET['id']) ? (int)$_GET['id'] : 0;
$editing = $id > 0;

$name = '';
$description = '';
$category = 'Jerseys';
$price = '0.00';
$image = '';
$is_active = 1;
$team_id = null;
$gender = 'Unisex';
$error = '';

if ($editing) {
    $stmt = $mysqli->prepare("SELECT name,description,category,price,image,is_active,team_id,gender FROM shop_items WHERE id=? LIMIT 1");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {
        $name = $row['name'];
        $description = $row['description'];
        $category = $row['category'];
        $price = $row['price'];
        $image = $row['image'];
        $is_active = (int)$row['is_active'];
        $team_id = $row['team_id'];
        $gender = $row['gender'];
    } else { die('Shop item not found'); }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $category = in_array($_POST['category'] ?? '', ['Jerseys','Kits','Gear']) ? $_POST['category'] : 'Jerseys';
    $price = (string)($_POST['price'] ?? '0');
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    $team_id = !empty($_POST['team_id']) ? (int)$_POST['team_id'] : null;
    $gender = in_array($_POST['gender'] ?? '', ['Men','Women','Unisex']) ? $_POST['gender'] : 'Unisex';

    if (!$name) $error = 'Name is required.';

    $uploadFileName = $image;

    if (!$error && isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
        if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

            if (!in_array($ext, $allowed)) {
                $error = 'Invalid file type. Only JPG, PNG, GIF, WEBP allowed.';
            } else {
                $safe = 'shop_'.time().'_'.bin2hex(random_bytes(4)).'.'.$ext;
                $dir = __DIR__.'/uploads/'; // Save inside admin/uploads

                if (!is_dir($dir)) mkdir($dir, 0755, true);

                if (move_uploaded_file($_FILES['image']['tmp_name'], $dir.$safe)) {
                    $uploadFileName = $safe;
                } else {
                    $error = 'Image upload failed. Check directory permissions.';
                }
            }
        } else {
            $error = 'Upload error code: ' . $_FILES['image']['error'];
        }
    }

    if (!$error) {
        if ($editing) {
            $stmt = $mysqli->prepare("UPDATE shop_items 
                SET name=?,description=?,category=?,price=?,image=?,is_active=?,team_id=?,gender=? 
                WHERE id=? LIMIT 1");
            $stmt->bind_param('sssssiisi', $name, $description, $category, $price, $uploadFileName, $is_active, $team_id, $gender, $id);
            if ($stmt->execute()) redirect('shop.php'); else $error='Save failed.';
        } else {
            $stmt = $mysqli->prepare("INSERT INTO shop_items(name,description,category,price,image,is_active,team_id,gender) 
                VALUES(?,?,?,?,?,?,?,?)");
            $stmt->bind_param('sssssiis', $name, $description, $category, $price, $uploadFileName, $is_active, $team_id, $gender);
            if ($stmt->execute()) redirect('shop.php'); else $error='Create failed.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo $editing ? 'Edit' : 'Add'; ?> Shop Item - FERWABA</title>
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family:Arial,sans-serif; background:#f4f4f4; padding:20px; min-height:100vh; }
.container { max-width:720px; margin:24px auto; }
.card { background:#fff; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.1); padding:30px; }
.card h2 { margin-bottom:20px; color:#333; font-size:24px; }
.form-group { margin-bottom:20px; }
.form-group label { display:block; margin-bottom:8px; font-weight:bold; font-size:14px; color:#333; }
.form-control, select, textarea { padding:12px; border:1px solid #ddd; border-radius:4px; width:100%; font-size:14px; }
textarea { resize:vertical; }
.form-control:focus, select:focus, textarea:focus { outline:none; border-color:#0047AB; }
.btn { padding:12px 24px; border:none; border-radius:4px; cursor:pointer; font-size:14px; font-weight:bold; text-decoration:none; display:inline-block; transition:all 0.3s; }
.btn-primary { background:#0047AB; color:#fff; }
.btn-primary:hover { background:#003580; }
.btn-secondary { background:#6c757d; color:#fff; }
.btn-secondary:hover { background:#5a6268; }
.alert { background:#f8d7da; color:#721c24; padding:15px; border-radius:4px; margin-bottom:20px; border:1px solid #f5c6cb; }
.grid { display:grid; gap:15px; }
.grid.col-2 { grid-template-columns:1fr 1fr; }
@media (max-width:600px) { .grid.col-2 { grid-template-columns:1fr; } }
.muted { font-size:13px; color:#666; margin-top:6px; font-style:italic; }
.button-group { margin-top:30px; display:flex; gap:12px; padding-top:20px; border-top:1px solid #eee; }
input[type="checkbox"] { width:auto; margin-right:8px; }
</style>
</head>
<body>
<div class="container">
  <div class="card">
    <h2><?php echo $editing ? 'Edit' : 'Add'; ?> Shop Item</h2>

    <?php if ($error): ?>
      <div class="alert"><?php echo sanitize($error); ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label for="name">Name *</label>
        <input type="text" id="name" name="name" value="<?php echo sanitize($name); ?>" required class="form-control">
      </div>

      <div class="grid col-2">
        <div class="form-group">
          <label for="category">Category</label>
          <select id="category" name="category" class="form-control">
            <option value="Jerseys" <?php echo $category==='Jerseys'?'selected':''; ?>>Jerseys</option>
            <option value="Kits" <?php echo $category==='Kits'?'selected':''; ?>>Kits</option>
            <option value="Gear" <?php echo $category==='Gear'?'selected':''; ?>>Gear</option>
          </select>
        </div>
        <div class="form-group">
          <label for="price">Price (RWF)</label>
          <input type="number" step="0.01" id="price" name="price" value="<?php echo sanitize((string)$price); ?>" class="form-control">
        </div>
      </div>

      <div class="grid col-2">
        <div class="form-group">
          <label for="gender">Gender</label>
          <select id="gender" name="gender" class="form-control">
            <option value="Men" <?php echo $gender==='Men'?'selected':''; ?>>Men</option>
            <option value="Women" <?php echo $gender==='Women'?'selected':''; ?>>Women</option>
            <option value="Unisex" <?php echo $gender==='Unisex'?'selected':''; ?>>Unisex</option>
          </select>
        </div>

        <div class="form-group">
          <label for="team_id">Team</label>
          <select id="team_id" name="team_id" class="form-control">
            <option value="">None</option>
            <?php
            $teams = $mysqli->query("SELECT id, name FROM teams ORDER BY name ASC");
            if ($teams) {
                while($t = $teams->fetch_assoc()): ?>
                    <option value="<?php echo $t['id']; ?>" <?php echo ($team_id==$t['id'])?'selected':''; ?>>
                        <?php echo sanitize($t['name']); ?>
                    </option>
                <?php endwhile;
            }
            ?>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label for="image">Image</label>
        <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/gif,image/webp" class="form-control">
        <?php if($image): ?>
          <div class="muted">Current: <img src="uploads/<?php echo sanitize($image); ?>" style="height:60px; border-radius:4px;"></div>
        <?php endif; ?>
      </div>

      <div class="form-group">
        <label>
          <input type="checkbox" name="is_active" <?php echo $is_active?'checked':''; ?>> Active (Show in shop)
        </label>
      </div>

      <div class="form-group">
        <label for="description">Description</label>
        <textarea id="description" name="description" rows="5" class="form-control"><?php echo sanitize($description); ?></textarea>
      </div>

      <div class="button-group">
        <button type="submit" class="btn btn-primary"><?php echo $editing ? 'Update Item' : 'Create Item'; ?></button>
        <a href="shop.php" class="btn btn-secondary">Cancel</a>
      </div>
    </form>
  </div>
</div>
</body>
</html>
