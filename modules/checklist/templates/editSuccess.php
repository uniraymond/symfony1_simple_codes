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
							 <div class="mb_t_tit_1"><h3>Check List</h3></div>
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
			

<?php $pm_project_objects = $form->getObject() ?>
<h1><?php echo $pm_project_objects->isNew() ? 'New' : 'Edit' ?> Checklist</h1>
<form action="<?php echo url_for('checklist/update'.(!$pm_project_objects->isNew() ? '?id='.$pm_project_objects->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>

<div class="crt_cklist">
 <?php echo $form->renderGlobalErrors() ?>
					
			<?php echo $form['module']->render(array('value'=>'checklists', 'type'=>'hidden')) ?>
			<?php echo $form['id'] ?>
			<?php if(!$sf_params->get('project_id'))
				{$poj_id="";}
				else{$poj_id=$sf_params->get('project_id');} ?>
			<?php echo $form['project_id']->render(array('value'=>$poj_id, 'type'=>'hidden')) ?>

	 <ul class="title">
		<li><?php echo $form['name']->renderLabel('Checklist') ?></li>
		<li><?php echo $form['integer_field_2']->renderLabel('Person') ?></li>
		<li><?php echo $form['due_on']->renderLabel('Due By') ?></li>
		<li><?php echo $form['boolean_field_1']->renderLabel('Status') ?></li>
	 </ul>
	 <ul>
		<li><?php echo $form['name']->renderError() ?></li>
		<li><?php echo $form['integer_field_2']->renderError() ?></li>
		<li><?php echo $form['due_on']->renderError() ?></li>
		<li><?php echo $form['boolean_field_1']->renderError() ?></li>
	</ul>
	 <ul>
		<li><?php echo $form['name']->render() ?></li>
		<li><?php echo $form['integer_field_2']->render() ?></li>
		<li><?php echo $form['due_on']->render() ?></li>
		<li><?php echo $form['boolean_field_1']->render() ?></li>
	</ul>
	<ul>
		<li> 
			<?php echo link_to('Cancel','checklist/index?project_id='.$sf_params->get('project_id'), array()) ?>
	        <?php if (!$pm_project_objects->isNew()): ?>
	        <?php echo link_to('Delete', 'checklist/delete?id='.$pm_project_objects->getId(), array('post' => true, 'confirm' => 'Are you sure?')) ?>
	        <?php endif; ?>
	        <input type="submit" value="Save" />
		</li>
	</ul>

<div class="cls"></div>
</div>

</form>
            </div>
            <!--@end mainbody body component right colum -->

          </div>
          <div class="form_bt">
          </div>
          <!--end mainbody body component part -->

				</div>
				<!--end mainbody body -->

			</div>
