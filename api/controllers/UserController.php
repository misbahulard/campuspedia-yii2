<?php

namespace api\controllers;

use api\models\User;
use Yii;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;

class UserController extends Controller
{
    /**
     * Method untuk list semua user
     * Tapi tidak ada
     *
     * @throws ForbiddenHttpException
     */
    public function actionIndex()
    {
        throw new ForbiddenHttpException('You are not allowed to access this API endpoint');
    }

    /**
     * Method untuk menampilkan detail user dari id user
     *
     * @param $id
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $user = User::findOne(['user_id' => $id]);

        if ($user == null) {
            throw new NotFoundHttpException('User not found!');
        }

        return [
            'data' => $user,
        ];
    }

    /**
     * Method untuk login user
     *
     * @return array
     * @throws UnauthorizedHttpException
     */
    public function actionLogin()
    {
        $request = Yii::$app->request;

        $email = $request->post('email');
        $pasword = $request->post('password');

        $user = User::findByEmail($email);

        if ($user->validatePassword($pasword)) {
            return [
                'data' => $user
            ];
        } else {
            throw new UnauthorizedHttpException('Email or password incorrect');
        }
    }

    public function actionRegister() {
        $request = Yii::$app->request;

        $name = $request->post('name');
        $email = $request->post('email');
        $password = $request->post('password');

        // Cek email apakah sudah terdaftar atau belum
        if (User::findByEmail($email) != null) {
            throw new BadRequestHttpException('email already exist');
        }

        $user = new User();
        $user->role_id = 2;
        $user->name = $name;
        $user->email = $email;
        $user->setPassword($password);
        $user->photo = 'default.jpg';
        $user->access_token = $this->random_str(60);

        if ($user->save()) {
            return [
                'data' => $user
            ];
        } else {
            throw new ForbiddenHttpException('Failed to create new user');
        }
    }

    /**
     * Generate a random string, using a cryptographically secure
     * pseudorandom number generator (random_int)
     *
     * For PHP 7, random_int is a PHP core function
     * For PHP 5.x, depends on https://github.com/paragonie/random_compat
     *
     * @param int $length      How many characters do we want?
     * @param string $keyspace A string of all possible characters
     *                         to select from
     * @return string
     */
    function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
        $str = '';
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $str .= $keyspace[random_int(0, $max)];
        }
        return $str;
    }
}