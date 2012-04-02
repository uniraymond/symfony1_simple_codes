<?php echo use_helper('Form', 'Javascript'); ?>
			<div class="rb_body">

				<!--mainbody header -->
				<div class="mb_header">
					<div class="mb_title">
						<h1>Builds</h1>
					</div>
					<div class="mb_sub_menu">
						<?php echo include_partial('build/sidebar', array('project_id' => $sf_params->get('project_id'))); ?>
					</div>
				</div>
				<!--end mainbody header -->

				<!--mainbody body -->
				<div class="mb_body">

          <!--mainbody body top part -->
					<div class="mb_bd_top">
						<div class="mb_top_title">
							 <div class="mb_t_tit_1"><h3>1. Create Checklist</h3></div>
							 <div class="mb_t_tit_2"><h4></h4></div>
						</div>
						<div class="mb_pro_1 mb_pro_1st">
							<div class="mb_pro_num"></div>
							<div class="md_pro_info_1"></div>

						</div>
						<div class="mb_pro_1">
							<div class="mb_pro_num"></div>
							<div class="md_pro_info_2">
								<ul>
									<li></li>
									<li></li>
								</ul>
							</div>
						</div>
						<div class="mb_pro_1">
							<div class="mb_pro_num mb_pro_cur"></div>
							<div class="md_pro_info_1"></div>
						</div>
					</div>
          <!--end mainbody body top part -->

          <!--mainbody body component part -->
          <div class="mb_bd_comp">

            <!--mainbody body component left colum -->
            <div class="left_column">


            </div>
            <!--@end mainbody body component left colum -->

            <!--mainbody body component right colum -->
            <div class="main_column">
			
			<h1>Checklist</h1>
			
            <div class="check_list">
				<form name="new_checklist" id="new_checklist" action="<?php echo url_for('checklist/addchecklist?project_id='.$sf_params->get('project_id')) ?>" method="post">
				 	<?php echo input_tag('new_checklist_name') ?>
					<input type="submit" value="add new checklist" />
				</form>	
				<div class="cls"></div>
            </div>

            <?php if($pm_project_objectsList):  ?>
			<?php foreach ($pm_project_objectsList as $root): ?>
				<div class="check_body">
					<!-- check list title -->
					<div class="check_list_all"  onmouseover="Effect.Appear('del_<?php echo $root->getId() ?>', {duration: 1.0}); return false;" onmouseout="$('del_<?php echo $root->getId() ?>').hide(); return false;"  >
						<div class="check_body_fm">
							<span class="del_links_title" id="list_<?php echo $root->getId() ?>"><?php echo $root->getName() ?></span>			
							
								<?php echo input_in_place_editor_tag('list_'.$root->getId(), 'checklist/inplaceupdate?id='.$root->getId()) ?>
								
						</div>
						<div class="de_link" id="del_<?php echo $root->getId() ?>" style="display:none">
							<span class="del_links">	
								<a class="del_img" href="<?php echo url_for('checklist/delete?project_id='.$sf_params->get('project_id').'&id='.$root->getId()) ?>">Delete</a>
							</span>
						</div>
						<div class="cls"></div>
					</div>
					<!-- @end check list title -->
					
						<?php if($root->todos): ?>
					<!-- check list unchecked todo -->
					<div class="unchecked_todo">
						<?php foreach ($root->todos as $todo): ?>
						<div class="unchecked_items">
							<div class="unckd_td_box">
								<form name="todo_form_<?php echo $todo->getId() ?>" id="todo_form_<?php echo $todo->getId() ?>" action="<?php echo url_for('checklist/todostatus?project_id='.$sf_params->get('project_id').'&id='.$todo->getId()) ?>" method="post">
								<?php echo checkbox_tag('checkbox','',false, array('onclick' => "document.todo_form_".$todo->getId().".submit();")) ?>
								</form>	
							</div>
							<div class="unckd_td_cont">
								<span id="todo_<?php echo $todo->getId() ?>"><?php echo $todo->getName() ?></span>
								<?php echo input_in_place_editor_tag('todo_'.$todo->getId(), 'checklist/inplaceupdate?id='.$todo->getId()) ?>
								<a class="del_img" href="<?php echo url_for('checklist/delete?project_id='.$sf_params->get('project_id').'&id='.$todo->getId()) ?>">Delete</a>
							</div>
							<div class="cls"></div>
						</div>
						<?php endforeach; ?>
					</div>
					<!-- @end check list checked todo -->
						<?php endif; ?>
					<div class="add_todo_form">
						<div class="add_todo_lk" id="add_todo_lk_<?php echo $root->getId() ?>"> 
							<a class="add_td_lka" href="#"  onclick="Effect.Appear('add_todo_fm_<?php echo $root->getId() ?>', {duration: 1.0}); $('add_todo_lk_<?php echo $root->getId() ?>').hide(); return false;" >Add New Todo</a>
						</div>
						<div class="add_todo_fm" id="add_todo_fm_<?php echo $root->getId() ?>" style="display:none">
							<form action="<?php echo url_for('checklist/addtodo?project_id='.$sf_params->get('project_id').'&parent_id='.$root->getId()) ?>" method="post">
								<div class="add_td_label">
									<ul>
										<li>add a todo item</li>
										<li><?php echo input_tag('new_todo_name','', 'size=35') ?></li>
									</ul>
								</div>
								 <input type="submit" value="add new todo" /> or <a href="#" onclick="Effect.Appear('add_todo_lk_<?php echo $root->getId() ?>', {duration: 1.0}); $('add_todo_fm_<?php echo $root->getId() ?>').hide(); return false;">Cancel adding todo</a>
							</form>
						</div>
					</div>
					
					<div>
						<?php if($root->completed_todos): $todo = '';?>
						<div class="checked_todo">
						<?php foreach ($root->completed_todos as $todo): ?>
							<div class="checked_items">
								<div class="ckd_td_box">
									<form name="todo_form_<?php echo $todo->getId() ?>" id="todo_form_<?php echo $todo->getId() ?>" action="<?php echo url_for('checklist/todostatus?project_id='.$sf_params->get('project_id').'&id='.$todo->getId()) ?>" method="post">
										<?php echo checkbox_tag('checkbox','',true, array('onclick' => "document.todo_form_".$todo->getId().".submit();")) ?>
									</form>	
								</div>
								<div class="ckd_td_cont">
									<span id="todo_<?php echo $todo->getId() ?>"><?php echo $todo->getName() ?></span>
									
									<?php echo input_in_place_editor_tag('todo_'.$todo->getId(), 'checklist/inplaceupdate?id='.$todo->getId()) ?>
											<a class="del_img" href="<?php echo url_for('checklist/delete?project_id='.$sf_params->get('project_id').'&id='.$todo->getId()) ?>">Delete</a>
								</div>
								<div class="cls"></div>
							</div>
						<?php endforeach; ?>
						</div>
						<?php endif; ?> 
					</div>
				</div>
			<?php endforeach; ?>
                        
			<?php endif;  ?>
			<div class="cls"></div>
         </div>
            <!--@end mainbody body component right colum -->

          <div class="form_bt">
          </div>
          <!--end mainbody body component part -->

				</div>
				<!--end mainbody body -->

			</div>
		</div>
	</div>

