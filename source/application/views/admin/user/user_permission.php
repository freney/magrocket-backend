
<input	type="hidden" name="user_id" id="user_id" value="<?php echo $user['id']; ?>" />
<p>
	<strong>Administrator levels</strong>
</p>
<label class="checkbox inline"> 
	<input type="checkbox" id="user_user_management" value="1" <?php if ((int)$user['user_manage_flag'] == 1 || (int)$user['user_manage_flag'] == 3){ ?> checked="checked" <?php } ?> /> User management 
</label>
<label class="checkbox inline"> 
	<input type="checkbox" id="user_database_management" value="2" <?php if ((int)$user['user_manage_flag'] == 2  || (int)$user['user_manage_flag'] == 3){ ?> checked="checked" <?php } ?> /> Database management
</label>
<br />
<br />
<p>
	<strong>Manage Tables</strong>
</p>
<table class="table table-bordered table-condensed" style="width: auto;">
	<thead>
		<tr>
			<th
				style="width: 30px; cursor: default; color: #333333; text-shadow: 0 1px 0 #FFFFFF; background-color: #e6e6e6;">No.</th>
			<th
				style="width: 300px; cursor: default; color: #333333; text-shadow: 0 1px 0 #FFFFFF; background-color: #e6e6e6;">Table name</th>
			<th
				style="width: 50px; cursor: default; color: #333333; text-shadow: 0 1px 0 #FFFFFF; background-color: #e6e6e6;">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<?php $i = 0; foreach($tables as $k => $table){ 
			if ($table == 'cruds')
				continue;
			if (strpos($table, 'crud_') !== false)
				continue;
			$i++;
			?>
		<tr>
			<td style="text-align: center;"><?php echo $i ?></td>
			<td><?php echo $table; ?></td>
			<td style="text-align: center;"><input type="hidden"
				name="table_name" id="table_name" value="<?php echo $table; ?>" />
				<div style="width: 500px;">
					<label class="checkbox inline"> <input type="checkbox" value="1"
						name="add"
						<?php if (isset($pt[$user['id'].'_'.$table.'_1']) && (int)$pt[$user['id'].'_'.$table.'_1'] == 1){ ?>
						checked="checked" <?php } ?> /> Add
					</label> <label class="checkbox inline"> <input type="checkbox"
						value="2" name="edit"
						<?php if (isset($pt[$user['id'].'_'.$table.'_2']) && (int)$pt[$user['id'].'_'.$table.'_2'] == 2){ ?>
						checked="checked" <?php } ?> /> Edit
					</label> <label class="checkbox inline"> <input type="checkbox"
						value="3" name="delete"
						<?php if (isset($pt[$user['id'].'_'.$table.'_3']) && (int)$pt[$user['id'].'_'.$table.'_3'] == 3){ ?>
						checked="checked" <?php } ?> /> Delete
					</label> <label class="checkbox inline"> <input type="checkbox"
						value="4" name="read"
						<?php if (isset($pt[$user['id'].'_'.$table.'_4']) && (int)$pt[$user['id'].'_'.$table.'_4'] == 4){ ?>
						checked="checked" <?php } ?> /> Export/List/Search/View
					</label> <label class="checkbox inline"> <input type="checkbox"
						value="5" name="configure"
						<?php if (isset($pt[$user['id'].'_'.$table.'_5']) && (int)$pt[$user['id'].'_'.$table.'_5'] == 5){ ?>
						checked="checked" <?php } ?> /> Configure
					</label>
				</div>
			</td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<br />
<div style="padding-left: 300px;">
	<input type="button" class="btn btn-primary" value="Save" id="btn_save" />
</div>
<script type="text/javascript">
$(document).ready(function(){
    $('#btn_save').click(function(){
        var data = [];
        $('#user_permission_container').each(function(){
            var obj = {};
            obj.user_id = $(this).children('#user_id').val();
            obj.user_manage_flag = 0;
            obj.tables = [];
            if ($(this).find('input[id="user_user_management"]:checked').val() == '1'){
                obj.user_manage_flag = obj.user_manage_flag + 1;
            }
            
            if ($(this).find('input[id="user_database_management"]:checked').val() == '2'){
                obj.user_manage_flag = obj.user_manage_flag + 2;
            }
            $(this).find('table > tbody > tr').each(function(){
                var tbl = {}
                var per = {add:0,edit:0,del:0,read:0,configure:0};

                if ($(this).find('input[name="add"]:checked').val() == '1'){
                	per.add = 1;
                }
                if ($(this).find('input[name="edit"]:checked').val() == '2'){
                    per.edit = 2;
                }
                if ($(this).find('input[name="delete"]:checked').val() == '3'){
                    per.del = 3;
                }
                if ($(this).find('input[name="read"]:checked').val() == '4'){
                    per.read = 4;
                }
                if ($(this).find('input[name="configure"]:checked').val() == '5'){
                    per.configure = 5;
                }
                
                tbl.table_name = $(this).find('#table_name').val();
                tbl.permission_type = per;
                
                obj.tables[obj.tables.length] = tbl;
            });
            
            data[data.length] = obj;
        });
        $.post('<?php echo base_url(); ?>index.php/admin/user/saveUserPermission', {data:data}, function(html){
            var strAlertSuccess = '<div class="alert alert-success" style="position: fixed; right:0px; top:45px; display: none;">' +
            '<button data-dismiss="alert" class="close" type="button">×</button>' +
            '<strong>Success!</strong> You successfully saved' +
            '</div>';
            var alertSuccess = $(strAlertSuccess).appendTo('body');
            alertSuccess.show();
            setTimeout(function(){ 
                alertSuccess.remove();
            },2000);
            
        }, 'html');
        
    });
});				
</script>
