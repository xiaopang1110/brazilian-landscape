<?php
$querystring=$_POST['querystring'];
include '../controllers/ajaxcontroler.php';
$admin = new Ajaxcontroler();
$enc_str=$admin->encrypt_decrypt("decrypt",$querystring);
$val=explode("=",$enc_str);
$id=$val[1];

$category=$admin->getcategory($id);

?>
<input type="hidden" name="id" value="<?php echo $category->category_id;?>"/>
<input type="hidden" name="image" value="<?php echo $category->image;?>"/>

<div class="form-group">
    <label class="col-md-3 control-label">Category Name: </label>
    <div class="col-md-9">
        <input type="text" name="name" value="<?php echo $category->name;?>" class="form-control" placeholder="Category Name" />
    </div>
</div>
<div class="form-group">
                            <label class="col-md-3 control-label">Category Image: </label>
                            <div class="col-md-9">
                               <input type="file" name="file" class="form-control" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Selected Image: </label>
                            <div class="col-md-9">
                               <img src="uploads/<?php echo $category->image;?>" style="height: 100px">
                            </div>
                        </div>
