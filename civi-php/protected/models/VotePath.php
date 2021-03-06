<?php

/**
 * Simple model class for displaying a single path of vote delegation.
 */
class VotePath extends CModel
{
	public $realname;
	public $slogan;
	public $reason;
	public $candidate_id; // only used via PHP at the moment

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'realname' => User::model()->getAttributeLabel('realname'),
			'slogan' => User::model()->getAttributeLabel('slogan'),
			'reason' => Vote::model()->getAttributeLabel('reason'),
		);
	}

	public function attributeNames()
	{
		return array('realname', 'slogan', 'reason');
	}
}
