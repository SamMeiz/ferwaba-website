<?php require_once __DIR__ . '/../includes/config.php';
require_login();

$id = isset($_GET['id']) && ctype_digit($_GET['id']) ? (int)$_GET['id'] : 0; $editing = $id>0;
$title=''; $content=''; $category='Latest'; $image=''; $video_url=''; $error='';

if ($editing) {
  $stmt=$mysqli->prepare("SELECT title,content,category,image,video_url FROM news WHERE id=? LIMIT 1");
  $stmt->bind_param('i',$id); $stmt->execute(); $res=$stmt->get_result();
  if($row=$res->fetch_assoc()){ $title=$row['title']; $content=$row['content']; $category=$row['category']; $image=$row['image']; $video_url=$row['video_url']; } else { die('Not found'); }
}

if($_SERVER['REQUEST_METHOD']==='POST'){
  $title=trim($_POST['title']??''); $content=trim($_POST['content']??'');
  $category=in_array(($_POST['category']??''),['Latest','Transfers','Injuries','Squad Updates'])?$_POST['category']:'Latest';
  $video_url=trim($_POST['video_url']??'');
  if(!$title || !$content){ $error='Title and content are required.'; }

  $uploadFileName=$image;
  if(!$error && isset($_FILES['image']) && $_FILES['image']['error']!==UPLOAD_ERR_NO_FILE){
    if($_FILES['image']['error']===UPLOAD_ERR_OK){
      $ext=pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION);
      $safe='news_'.time().'_'.bin2hex(random_bytes(4)).'.'.strtolower($ext);
      $dir=__DIR__.'/uploads/'; if(!is_dir($dir)){ mkdir($dir,0755,true);} 
      if(move_uploaded_file($_FILES['image']['tmp_name'],$dir.$safe)){ $uploadFileName=$safe; } else { $error='Image upload failed.'; }
    } else { $error='Upload error.'; }
  }

  if(!$error){
    if($editing){
      $stmt=$mysqli->prepare("UPDATE news SET title=?,content=?,category=?,image=?,video_url=? WHERE id=? LIMIT 1");
      $stmt->bind_param('sssssi',$title,$content,$category,$uploadFileName,$video_url,$id);
      if($stmt->execute()){ redirect('/admin/news.php'); } else { $error='Save failed.'; }
    } else {
      $stmt=$mysqli->prepare("INSERT INTO news(title,content,category,image,video_url) VALUES(?,?,?,?,?)");
      $stmt->bind_param('sssss',$title,$content,$category,$uploadFileName,$video_url);
      if($stmt->execute()){ redirect('/admin/news.php'); } else { $error='Create failed.'; }
    }
  }
}
?>
<!DOCTYPE html>
<html lang=\"en\">
<head>
  <meta charset=\"UTF-8\">
  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
  <title><?php echo $editing?'Edit':'Add'; ?> News - FERWABA</title>
  <link rel=\"stylesheet\" href=\"<?php echo asset_url('../css/style.css'); ?>\">
</head>
<body>
<div class=\"container\" style=\"max-width:840px;margin:24px auto\">
  <div class=\"card\"><div class=\"card-body\">
    <h2 style=\"margin:0 0 12px\"><?php echo $editing?'Edit':'Add'; ?> Article</h2>
    <?php if($error): ?><div style=\"color:#b91c1c;margin-bottom:8px\"><?php echo sanitize($error); ?></div><?php endif; ?>
    <form method=\"post\" enctype=\"multipart/form-data\">
      <div style=\"margin-bottom:8px\"><label>Title</label><input type=\"text\" name=\"title\" value=\"<?php echo sanitize($title); ?>\" required style=\"width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:8px\"></div>
      <div style=\"margin-bottom:8px\"><label>Category</label>
        <select name=\"category\">
          <option <?php echo $category==='Latest'?'selected':''; ?>>Latest</option>
          <option <?php echo $category==='Transfers'?'selected':''; ?>>Transfers</option>
          <option <?php echo $category==='Injuries'?'selected':''; ?>>Injuries</option>
          <option <?php echo $category==='Squad Updates'?'selected':''; ?>>Squad Updates</option>
        </select>
      </div>
      <div style=\"margin-bottom:8px\"><label>Image</label><input type=\"file\" name=\"image\" accept=\"image/*\"><?php if($image): ?><div class=\"muted\">Current: <?php echo sanitize($image); ?></div><?php endif; ?></div>
      <div style=\"margin-bottom:8px\"><label>YouTube URL</label><input type=\"text\" name=\"video_url\" value=\"<?php echo sanitize($video_url); ?>\" placeholder=\"https://www.youtube.com/watch?v=...\" style=\"width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:8px\"></div>
      <div style=\"margin-bottom:12px\"><label>Content</label><textarea name=\"content\" rows=\"8\" style=\"width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:8px\"><?php echo sanitize($content); ?></textarea></div>
      <div><button class=\"btn\" type=\"submit\">Save</button><a class=\"btn\" href=\"/admin/news.php\" style=\"margin-left:8px\">Cancel</a></div>
    </form>
  </div></div>
</div>
</body>
</html>
<?php require_once __DIR__ . '/includes/header.php'; ?>