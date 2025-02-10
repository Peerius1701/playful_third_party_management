<?php
namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class PermissionYoungScientist implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = \Config\Services::session();
        $uri= service('uri');
        //permission show
        if($uri->getSegment(2)==='show_young_scientists' || $uri->getSegment(2)==='show_young_scientist'){
            if($_SESSION['user_type'] === 'management'){
                return redirect()->to(base_url(''));
            }
        }
        //permission add
        if($uri->getSegment(2)==='add_young_scientist'){
            if($_SESSION['user_type'] !== 'leader'){
                return redirect()->to(base_url('projects/show_young_scientists'));
            }
        }
        //permission edit
        if($uri->getSegment(2)==='edit_young_scientist'){
            if($_SESSION['user_type'] !== 'leader'){
                return redirect()->to(base_url('projects/show_young_scientist/'.$uri->getSegment(3)));
            }
        }

    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {

    }
}

