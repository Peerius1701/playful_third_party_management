<?php
namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class PermissionPandoForm implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = \Config\Services::session();
        $uri= service('uri');
        //permission add
        if($uri->getSegment(2)==='add_form'){
            if($_SESSION['user_type'] !== 'leader'){
                return redirect()->to(base_url('pando/form'));
            }
        }
        //permission edit
        if($uri->getSegment(2)==='edit_form'){
            if($_SESSION['user_type'] !== 'leader'){
                return redirect()->to(base_url('pando/form/'.$uri->getSegment(3)));
            }
        }

    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {

    }
}


