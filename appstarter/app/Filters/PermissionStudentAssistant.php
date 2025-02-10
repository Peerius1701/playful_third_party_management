<?php
namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class PermissionStudentAssistant implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = \Config\Services::session();
        $uri= service('uri');
        //permission show
        /*
        if ($uri->getSegment(2) === 'show_student_assistants' || $uri->getSegment(2) === 'show_student_assistant') {
            if ($_SESSION['user_type'] === 'management' || $_SESSION['user_type'] === 'employee') {
                return redirect()->to(base_url(''));
            }
        }
        */
        //permission add
        if($uri->getSegment(2)==='add_student_assistant'){
            if($_SESSION['user_type'] !== 'leader'){
                return redirect()->to(base_url('projects/show_student_assistants'));
            }
        }
        //permission edit
        if($uri->getSegment(2)==='edit_student_assistant'){
            if($_SESSION['user_type'] !== 'leader'){
                return redirect()->to(base_url('projects/show_student_assistant/'.$uri->getSegment(3)));
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {

    }
}

