<?php
namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class PermissionInvest implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = \Config\Services::session();
        $uri= service('uri');
        //permission add
        if($uri->getSegment(2)==='add_invest'){
            if($_SESSION['user_type'] !== 'leader'){
                return redirect()->to(base_url('projects/show_invests'));
            }
        }
        //permission edit
        if($uri->getSegment(2)==='edit_invest'){
            if($_SESSION['user_type'] === 'management'){
                return redirect()->to(base_url('projects/show_invest/'.$uri->getSegment(3)));
            }
        }

    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {

    }
}

