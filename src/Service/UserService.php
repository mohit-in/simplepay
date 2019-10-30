<?php


namespace App\Service;
use App\Entity\User;

class UserService
{
    /**
     *  Function to process User Create API request.
     *
     * @param $userData
     * @return User
     */
    public function CreateUpdateUser($userData)
    {
        $user = new User();
        if(!empty($userData['email'])) {

            $user->setEmail($userData['email']);
        }
        if(!empty($userData['name'])) {
            $user->setName($userData['name']);
        }

        if(!empty($userData['mobile'])) {
            $user->setName($userData['mobile']);
        }

        if(!empty($userData['password'])) {
            $user->setName($userData['password']);
        }

        if(!empty($userData['status'])) {

            $user->setName($userData['password']);
        }
        return $user;
    }
}