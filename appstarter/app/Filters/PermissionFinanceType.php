<?php
namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class PermissionFinanceType implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = \Config\Services::session();
        $uri= service('uri');
        //permission show
        if($uri->getSegment(2) ==='show_finance_type'){
            if($_SESSION['user_type'] === 'management'){
                return redirect()->to(base_url(''));
            }
        }
        //permission add
        if($uri->getSegment(2)==='add_total_financing' || $uri->getSegment(2)==='add_allocation_financing' || $uri->getSegment(2)==='add_remedy_financing' || $uri->getSegment(2)==='add_finance_type'){
            if($_SESSION['user_type'] !== 'leader'){
                return redirect()->to(base_url('projects/show_project/'.$uri->getSegment(3)));
            }
        }
        //permission edit
        if($uri->getSegment(2)==='edit_total_financing' || $uri->getSegment(2)==='edit_allocation_financing' || $uri->getSegment(2)==='edit_remedy_financing' || $uri->getSegment(2)==='edit_finance_type'){
            if($_SESSION['user_type'] !== 'leader'){
                return redirect()->to(base_url('projects/show_finance_type/'.$uri->getSegment(3)));
            }
        }

    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {

    }
}

