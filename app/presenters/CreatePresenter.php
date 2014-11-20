<?php

namespace App\Presenters;

use Nette;


class CreatePresenter extends BasePresenter
{
    /** @var Nette\Database\Context */
    private $database;

    public function __construct(Nette\Database\Context $database)
    {
        $this->database = $database;
    }


    public function renderDefault(){

      

      
    }
    public function actionNew(){
      
      if ($this->isAjax())
        $this->invalidateControl('content');

      $aTasks = $this->database->table('task');

      $this->template->aTasks = $aTasks;

      

      
    }
    

    public function actionEdit($taskId)
    {
      
      if ($this->isAjax())
        $this->invalidateControl('content');
      
      $task = $this->database->table('task')->get($taskId);
      if (!$task) {
          $this->error('Task neexistuje');
      }
      $this['taskEditForm']->setDefaults($task->toArray());
//      $this['taskEditForm']->setDefaults(array('time'=>''));
    }
    protected function createComponentTaskForm()
    {
        $form = new Nette\Application\UI\Form;

        $form->addText('name', 'Názov:')
            ->setRequired();

        $form->addText('desc', 'Popis:');
       
       
        


        $form->addSubmit('send', 'Uložiť');
        $form->onSuccess[] = $this->taskFormSucceeded;
        return $form;
    }
    protected function createComponentTaskEditForm()
    {
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
    
    
    




    public function taskFormSucceeded($form)
    {



      $values = $form->getValues();

        $task = $this->database->table('task')->insert($values);
        $this->flashMessage('Aplikované', 'success');
        $this->redirect('this');
    }
    
    public function taskEditFormSucceeded($form)
    {

      $values = $form->getValues();
      $taskId = $this->getParameter('taskId');
        
        
      $task = $this->database->table('task')->get($taskId);
      
      $values['time'] = $task->time+$values['hours']+($values['minutes']/60);
      unset($values['hours'], $values['minutes']);
      

          $task->update($values);
          

        $this->flashMessage('Aplikované', 'success');
        $this->redirect('this');
    }
    
    
    public function renderShow($taskId)
    {
      
            if ($this->isAjax())
        $this->invalidateControl('content');
      
      $task = $this->database->table('task')->get($taskId);
      if (!$task) {
          $this->error('Task nenajdeny');
      }

      $this->template->task = $task;
      
    }


}
