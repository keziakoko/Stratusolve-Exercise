<?php

	/**
	 * This class handles the modification of a task object
	 */
	class Task
	{
		public $TaskId;
		public $TaskName;
		public $TaskDescription;
		protected $TaskDataSource; //array task objects

		public function __construct($Id = null)
		{
			$this->TaskDataSource = file_get_contents('Task_Data.txt');
			if (strlen($this->TaskDataSource) > 0)
			{
				$this->TaskDataSource = json_decode($this->TaskDataSource);
			} // Should decode to an array of Task objects
			else
			{
				$this->TaskDataSource = array();
			} // If it does not, then the data source is assumed to be empty and we create an empty array

			if (!$this->TaskDataSource)
			{
				$this->TaskDataSource = array();
			} // If it does not, then the data source is assumed to be empty and we create an empty array

			if (!$this->LoadFromId($Id))
			{
				$this->Create();
			}
		}

		protected function Create()
		{
			// This function needs to generate a new unique ID for the task
			// Assignment: Generate unique id for the new task
			$this->TaskId = $this->getUniqueId();
			$this->TaskName = 'New Task';
			$this->TaskDescription = 'New Description';
		}

		protected function getUniqueId()
		{
			// Assignment: Code to get new unique ID
//			$newID = uniqid(rand(), true);

			$newID = $this->TaskDataSource[count($this->TaskDataSource)-1]->TaskId +1; //get last id in file and increment it
			return $newID; // Placeholder return for now
		}

		protected function LoadFromId($Id = null)
		{
			if ($Id>0)
			{
				// Assignment: Code to load details here... loop to find id in array and grab name and description
				foreach ($this->TaskDataSource as $item)
				{
					if ($item->TaskId == $Id)
					{
						$this->TaskId = $Id;
						$this->TaskDescription = $item->TaskDescription;
						$this->TaskName = $item->TaskName;
					}
				}
				return true;
			}
			else
			{
				return null;
			}
		}

		public function Save()
		{
			//Assignment: Code to save task here
			$save = true;
			foreach ($this->TaskDataSource as $key => &$item)
			{
				if ($item->TaskId == $this->TaskId)
				{
					$save = false;
					$this->TaskDataSource[$key]->TaskName = $this->TaskName;
					$this->TaskDataSource[$key]->TaskDescription =  $this->TaskDescription;
					break;
				}
			}

			if ($save)
			{
				array_push($this->TaskDataSource,(object) array('TaskId' => $this->TaskId, 'TaskName' => $this->TaskName, 'TaskDescription' => $this->TaskDescription));
			}

			file_put_contents('Task_Data.txt',json_encode($this->TaskDataSource));
		}

		public function Delete()
		{
			//Assignment: Code to delete task here
			foreach ($this->TaskDataSource as $key => $taskIdVal)
			{
				if ($taskIdVal->TaskId == $this->TaskId)
				{
					unset($this->TaskDataSource[$key]);
					$this->TaskDataSource = array_values($this->TaskDataSource);
					break;
				}
			}
			file_put_contents('Task_Data.txt', json_encode($this->TaskDataSource));
		}
	}

?>