<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('/template') ?>/style.css" />

    <title>Jobsfree | Chatbot</title>
</head>

<body id="chat">
    <div class="container chat-window h-100 d-flex align-items-center justify-content-center">
        <div class="row w-100">
            <div class="col-md-10 col-sm-12 mx-auto">
                <?php if (session()->getFlashdata('statusUpdate')) : ?>
                    <div class="alert alert-<?= (session()->getFlashdata('statusUpdate') == 'success') ? 'success' : 'danger' ?>"><?= (session()->getFlashdata('statusUpdate') == 'success') ? "Profile updated" : "Failed to update profile" ?> </div>
                <?php endif; ?>
                <div class="card">
                    <div class="card-header text-uppercase fw-bolder px-4 chat-header">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-transparent" data-bs-toggle="modal" data-bs-target="#profileModal" id="profileButton" data-username="<?= session()->get('username') ?>">
                            <img src="<?= base_url('/template') ?>/assets/logo.png" alt="Logo Jobsfree" width="30" class="d-inline-block" />
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="profileModalLabel">Update Profile</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="<?= base_url('/profile/update') ?>" method="POST">
                                        <div class="modal-body">
                                            <h3>Your Data</h3>
                                            <div class="mb-3">
                                                <label for="username" class="col-form-label">Username:</label>
                                                <input type="text" class="form-control" id="username" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label for="name" class="col-form-label">name:</label>
                                                <input type="text" class="form-control" id="name" name="name">
                                            </div>
                                            <hr>
                                            <h3>Change Password</h3>
                                            <div class="mb-3">
                                                <label for="newPassword" class="col-form-label">New Password:</label>
                                                <input type="password" class="form-control" id="newPassword" name="newPassword">
                                            </div>
                                            <div class="mb-3">
                                                <label for="confirmationPassword" class="col-form-label">Re-enter Password:</label>
                                                <input type="password" class="form-control" id="confirmationPassword" name="confirmationPassword">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <h1 class="d-inline-block m-0 fw-bold align-middle fs-5">
                            Jobsfree
                        </h1>
                    </div>
                    <div class="card-body chat-body">
                        <div class="container" id="chat-body-container">
                            <div class="row mb-3 justify-content-start">
                                <div class="col reply">
                                    Hi there! Is there something I can help?
                                    <br>
                                    <strong>/createcv</strong> Create a CV.
                                    <br>
                                    <strong>/history</strong> List all created CVs.
                                    <br>
                                    <strong>/help</strong> List all available commands.
                                    <br>
                                    <strong>/logout</strong> Log out of this session.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer p-0">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control chat-reply border-0 px-4" placeholder="Enter your message..." id="chatbox" name="chatbox" required />
                            <div class="d-flex flex-column justify-content-center align-items-center">
                                <img src="<?= base_url('/template') ?>/assets/spinner.gif" alt="" class="justify-content-center align-items-center" width="25px" height="25px" id="spinner" style="display:none">
                            </div>
                            <button class="btn btn-chat-reply" name="sendButton" id="sendButton" data-username="<?= session('username'); ?>">Send</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Javascript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous">
    </script>

    <!-- jquery script -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>;

    <!-- Custom Script -->
    <script src="<?= base_url('/script') ?>/script.js" crossorigin="anonymous"></script>

</body>

</html>