<?php
namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class PermissionTeachingService implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = \Config\Services::session();
        $uri= service('uri');
        //permission add
        if($uri->getSegment(2)==='add_teaching_service'){
            if($_SESSION['user_type'] !== 'leader'){
                return redirect()->to(base_url('forms/show_teaching_services'));
            }
        }
        //permission edit
        if($uri->getSegment(2)==='edit_teaching_service'){
            if($_SESSION['user_type'] !== 'leader'){
                return redirect()->to(base_url('forms/show_teaching_service/'.$uri->getSegment(3)));
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {

    }
}



