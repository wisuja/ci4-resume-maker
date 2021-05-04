<?php

namespace App\Controllers;

class Profile extends BaseController
{
  use CurlRequest;
  public function index()
  {
    $username = $this->request->getVar('username');
    $url = "http://localhost:8000/profile/{$username}";
    $headers = [
      "Authorization: Bearer {$this->session->get('token')}"
    ];

    return $this->getRequest($url, $headers);
  }

  public function update()
  {
    // dd($this->request->getVar());
    $url = "http://localhost:8000/profile/{$this->session->get('username')}";
    // $request = [
    //   '_method' => 'PUT',
    //   'name' => $this->request->getVar('name'),
    //   'password' => $this->request->getVar('newPassword'),
    //   'password_confirmation' => $this->request->getVar('confirmationPassword')
    // ];
    $request = [
      '_method' => 'PUT',
      'name' => $this->request->getVar('name'),
      'password' => $this->request->getVar('newPassword'),
      'password_confirmation' => $this->request->getVar('confirmationPassword')
    ];
    $headers = [
      "Authorization: Bearer {$this->session->get('token')}"
    ];

    $update = json_decode($this->postRequest($url, $request, $headers), true);
    // dd($update['message']);
    if ($update['message'] == "User's data has been updated successfully") {
      $this->session->setFlashdata('statusUpdate', 'success');
    } else {
      $this->session->setFlashdata('statusUpdate', 'failed');
    }
    return redirect()->to('/chat');
  }
}
