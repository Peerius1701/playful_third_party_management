<?php
namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\forms\publication\ViewPublications;
class PermissionPublication implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = \Config\Services::session();
        $uri= service('uri');
        $oViewPublications = new ViewPublications();
        //permission show
        /*
            if ($uri->getSegment(2) === 'show_publications' || $uri->getSegment(2) === 'show_publication') {
            if ($_SESSION['user_type'] === 'management') {
                return redirect()->to(base_url(''));
            }
        }
        */
        //permission add
        if($uri->getSegment(2)==='add_publication'){
            if($_SESSION['user_type'] === 'management'){
                return redirect()->to(base_url('forms/show_publications'));
            }
        }
        //permission edit
        if($uri->getSegment(2)==='edit_publication'){
            if($_SESSION['user_type'] === 'management'){
                return redirect()->to(base_url('forms/show_publication/'.$uri->getSegment(3)));
            }
            if($_SESSION['user_type'] === 'employee'){
                if(!$oViewPublications->checkPersonalPublications($uri->getSegment(3))){
                    return redirect()->to(base_url('forms/show_publication/'.$uri->getSegment(3)));
                }
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {

    }
}


