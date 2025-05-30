<!DOCTYPE html>
<html>
<head>
    <title>Establishment List</title>
    <link rel="stylesheet" href="page-css/user.css"> <!-- Your custom CSS -->
    <!-- Include Bootstrap if you're using it -->
</head>
<body>

<div class="container-fluid">
    <div class="col-lg-12">
        <div class="row mb-4 mt-4">

        </div>
        <div class="row">
            <div class="card col-md-12">
                <div class="card-header">
                    <b>Account List</b>
                    <span class="float:right"><button class="btn btn-primary float-right btn-sm" id="new_user"><i
                                class="fa fa-plus"></i> New
                            user</button>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table-striped table-bordered col-md-12">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Username</th>
                                    <th class="text-center">Establishment</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include 'db_connect.php';
                                $est = $conn->query("SELECT * FROM establishments ");
                                $est_name[0] = "Can manage all";
                                while ($row = $est->fetch_assoc()) {
                                    $est_name[$row['id']] = $row['name'];
                                }
                                $users = $conn->query("SELECT * FROM users order by name asc");
                                $i = 1;
                                while ($row = $users->fetch_assoc()):
                                    ?>
                                    <tr>
                                        <td class="text-center">
                                            <?php echo $i++ ?>
                                        </td>
                                        <td>
                                            <?php echo ucwords($row['name']) ?>
                                        </td>
                                        <td>
                                            <?php echo $row['username'] ?>
                                        </td>
                                        <td>
                                            <?php echo $est_name[$row['establishment_id']] ?>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-primary">Action</button>
                                                <button type="button"
                                                    class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item edit_user" href="javascript:void(0)"
                                                        data-id='<?php echo $row['id'] ?>'>Edit</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item delete_user" href="javascript:void(0)"
                                                        data-id='<?php echo $row['id'] ?>'>Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

<script>
    $('table').dataTable();

    $('#new_user').click(function () {
        uni_modal('New User', 'manage_user.php')
    })

    $('.edit_user').click(function () {
        uni_modal('Edit User', 'manage_user.php?id=' + $(this).attr('data-id'))
    })

    $('.delete_user').click(function () {
        _conf("Are you sure to delete this user?", "delete_user", [$(this).attr('data-id')])
    })

    function delete_user($id) {
        start_load()
        $.ajax({
            url: 'ajax.php?action=delete_user',
            method: 'POST',
            data: { id: $id },
            success: function (resp) {
                if (resp == 1) {
                    alert_toast("Data successfully deleted", 'success')
                    setTimeout(function () {
                        location.reload()
                    }, 1500)
                }
            }
        })
    }
</script>
