<?php 
/**
 * Displays home view with documentation
 */
class homeController extends Controller
{
    /**
     * Displays home view (documentation)
     */
    public function index()
    {
        return $this->view('home');
    }
}
