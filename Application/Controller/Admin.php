<?php

use Rave\Application\Model\AdminModel;
use Rave\Application\Model\CommentModel;
use Rave\Application\Model\PhotoModel;
use Rave\Core\Controller;
use Rave\Core\Error;
use Rave\Library\Core\IO\In;
use Rave\Library\Core\Security\File;
use Rave\Library\Core\Security\Session;
use Rave\Library\Core\Security\String;

class Admin extends Controller
{
    const DEFAULT_IMAGE_NAME = 'error';

    public function __construct()
    {
        $this->setLayout('admin', ['loggedIn' => Session::check('admin')]);
    }

    public function index()
    {
        if (Session::check('admin')) {
            $this->redirect('admin/manage');
        } else {
            $this->redirect('admin/login');
        }
    }

    public function login()
    {
        if (In::isSetPost(['login', 'password'])) {
            if (AdminModel::exists(In::post('login'))) {
                $admin = AdminModel::select(In::post('login'));

                if (String::hash(In::post('password')) === $admin->password) {
                    Session::login('admin');
                    Session::set('login', $admin->login);

                    $this->redirect('admin/manage');
                } else {
                    $this->redirect('admin/wrong-password');
                }
            } else {
                $this->redirect('admin/wrong-login');
            }
        } else {
            $this->loadView('loginForm');
        }
    }

    public function logout()
    {
        $this->check('admin/logout-error');
        Session::delete('admin');
        $this->redirect('admin/logout-success');
    }

    private function check($page = 'admin')
    {
        if (Session::check('admin') === false) {
            $this->redirect('admin');
        }
    }

    public function manage()
    {
        $this->check();
        $this->loadView('manage', ['manage' => true]);
    }

    public function account()
    {
        $this->check();

        $login = Session::get('login');

        if (In::isSetPost('login')) {
            if (In::isSetPost(['changePassword', 'oldPassword', 'newPassword'])) {
                $admin = AdminModel::select($login);

                if (String::hash(In::post('oldPassword')) === $admin->password) {
                    AdminModel::update($login, [
                        'login'    => In::post('login'),
                        'password' => String::hash(In::post('newPassword'))
                    ]);
                    Session::set('login', In::post('login'));

                    $this->redirect('admin/modification-success');
                } else {
                    $this->redirect('admin/wrong-password');
                }
            } else {
                AdminModel::update($login, ['login' => In::post('login')]);
                Session::set('login', In::post('login'));
            }
            $this->redirect('admin/modification-success');
        } else {
            $this->loadView('account', ['login' => trim($login)]);
        }
    }

    public function add_photo()
    {
        $this->check();

        if (In::isSetPost(['title', 'description', 'tags'])) {
            $fileName = self::DEFAULT_IMAGE_NAME;

            try {
                $fileName = File::moveUploadedFile('photo', 'public/photo', ['.jpg', '.png']);
            } catch (Exception $exception) {
                Error::create($exception->getMessage(), '500');
            }

            PhotoModel::insert([
                'name'        => $fileName,
                'tags'        => In::post('tags'),
                'title'       => In::post('title'),
                'description' => In::post('description')
            ]);

            $this->redirect('admin');
        } else {
            $this->loadView('addPhoto');
        }
    }

    public function manage_photo()
    {
        $this->check();
        $photos = PhotoModel::selectAll();
        $this->loadView('managePhoto', ['photos' => $photos]);
    }

    public function update_photo($id)
    {
        $this->check();
        $photoId = is_numeric($id) ? (int)$id : 0;

        if (In::isSetPost(['title', 'description', 'tags'])) {
            PhotoModel::update($photoId, [
                'tags'        => In::post('tags'),
                'title'       => In::post('title'),
                'description' => In::post('description')
            ]);
            $this->redirect('admin/manage-photo');
        } else {
            $photo = PhotoModel::select($photoId);

            if ($photo === false) {
                $this->redirect('admin/manage-photo');
            }

            $this->loadView('updatePhoto', ['photo' => $photo]);
        }
    }

    public function delete_photo($id)
    {
        $this->check();
        $photoId = is_numeric($id) ? (int)$id : 0;
        $photo = PhotoModel::select($photoId);
        PhotoModel::delete($photoId);
        unlink(ROOT . '/public/photo/' . $photo->name);
        $this->redirect('admin/manage-photo');
    }

    public function manage_comment()
    {
        $this->check();
        $comments = CommentModel::selectAll();
        $this->loadView('manageComment', ['comments' => $comments]);
    }

    public function update_comment($id)
    {
        $this->check();
        $commentId = is_numeric($id) ? (int)$id : 0;

        if (In::isSetPost(['title', 'author', 'content'])) {
            CommentModel::update($commentId, [
                'title'   => In::post('title'),
                'author'  => In::post('author'),
                'content' => String::clean(In::post('content'))
            ]);
            $this->redirect('admin/manage-comment');
        } else {
            $comment = CommentModel::select($commentId);

            if ($comment === false) {
                $this->redirect('admin/manage-comment');
            }

            $this->loadView('updateComment', ['comment' => $comment]);
        }
    }

    public function delete_comment($id)
    {
        $this->check();
        $commentId = is_numeric($id) ? (int)$id : 0;
        CommentModel::delete($commentId);
        $this->redirect('admin/manage-comment');
    }

    public function wrong_login()
    {
        $this->loadView('wrongLogin');
    }

    public function wrong_password()
    {
        $this->loadView('wrongPassword');
    }

    public function logout_success()
    {
        $this->loadView('logoutSuccess');
    }

    public function logout_error()
    {
        $this->loadView('logoutError');
    }

    public function modification_success()
    {
        $this->loadView('modificationSuccess');
    }

}