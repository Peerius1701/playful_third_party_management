<?php
namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class PermissionJournalImpact implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = \Config\Services::session();
        $uri= service('uri');
        //permission show
        if($uri->getSegment(2)==='show_journals_impact'){
            if($_SESSION['user_type'] === 'management'){
                return redirect()->to(base_url(''));
            }
        }
        //permission add
        if($uri->getSegment(2)==='add_journal_impact'){
            if($_SESSION['user_type'] !== 'leader'){
                return redirect()->to(base_url('forms/show_journals_impact'));
            }
        }
        //permission edit
        if($uri->getSegment(2)==='edit_journal_impact'){
            if($_SESSION['user_type'] !== 'leader'){
                return redirect()->to(base_url('forms/show_journals_impact'));
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {

    }
}


