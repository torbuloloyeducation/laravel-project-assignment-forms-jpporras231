<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome', [
    'greeting' => 'Hello, World!',
    'name' => 'John Doe',
    'age' => 30,
    'tasks' => [
        'Learn Laravel',
        'Build a project',
        'Deploy to production',
    ],
]);
Route::view('/', 'Welcome');
Route::view('/about', 'About');
Route::view('/contact', 'Contact');
Route::view('/services', 'Services');
Route::view('/showcases', 'Showcases');
Route::view('/blog', 'Blog');


Route::get('/formtest', function(){
    $emails = session()->get('$emails', []);

    return view('formtest',[
        'emails' => $emails,
    ]);
});
Route::get('/formtest', function () {
    $emails = session()->get('emails', []);
 
    return view('formtest', [
        'emails' => $emails,
    ]);
});
 

Route::post('/formtest', function () {
    
    request()->validate([
        'email' => ['required', 'email'],
    ]);
 
    $email  = request('email');
    $emails = session()->get('emails', []);
 
    
    if (count($emails) >= 5) {
        return redirect('/formtest')
            ->with('warning', 'Maximum of 5 emails reached. Remove one before adding more.');
    }
 
    
    if (in_array($email, $emails)) {
        return redirect('/formtest')
            ->with('warning', "\"{$email}\" is already in the list.");
    }
 
    $emails[] = $email;
    session()->put('emails', $emails);
 
    
    return redirect('/formtest')
        ->with('success', "\"{$email}\" was added successfully.");
});
 

Route::delete('/formtest/{index}', function (int $index) {
    $emails = session()->get('emails', []);
 
    if (isset($emails[$index])) {
        $removed = $emails[$index];
        array_splice($emails, $index, 1);
        session()->put('emails', array_values($emails));
 
        return redirect('/formtest')
            ->with('success', "\"{$removed}\" was removed.");
    }
 
    return redirect('/formtest')
        ->with('warning', 'Email not found.');
});
 

Route::get('/delete-emails', function () {
    session()->forget('emails');
    return redirect('/formtest');
});