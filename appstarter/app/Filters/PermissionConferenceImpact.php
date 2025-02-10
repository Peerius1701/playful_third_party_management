<?php
namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class PermissionConferenceImpact implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = \Config\Services::session();
        $uri= service('uri');
        //permission show
        if($uri->getSegment(2)==='show_conferences_impact'){
            if($_SESSION['user_type'] === 'management'){
                return redirect()->to(base_url(''));
            }
        }
        //permission add
        if($uri->getSegment(2)==='add_conference_impact'){
            if($_SESSION['user_type'] !== 'leader'){
                return redirect()->to(base_url('forms/show_conferences_impact'));
            }
        }
        //permission edit
        if($uri->getSegment(2)==='edit_conference_impact'){
            if($_SESSION['user_type'] !== 'leader'){
                return redirect()->to(base_url('forms/show_conferences_impact'));
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {

    }
}


