<?php

	function lang($phrase){
		static $lang = array(
			'brand'         => 'Home',
			'categories'    => 'categories',
            'Edit profile'  => 'Edit profile',
            'settings'      => 'settings',
            'logout'        =>'logout',
            'itmes'         =>'Itmes',
            'members'       =>'Members',
            'statistics'    =>'Statistics',
            'logs'          =>'Logs',
            ''              =>'',
            ''              =>'',
            ''              =>''
		);

		return $lang[$phrase];


	}