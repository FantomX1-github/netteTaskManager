<?php

namespace App\Presenters;

use Nette,
	App\Model;


/**
 * Homepage presenter.
 */
class HomepagePresenter extends BasePresenter
{


  /** @var Nette\Database\Context */
    private $database;

    public function __construct(Nette\Database\Context $database)
    {
        $this->database = $database;
    }
    
    
//	public function renderDefault()
//	{
//		$this->template->anyVariable = 'any value';
//	}
    
    public function renderDefault()
{
    $this->template->tasks = $this->database->table('task')
        ->order('task_id DESC')
        ->limit(5);
    
          if ($this->isAjax())
        $this->invalidateControl('content');
      
}

}
