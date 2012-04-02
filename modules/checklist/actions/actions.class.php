<?php

/**
 * checklist actions.
 *
 * @package    sf_sandbox
 * @subpackage checklist
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 8507 2008-04-17 17:32:20Z fabien $
 */
class checklistActions extends sfActions
{
  public function executeIndex()
  {
    $this->forward404Unless($this->getRequestParameter('project_id'));

    $this->pm_project_objectsList = '';

    $c = new Criteria();
    $c->add(pmProjectObjectsPeer::PROJECT_ID, $this->getRequestParameter('project_id'));
    $c->add(pmProjectObjectsPeer::MODULE, 'checklists');
    //$c->add(pmProjectObjectsPeer::PARENT_ID, '');
    $r = pmProjectObjectsPeer::doSelect($c);


    if($r){
      foreach($r as &$obj){
        $c = new Criteria();
        $c->add(pmProjectObjectsPeer::PROJECT_ID, $this->getRequestParameter('project_id'));
        $c->add(pmProjectObjectsPeer::MODULE, 'todo');
        $c->add(pmProjectObjectsPeer::VISIBILITY, false);
        $c->add(pmProjectObjectsPeer::PARENT_ID, $obj->getId());
        $obj->todos = pmProjectObjectsPeer::doSelect($c);

        $c = new Criteria();
        $c->add(pmProjectObjectsPeer::PROJECT_ID, $this->getRequestParameter('project_id'));
        $c->add(pmProjectObjectsPeer::MODULE, 'todo');
        $c->add(pmProjectObjectsPeer::VISIBILITY, true);
        $c->add(pmProjectObjectsPeer::PARENT_ID, $obj->getId());
        $obj->completed_todos = pmProjectObjectsPeer::doSelect($c);
      }
    }
    $this->pm_project_objectsList = $r;

  }

  public function executeCreate()
  {
    $this->form = new pmProjectObjectsForm();

    $this->setTemplate('edit');
  }

  public function executeEdit($request)
  {
    $this->form = new pmProjectObjectsForm(pmProjectObjectsPeer::retrieveByPk($request->getParameter('id')));
    //list all forms of the project
    $c = new Criteria();
    $c->add(pmProjectObjectsPeer::PROJECT_ID, $this->getRequestParameter('project_id'));
    $c->add(pmProjectObjectsPeer::MODULE, 'checklists');
    $this->pm_project_objectsList = pmProjectObjectsPeer::doSelect($c);
  }

  public function executeUpdate($request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new pmProjectObjectsForm(pmProjectObjectsPeer::retrieveByPk($request->getParameter('id')));

    $this->form->bind($request->getParameter('pm_project_objects'));
    if ($this->form->isValid())
    {
      $pm_project_objects = $this->form->save();
      
      //activity_log
      $log = new pmActivityLogs();
      $log->setObjectId($pm_project_objects->getId());
      ($request->getParameter('id'))? $log->setAction('Update checklist'):$log->setAction('New checklist');      
      $log->setCreatedById($this->getUser()->getGuardUser()->getId());
      //$log->setCreatedByName();
      //$log->setCreatedByEmail();
      //$log->setComment();
      //$log->setModifications();
      $log->save();
      
      $this->redirect('checklist/index?project_id='.$pm_project_objects->getProjectId().'&id='.$pm_project_objects->getId());
    }

    $this->setTemplate('edit');
  }

  public function executeDelete($request)
  {
    $this->forward404Unless($pm_project_objects = pmProjectObjectsPeer::retrieveByPk($request->getParameter('id')));

    //delete all todos
    $c = new Criteria();
    $c->add(pmProjectObjectsPeer::PROJECT_ID, $this->getRequestParameter('project_id'));
    $c->add(pmProjectObjectsPeer::MODULE, 'todo');
    $c->add(pmProjectObjectsPeer::PARENT_ID, $pm_project_objects->getId());
    $r = pmProjectObjectsPeer::doSelect($c);
    if($r){
      foreach($r as $todo){
        $todo->delete();
      }
    }

    //delete the list
    $pm_project_objects->delete();
    
    $this->redirect('checklist/index?project_id='.$pm_project_objects->getProjectId());
  }

  public function executeAddchecklist($request)
  {
    $this->forward404Unless($request->isMethod('post'));

$tep = array();
$tep['project_id'] = $request->getParameter('project_id');
$tep['name'] = $request->getParameter('new_checklist_name');
$tep['module'] = 'checklists';
$tep['created_by_id'] = $this->getUser()->getGuardUser()->getId();
$tep['created_by_name'] = $this->getUser()->getGuardUser()->getUsername();


    $this->form = new pmProjectObjectsForm();

    $this->form->bind($tep);
    if ($this->form->isValid() && $request->getParameter('new_checklist_name'))
    {
      $pm_project_objects = $this->form->save();

      //activity_log
      $log = new pmActivityLogs();
      $log->setObjectId($pm_project_objects->getId());
      $log->setAction('new checklist');      
      $log->setCreatedById($this->getUser()->getGuardUser()->getId());
      //$log->setCreatedByName();
      //$log->setCreatedByEmail();
      //$log->setComment();
      //$log->setModifications();
      $log->save();
            

    }
    $this->redirect('checklist/index?project_id='.$request->getParameter('project_id'));
  }

  public function executeAddtodo($request)
  {
    $this->forward404Unless($request->isMethod('post'));

$tep = array();
$tep['project_id'] = $request->getParameter('project_id');
$tep['name'] = $request->getParameter('new_todo_name');
$tep['module'] = 'todo';
$tep['parent_id'] = $request->getParameter('parent_id');
$tep['created_by_id'] = $this->getUser()->getGuardUser()->getId();
$tep['created_by_name'] = $this->getUser()->getGuardUser()->getUsername();


    $this->form = new pmProjectObjectsForm();

    $this->form->bind($tep);
    if ($this->form->isValid())
    {
      $pm_project_objects = $this->form->save();
      
      //activity_log
      $log = new pmActivityLogs();
      $log->setObjectId($pm_project_objects->getId());
      $log->setAction('new todo');      
      $log->setCreatedById($this->getUser()->getGuardUser()->getId());
      //$log->setCreatedByName();
      //$log->setCreatedByEmail();
      //$log->setComment();
      //$log->setModifications();
      $log->save();      

    }
    $this->redirect('checklist/index?project_id='.$request->getParameter('project_id'));
  }

  public function executeInplaceupdate($request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $obj = myTools::updateField('pmProjectObjectsPeer', $request->getParameter('id'), 'name', $request->getParameter('value'));

    
      //activity_log
      $log = new pmActivityLogs();
      $log->setObjectId($obj->getId());      
      $log->setAction($obj->getModule().' updated');
      $log->setCreatedById($this->getUser()->getGuardUser()->getId());
      //$log->setCreatedByName();
      //$log->setCreatedByEmail();
      //$log->setComment();
      //$log->setModifications();
      $log->save();
    

    return $this->renderText($obj->getName());
  }

  public function executeTodostatus($request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $obj = pmProjectObjectsPeer::retrieveByPk($request->getParameter('id'));

    myTools::updateField('pmProjectObjectsPeer', $request->getParameter('id'), 'visibility', !$obj->getVisibility());

    $this->redirect('checklist/index?project_id='.$request->getParameter('project_id'));
  }

}
