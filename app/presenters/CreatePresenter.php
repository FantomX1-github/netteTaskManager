<?php

namespace App\Presenters;

use Nette;
/**
 * Presenter class for task manipulation, creation, editing, displaying
 * @author František Hallo
 */
class CreatePresenter extends BasePresenter {

  /** @var Nette\Database\Context */
  private $database;

  public function __construct(Nette\Database\Context $database) {
    $this->database = $database;
  }

/**
 * Method is here just to call invalidate data for new task template snippet
 * 
 */
  public function actionNew() {

    if ($this->isAjax())
      $this->invalidateControl('content');

  }

/**
 * Assigns data to edit form template
 * 
 */
  public function actionEdit($taskId) {

    if ($this->isAjax())
      $this->invalidateControl('content');

    $task = $this->database->table('task')->get($taskId);
    if (!$task) {
      $this->error('Task neexistuje');
    }
    $this['taskEditForm']->setDefaults($task->toArray());
//      $this['taskEditForm']->setDefaults(array('time'=>''));
  }

  
 /**
 * Creating reusable-minimalistic task form
 * 
 */
  protected function createComponentTaskForm() {
    $form = new Nette\Application\UI\Form;

    $form->addText('name', 'Názov:')
        ->setRequired();

    $form->addText('desc', 'Popis:');

    $form->addSubmit('send', 'Uložiť');
    $form->onSuccess[] = $this->taskFormSucceeded;
    return $form;
  }

  
 /**
 * Creating reusable-minimalistic edittask form prefilled with data
 * 
 */
 
  protected function createComponentTaskEditForm() {
    $form = new Nette\Application\UI\Form;

    $form->addText('name', 'Meno:')
        ->setRequired();

    $form->addText('desc', 'Popis:');

    $form->addText('time', 'Čas:')->setDisabled();

    $form->addText('hours', 'Pridať hodin:');

    $form->addText('minutes', 'Pridať minút:');


    $form->addSubmit('send', 'Uložiť');
    $form->onSuccess[] = $this->taskEditFormSucceeded;
    return $form;
  }

 /**
 * Event handler for task form
 * 
 */
  public function taskFormSucceeded($form) {

    $values = $form->getValues();

    $task = $this->database->table('task')->insert($values);
    $this->flashMessage('Aplikované', 'success');
    $this->redirect('this');
  }

  
 /**
 * Event handler for edit form
 * 
 */
  public function taskEditFormSucceeded($form) {

    $values = $form->getValues();
    $taskId = $this->getParameter('taskId');


    $task = $this->database->table('task')->get($taskId);

    $values['time'] = $task->time + $values['hours'] + ($values['minutes'] / 60);
    unset($values['hours'], $values['minutes']);


    $task->update($values);


    $this->flashMessage('Aplikované', 'success');
    $this->redirect('this');
  }

  
  /**
 * Presenter metod for displaying specific task
 * 
 */
  public function renderShow($taskId) {

    if ($this->isAjax())
      $this->invalidateControl('content');

    $task = $this->database->table('task')->get($taskId);
    if (!$task) {
      $this->error('Task nenajdeny');
    }

    $this->template->task = $task;
  }

}
