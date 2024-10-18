<?php

namespace Mzm\Ilogin\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

Class SsoServices
{

    protected $db;
    protected $apiUrl;
    protected $origin;
    protected $token;
    protected $home;

    public function __construct()
    {
        // Get the SSO URL from config
        $this->apiUrl = config('ilogin.api_url');
        $this->origin = config('ilogin.origin');
        $this->token = config('ilogin.token');
        $this->home = config('ilogin.home');
    }


    /**
     * Check if the access token is set in the cookie.
     *
     * @return string|false The access token if it is set, otherwise false.
     */
    private function checkAccessToken()
    {

        if (isset($_COOKIE['access_token'])) {
            return $_COOKIE['access_token'];
        }
        return false;
    }

    /**
     * Store user data in session.
     *
     * @param array $data The user data to store in session.
     *
     * @return void
     */
    private function storeUserData($data)
    {
        request()->session()->put('sso_user', $data);
    }

    /**
     * Check if the user data is stored in the session.
     *
     * @return bool True if the user data is set in the session, false otherwise.
     */
    private function checkUserData()
    {
        if (request()->session()->has('sso_user')) {
            return true;
        }
        return false;
    }
    /**
     * Get the user data stored in the session.
     *
     * @return array|null The user data stored in the session, null if not set.
     */
    private function getUserData()
    {
        return request()->session()->get('sso_user');
    }

    /**
     * Get the user data from the local database.
     *
     * @return \App\Models\User|null The user data from the local database, null if not found.
     */
    private function getLocalData()
    {
        $user = $this->getUserData();

        $nokp = $user['nokp'];
        $email = $user['email'];

        return User::where('email', $email)->where('nokp', $nokp)->first();
    }

    /**
     * Verify user credentials and store the user data in session
     *
     * Will redirect to login page if the access token is not set
     *
     * @return void
     */
    public function verify()
    {
        $token = $this->checkAccessToken();

        if (!$token) {
            return redirect()->to("{$this->apiUrl}/login?token=" . urlencode($this->token));
        }

        $ch = curl_init("{$this->apiUrl}/api/user");

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Accept: application/json',
                "Authorization: Bearer {$token}",
                "X-Client-Origin: {$this->origin}",
                "X-Client-Token: {$this->token}",
            ],
            CURLOPT_SSL_VERIFYPEER => false,
        ]);

        $response = curl_exec($ch);
        $result = json_decode($response, true);

        /** Curl error */
        if ($response === false) {
            curl_close($ch);
            return abort(403, 'Curl error: ' . curl_error($ch));
        }

        curl_close($ch);

        /** Success */
        if (isset($result['success'])) {
            /** store user data */
            $this->storeUserData($result['data']['user']);

            /** authenticate user in local database */
            return $this->authenticate();
        }
        /** Error */
        return abort(403);
    }


    /**
     * Authenticate user
     *
     * Check if user data exist in session
     * If exist, check if user exist in database
     * If exist, login user and redirect to home page
     * If not exist, return 401 error
     * If not exist in session, verify user via SSO
     *
     * @return \Illuminate\Http\Response
     */
    private function authenticate()
    {

        /** check if user data exist in session */
        if ($this->checkUserData()) {

            /** check if user exist in database */
            $user = $this->getLocalData();

            /** login user and redirect to home page */
            if ($user && Auth::loginUsingId($user->id)) {
                return redirect()->route($this->home);
            } else {
                /** return 401 error */
                return abort(401, 'Sila hubungi pentadir sistem.');
            }
        } else {
            /** verify user via SSO */
            $this->verify();
        }
    }
}
