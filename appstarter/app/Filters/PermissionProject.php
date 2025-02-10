<?php
namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class PermissionProject implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = \Config\Services::session();
        $uri= service('uri');
        //permission show
        if($uri->getSegment(2) ==='show_projects' || $uri->getSegment(2) ==='show_project'){
            if($_SESSION['user_type'] === 'management'){
                return redirect()->to(base_url(''));
            }
        }
        //permission add
        if($uri->getSegment(2)==='add_project'){
            if($_SESSION['user_type'] !== 'leader'){
                return redirect()->to(base_url('projects/show_projects'));
            }
        }
        //permission edit
        if($uri->getSegment(2)==='edit_project'){
            if($_SESSION['user_type'] !== 'leader'){
                return redirect()->to(base_url('projects/show_project/'.$uri->getSegment(3)));
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {

    }
}

