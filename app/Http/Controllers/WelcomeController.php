<?php namespace App\Http\Controllers;

class WelcomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$dir = '/var/lib/openshift/56843b142d5271dd4900010b/app-root/repo/music';

		$getID3 = new \getID3;
		$DirectoryToScan = $dir;
		$dir = opendir($DirectoryToScan);
		$cnt = 1;
		$musicArray = $music = array();

		while (($file = readdir($dir)) !== false) {
        		$FullFileName = realpath($DirectoryToScan.'/'.$file);
    			if ((substr($FullFileName, 0, 1) != '.') && is_file($FullFileName)) {

			        $ThisFileInfo = $getID3->analyze($FullFileName);
        			\getid3_lib::CopyTagsToComments($ThisFileInfo);
        			$values = explode(":", $ThisFileInfo['playtime_string']);
        			$musicArray['music-' . $file] =
					((($values[0] * 60) + $values[1] ) * 1000) - 1000;
				$music[] = $ThisFileInfo;
			}
		}
		return view('welcome', ['music' => $music, 'musicArray'=>$musicArray]);
	}

}
