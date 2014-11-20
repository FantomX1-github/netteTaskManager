<?php

namespace App\Presenters;

use Nette,
    App\Model;

/**
 * Presenter class for displaying list of tasks
 * @author František Hallo
 */
class HomepagePresenter extends BasePresenter {

  /** @var Nette\Database\Context */
  private $database;

  public function __construct(Nette\Database\Context $database) {
    $this->database = $database;
  }

  /**
 * Presenter metod for displaying list of tasks ordered by newest
 * 
 */
  public function renderDefault() {
    $this->template->tasks = $this->database->table('task')
        ->order('task_id DESC');

    if ($this->isAjax())
      $this->invalidateControl('content');
  }

}
