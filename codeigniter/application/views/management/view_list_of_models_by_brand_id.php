<?php

if($for_edit == 1)
{
	foreach ($models as $model) 
	{
		add_model_div($model);
		//$models_array[$model->id] = $model->name;		
	}
}
else
{
	foreach ($models as $model) 
	{
		$models_array[$model->id] = $model->model;		
	}
	echo form_dropdown('models', $models_array, '', 'id="model_drop_down_list"');
}

function add_model_div($model)
{
	echo '<div class="list_item" value="'.$model->id.'">';
	echo '<div class="list_item_name">';
	echo $model->model;
	echo '</div>'; 
	echo '<div class="edit_item_name"><img src='.base_url().'resources/images/edit-6-48.png></div>';
	echo '<div class="delete_item"><img src='.base_url().'resources/images/delete-48.png></div>';
	echo '</div>';
}

?>