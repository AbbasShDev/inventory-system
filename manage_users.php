<?php
session_start();
$pageTitle = 'Manage Users';
require_once 'includes/templates/header.php';
require_once 'includes/classes/Database.php';

if (!isset($_SESSION['user_id'])){
    header("location: $config[app_url]");
    die();
}


if ($_SESSION['user_role'] != 'Admin'){
    header('location:dashboard');
    die();
}

$getAllWithPagination = new Database();

$table = 'users';
$sql ='SELECT * FROM users ORDER BY id DESC';

$pagination = $getAllWithPagination->getAllResultWithPagination('manage_users',$table, $sql); ?>


<!-- add_user modal -->
<div class="modal add_user_modal" id="add_user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- pre-loader -->
            <div class="overlay" style="position: absolute !important;"><div class="loader"></div></div>
            <!-- pre-loader -->
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="add_user">
                    <div class="form-group">
                        <label>Username</label>
                        <input name="username" class="form-control" placeholder="Enter Username" type="text" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input name="email" class="form-control" placeholder="Enter Email" type="email" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input name="password" class="form-control" placeholder="******" type="password" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>Re-enter password</label>
                        <input name="password_conf" class="form-control" placeholder="******" type="password" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="select_brand">User role</label>
                        <select name="select_Role" id="select_Role" class="form-control" required>
                            <option value="Admin">Admin</option>
                            <option value="Manager">Manager</option>
                            <option value="User" selected>User</option>
                        </select>
                    </div>
                    <!-- msg -->
                    <div id="msg"></div>
                    <!-- msg -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-info">Add user</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- add user modal -->

<!-- edit user modal -->
<div class="modal edit_user_modal" id="edit_user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- pre-loader -->
            <div class="overlay" style="position: absolute !important;"><div class="loader"></div></div>
            <!-- pre-loader -->
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form class="edit_user" enctype="multipart/form-data">
                    <input type="hidden" name="edit_user_id" id="edit_user_id" value="">
                    <div class="form-group">
                        <label>Username</label>
                        <input name="edit_username" id="username" class="form-control" placeholder="Enter Username" type="text" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input name="email" id="email" class="form-control" placeholder="Enter Email" type="email" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input name="password" class="form-control" placeholder="******" type="password" autocomplete="off">
                        <small class="form-text text-muted">Leave empty if you don't want to change it</small>
                    </div>
                    <div class="form-group">
                        <label>Re-enter password</label>
                        <input name="password_conf" class="form-control" placeholder="******" type="password" autocomplete="off">
                        <small class="form-text text-muted">Leave empty if you don't wnt to change it</small>
                    </div>
                    <div class="form-group">
                        <label for="select_brand">User role</label>
                        <select name="select_Role" id="select_Role" class="form-control" required>
                            <option value="Admin">Admin</option>
                            <option value="Manager">Manager</option>
                            <option value="User" selected>User</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="select_brand">User avatar</label>
                        <input type="file" name="avatar" class="form-control" id="avatar">
                        <small class="form-text text-muted">Leave empty if you don't want to change it</small>
                    </div>
                    <!-- msg -->
                    <div id="edit_msg"></div>
                    <!-- msg -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-info">Update user</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- add_product modal -->

<div class="container my-5 manage-categories">

    <h2 class="text-center mt-5 mb-3">Manage Users</h2>
    <a href="#!" class="btn btn-info mb-2"  data-toggle="modal" data-target="#add_user"><i class="fas fa-plus"></i>&nbsp;Add User</a>
    <table class="table table-striped table-hover table-bordered text-center table-responsive">
        <thead>
        <tr>
            <th>#</th>
            <th>Avatar</th>
            <th style="width: 110px !important; min-width: 110px !important;">Username</th>
            <th style="width: 261px !important; min-width: 110px !important;">Email</th>
            <th style="min-width: 116px !important;">User Role</th>
            <th style="min-width: 116px !important;">Last Login</th>
            <th style="min-width: 116px !important;">Added Date</th>
            <th style="min-width: 134px !important;">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($pagination['sql_result'] as $r):?>
            <tr>
                <td><?php echo $r['id']?></td>
                <td><img class="rounded-circle" style="width: 40px !important;" src="
                <?php
                    if (empty($r['avatar'])){
                        echo $config['app_url'] .'layout/images/user.png';
                    }else {
                        echo $config['app_url'] .$r['avatar'];
                    }
                    ?>
                " alt="user"></td>
                <td><?php echo $r['user_name']?></td>
                <td><?php echo $r['user_email']?></td>
                <td><?php echo $r['user_type']?></td>
                <td><?php echo $r['user_last_login']?></td>
                <td><?php echo $r['created_at']?></td>
                <td>
                    <button class="btn btn-sm btn-danger delete-user" data-uid="<?php echo $r['id']?>">Delete</button>
                    <button class="btn btn-sm btn-info edit-user" data-toggle="modal" data-target="#edit_user" data-uid="<?php echo $r['id']?>">Edit</button>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>


    <div class="float-left">
        Page <?php echo $pagination['page']?> of <?php echo $pagination['total_pages']?>
    </div>
    <div class="float-right">
        <nav aria-label="Page navigation example">
            <ul class="pagination pagination-sm">
                <?php echo $pagination['pagination']?>
            </ul>
        </nav>
    </div>

</div>

<?php require_once 'includes/templates/footer.php'?>
<script>
    $(document).ready(function () {

        //add user
        $('.add_user').on('submit', function (e) {
            e.preventDefault();
            $('.add_user_modal .overlay').show();
            $.ajax({
                method:'POST',
                url:'process',
                data:$('.add_user').serialize(),
                success: function (data) {
                    $('.add_user_modal .overlay').hide();

                    if (data == 'User created Successfully'){
                        window.location.href = '';
                    }else {
                        $(document).scrollTop(0);
                        $('#msg').html('');
                        $('#msg').append(data);
                    }

                }
            })

        })

        //Update user (get info)
        $('.edit-user').on('click', function () {
            $.ajax({
                method:'POST',
                url:'process',
                dataType:'json',
                data:{get_user_info: $(this).data('uid')},
                success: function (data) {
                    $('.edit_user_modal #edit_user_id').val(data["id"]);
                    $('.edit_user_modal #username').val(data["user_name"]);
                    $('.edit_user_modal #email').val(data["user_email"]);
                    $('.edit_user_modal #select_Role').val(data["user_type"]);

                }
            })
        })
        //Update user
        $('.edit_user').on('submit', function (e) {
            e.preventDefault();

                $.ajax({
                    method:'POST',
                    url:'process',
                    data: new FormData(this),
                    contentType: false,
                    cache:false,
                    processData: false,
                    success: function (data) {

                        if (data == 'User updated Successfully'){
                            window.location.href = '';
                        }else {
                            $(document).scrollTop(0);
                            $('.edit_user_modal #edit_msg').html('');
                            $('.edit_user_modal #edit_msg').html(data);
                        }

                    }
                })

        })

        //Delete user
        $('.delete-user').on('click', function () {

            if (confirm('Confirm deleting user..?')){
                $.ajax({
                    method:'POST',
                    url:'process',
                    data:{delete_user_id: $(this).data('uid')},
                    success: function (data) {
                        window.location.href = '';

                    }
                })

            }else {
                return false;
            }

        })

    });
</script>