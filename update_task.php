<?php
/**
 * This script is to be used to receive a POST with the object information and then either updates, creates or deletes the task object
 */
require('Task.class.php');
// Assignment: Implement this script
	$type = $_POST['type'];
	$id = $_POST['ID'];


	if($type=="1") // Delete
	{
		$updateClass = new Task($id);
		$updateClass->Delete();
	}
	else if($type==2)//edit/save
	{
		$updateClass = new Task($id);
		if($_POST['TaskDesc'] !="")
		{
			$updateClass->TaskDescription = $_POST['TaskDesc'];
		}
		if($_POST['TaskName']!="")
		{
			$updateClass->TaskName = $_POST['TaskName'];
		}
		$updateClass->Save();
	}
?>