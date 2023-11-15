<?php

namespace Ridwanhoq\SimpleBlog\Controllers;

use Illuminate\Routing\Controller;

class SbPostController extends Controller
{
    public function index()
    {
        return view('simple-blog::index');
    }
    
    public function create()
    {
        return view('simple-blog::create');
    }
    
    public function store()
    {
        
    }
    
    public function show($id)
    {
        
    }
    
    public function edit($id)
    {
        
    }
    
    public function update($id)
    {
        
    }
    
    public function destroy($id)
    {
        
    }
    
    public function search()
    {
        
    }

}