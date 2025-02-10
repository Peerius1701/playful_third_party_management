<?php
namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class PermissionManagement implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = \Config\Services::session();
        $uri= service('uri');
        //permission add, edit
        if($uri->getSegment(2)==='add_management' || $uri->getSegment(2)==='edit_management' ){
            if($_SESSION['user_type'] !== 'leader'){
                return redirect()->to(base_url('users/show_managements'));
            }
        }

    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {

    }
}
