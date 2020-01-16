<?php

namespace App\Http\Api;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;

class UsersApi extends BaseApi
{

    /**
     * UsersApi constructor.
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Return a current logged in user object to frontend
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
	public function me(Request $request)
	{
		if ($request->user()) {
			return response()->json([
				'status' => 'OK',
				'user' => new UserResource($request->user())
			]);
		}
		return response()->json([
			'status' => false
		]);
	}

    public function switch(Request $request)
    {

        $lang = request('lang');
        if ($lang == 'en' || $lang == 'tw' || $lang == 'zh') {
            $user = auth()->user();
            $user->preferred_lang = $lang;
            $user->save();
            app()->setLocale($lang);
            return json_encode(['status' => 'success', 'lang' => $lang]);
        } else {
            return report_error('switch language', 'Unknown language: ' . $lang);
        }
    }

    public function changePassword(Request $request)
    {
        $data = $request->all();
        $user = auth()->user();

        if (!$user) {
            return report_error('Password Changing', 'No logged in user found.');            
        }

        if (array_get($data, 'honey')) {
            return report_error('Password Changing', 'honeypot has value!' . $user->id);
        }

        $password = array_get($data, 'password');
        if (!$password || strlen($password) < 8) {
            return report_error('Password Changing', 'Invalid Password ' . strlen($password) . ' for user id: ' . $user->id);
        }

        $user->password = bcrypt(array_get($data, 'password'));
        $user->save();
        return response()->json('success');
    }
}
