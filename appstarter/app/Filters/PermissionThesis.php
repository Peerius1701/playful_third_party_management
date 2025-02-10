<?php
namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\forms\theses\Thesis;

class PermissionThesis implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = \Config\Services::session();
        $uri = service('uri');
        $oThesisModel = new Thesis();
        //permission show
        if ($uri->getSegment(2) === 'show_theses' || $uri->getSegment(2) === 'show_thesis') {
            if ($_SESSION['user_type'] === 'management') {
                return redirect()->to(base_url(''));
            }
        }
        //permission add
        if ($uri->getSegment(2) === 'add_thesis') {
            if ($_SESSION['user_type'] !== 'leader') {
                return redirect()->to(base_url('forms/show_theses'));
            }
        }
        //permission edit
        if ($uri->getSegment(2) === 'edit_thesis') {
            if ($_SESSION['user_type'] === 'management') {
                return redirect()->to(base_url('forms/show_thesis/' . $uri->getSegment(3)));
            }
            if ($_SESSION['user_type'] === 'employee') {
                if(!$oThesisModel->checkPersonalTheses($uri->getSegment(3))){
                    return redirect()->to(base_url('forms/show_thesis/' . $uri->getSegment(3)));
                }
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {

    }
}



