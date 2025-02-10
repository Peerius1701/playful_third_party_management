<?php
namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\projects\business_trips\ViewBusinessTrips;
class PermissionBusinessTrip implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = \Config\Services::session();
        $uri= service('uri');
        $oViewBusinessTrips = new ViewBusinessTrips();
        //permission show
        /*
        if ($uri->getSegment(2) === 'show_business_trips' || $uri->getSegment(2) === 'show_business_trip') {
            if ($_SESSION['user_type'] === 'management') {
                return redirect()->to(base_url(''));
            }
        }
        */
        //permission add
        if($uri->getSegment(2)==='add_business_trip'){
            if($_SESSION['user_type'] !== 'leader'){
                return redirect()->to(base_url('projects/show_business_trips'));
            }
        }
        //permission edit
        if($uri->getSegment(2)==='edit_business_trip'){
            if($_SESSION['user_type'] === 'management'){
                return redirect()->to(base_url('forms/show_business_trip/'.$uri->getSegment(3)));
            }
            if($_SESSION['user_type'] === 'employee'){
                if(!$oViewBusinessTrips->checkPersonalBusinessTrips($uri->getSegment(3))){
                    return redirect()->to(base_url('forms/show_business_trip/'.$uri->getSegment(3)));
                }
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {

    }
}

