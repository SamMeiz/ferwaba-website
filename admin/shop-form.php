<?php require_once __DIR__ . '/../includes/config.php';
require_login();

$id = isset($_GET['id']) && ctype_digit($_GET['id']) ? (int)$_GET['id'] : 0; $editing=$id>0;
$name=''; $description=''; $category='Jerseys'; $price='0.00'; $image=''; $is_active=1; $error='';

if($editing){
  $stmt=$mysqli->prepare("SELECT name,description,category,price,image,is_active FROM shop_items WHERE id=? LIMIT 1");
  $stmt->bind_param('i',$id); $stmt->execute(); $res=$stmt->get_result();
  if($row=$res->fetch_assoc()){ $name=$row['name']; $description=$row['description']; $category=$row['category']; $price=$row['price']; $image=$row['image']; $is_active=(int)$row['is_active']; } else { die('Not found'); }
}

if($_SERVER['REQUEST_METHOD']==='POST'){
  $name=trim($_POST['name']??''); $description=trim($_POST['description']??'');
  $category=in_array(($_POST['category']??''),['Jerseys','Kits','Gear'])?$_POST['category']:'Jerseys';
  $price=(string)($_POST['price']??'0'); $is_active=isset($_POST['is_active'])?1:0;
  if(!$name){ $error='Name is required.'; }
  $uploadFileName=$image;
  if(!$error && isset($_FILES['image']) && $_FILES['image']['error']!==UPLOAD_ERR_NO_FILE){
    if($_FILES['image']['error']===UPLOAD_ERR_OK){
      $ext=pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION);
      $safe='shop_'.time().'_'.bin2hex(random_bytes(4)).'.'.strtolower($ext);
      $dir=__DIR__.'/uploads/'; if(!is_dir($dir)){ mkdir($dir,0755,true);} 
      if(move_uploaded_file($_FILES['image']['tmp_name'],$dir.$safe)){ $uploadFileName=$safe; } else { $error='Image upload failed.'; }
    } else { $error='Upload error.'; }
  }
  if(!$error){
    if($editing){
      $stmt=$mysqli->prepare("UPDATE shop_items SET name=?,description=?,category=?,price=?,image=?,is_active=? WHERE id=? LIMIT 1");
      $stmt->bind_param('ssssssi',$name,$description,$category,$price,$uploadFileName,$is_active,$id);
      if($stmt->execute()){ redirect('shop.php'); } else { $error='Save failed.'; }
    } else {
      $stmt=$mysqli->prepare("INSERT INTO shop_items(name,description,category,price,image,is_active) VALUES(?,?,?,?,?,?)");
      $stmt->bind_param('sssssi',$name,$description,$category,$price,$uploadFileName,$is_active);
      if($stmt->execute()){ redirect('shop.php'); } else { $error='Create failed.'; }
    }
  }
}
?>
<!DOCTYPE html>
<html lang=\"en\">
<head>
  <meta charset=\"UTF-8\">
  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
  <title><?php echo $editing?'Edit':'Add'; ?> Item - FERWABA</title>
  <link rel=\"stylesheet\" href=\"../css/style.css\">
</head>
<body>
<div class=\"container\" style=\"max-width:720px;margin:24px auto\">
  <div class=\"card\"><div class=\"card-body\">
    <h2 style=\"margin:0 0 12px\"><?php echo $editing?'Edit':'Add'; ?> Item</h2>
    <?php if($error): ?><div style=\"color:#b91c1c;margin-bottom:8px\"><?php echo sanitize($error); ?></div><?php endif; ?>
    <form method=\"post\" enctype=\"multipart/form-data\">
      <div style=\"margin-bottom:8px\"><label>Name</label><input type=\"text\" name=\"name\" value=\"<?php echo sanitize($name); ?>\" required style=\"width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:8px\"></div>
      <div class=\"grid col-2\" style=\"margin-bottom:8px\">
        <div><label>Category</label>
          <select name=\"category\">
            <option <?php echo $category==='Jerseys'?'selected':''; ?>>Jerseys</option>
            <option <?php echo $category==='Kits'?'selected':''; ?>>Kits</option>
            <option <?php echo $category==='Gear'?'selected':''; ?>>Gear</option>
          </select>
        </div>
        <div><label>Price (RWF)</label><input type=\"number\" step=\"0.01\" name=\"price\" value=\"<?php echo sanitize((string)$price); ?>\" style=\"width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:8px\"></div>
      </div>
      <div style=\"margin-bottom:8px\"><label>Image</label><input type=\"file\" name=\"image\" accept=\"image/*\"><?php if($image): ?><div class=\"muted\">Current: <?php echo sanitize($image); ?></div><?php endif; ?></div>
      <div style=\"margin-bottom:8px\"><label><input type=\"checkbox\" name=\"is_active\" <?php echo $is_active?'checked':''; ?>> Active</label></div>
      <div style=\"margin-bottom:12px\"><label>Description</label><textarea name=\"description\" rows=\"5\" style=\"width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:8px\"><?php echo sanitize($description); ?></textarea></div>
      <div><button class=\"btn\" type=\"submit\">Save</button><a class=\"btn\" href=\"/admin/shop.php\" style=\"margin-left:8px\">Cancel</a></div>
    </form>
  </div></div>
</div>
</body>
</html>


