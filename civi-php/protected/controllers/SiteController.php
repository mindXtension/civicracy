<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	public function actionFaq()
	{
		$this->render('faq');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;
		$afterLoginRedirect = $this->createUrl('/vote/index'); // after login, redirect to vote page
		$afterLoginRedirectAdmin = $this->createUrl('/category/admin');

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm'])) {
			$model->attributes=$_POST['LoginForm'];
			$returnUrl = Yii::app()->user->returnUrl;
			if($returnUrl == $this->createUrl('/'))
				$returnUrl = $afterLoginRedirect;
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login()) {
				// log login event
				$history = new LoginHistory;
				$history->user_id = Yii::app()->user->id;
				$history->action = LoginHistory::ACTION_LOGIN;
				$history->save();

				$this->redirect(Yii::app()->user->isAdmin ? $afterLoginRedirectAdmin : $returnUrl);
			}
		} else if(!Yii::app()->user->isGuest) {
			// if user is already logged in, don't display login page again
			$this->redirect($afterLoginRedirect);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		// log logout event
		$history = new LoginHistory;
		$history->user_id = Yii::app()->user->id;
		$history->action = LoginHistory::ACTION_LOGOUT;
		$history->save();

		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}
