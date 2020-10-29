<?php require_once 'includes/templates/header.php'?>

<!-- add_category modal -->
<div class="modal" id="add_category" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!-- add_category modal -->

<!-- add_brand modal -->
<div class="modal" id="add_brand" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!-- add_brand modal -->

<!-- add_product modal -->
<div class="modal" id="add_product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!-- add_product modal -->

<div class="container mt-4">
    <div class="row">
        <div class="col-md-4 mb-4 mb-md-0">
            <div class="card mx-auto h-100">
                <img class="card-img-top p-2 mx-auto" style="width: 60%" src="<?php echo $config['app_url']?>layout/images/user.png" alt="user">
                <div class="card-body">
                    <h4 class="card-title">Profile Info</h4>
                    <p class="card-text"><i class="fas fa-user text-info"></i>&nbsp;Abbas Alshaqaq</p>
                    <p class="card-text"><i class="fas fa-user-tag text-info"></i>&nbsp;Admin</p>
                    <p class="card-text"><i class="fas fa-clock text-info"></i>&nbsp;Last Login: xxxx-xx-xx</p>
                    <a href="#!" class="btn btn-info"><i class="far fa-edit"></i>&nbsp;Edit Profile</a>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="jumbotron w-100 h-100 pt-2">
                <h1 class="pb-5">Welcome Admin,</h1>
                <div class="row">
                    <div class="col-sm-6 d-flex justify-content-center">
                        <iframe src="http://free.timeanddate.com/clock/i7itywhw/n5397/szw160/szh160/hoc000/hbw4/cf100/hgr0/fav0/fiv0/mqc000/mqs3/mql25/mqw6/mqd96/mhc000/mhs3/mhl20/mhw6/mhd96/mmc000/mms3/mml10/mmw2/mmd96/hhw16/hmw16/hmr4/hsc000/hss3/hsl90" frameborder="0" width="160" height="160"></iframe>
                    </div>
                    <div class="col-sm-6 mt-5 mt-sm-0">
                        <div class="card border-0">
                            <div class="card-body">
                                <h4 class="card-title">Orders</h4>
                                <p class="card-text">Here you can make a new orders and print invoices.</p>
                                <a href="#!" class="btn btn-secondary"><i class="fas fa-plus"></i>&nbsp;New Order</a>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="container my-4">
    <div class="row">
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Categories<i class="fas fa-tags float-right text-info"></i></h4>
                    <p class="card-text" style="height: 72px">Here you can manage your categories and add new category or sub-category</p>
                    <a href="#!" class="btn btn-success" data-toggle="modal" data-target="#add_category"><i class="fas fa-plus"></i>&nbsp;Add</a>
                    <a href="#!" class="btn btn-warning"><i class="fas fa-pencil-alt"></i>&nbsp;Manage</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Brands<i class="fab fa-buffer float-right text-info"></i></h4>
                    <p class="card-text" style="height: 72px">Here you can manage your brands and add new brand</p>
                    <a href="#!" class="btn btn-success" data-toggle="modal" data-target="#add_brand"><i class="fas fa-plus"></i>&nbsp;Add</a>
                    <a href="#!" class="btn btn-warning"><i class="fas fa-pencil-alt"></i>&nbsp;Manage</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Products<i class="fas fa-shopping-bag float-right text-info"></i></h4>
                    <p class="card-text" style="height: 72px">Here you can manage your products and add new product</p>
                    <a href="#!" class="btn btn-success"  data-toggle="modal" data-target="#add_product"><i class="fas fa-plus"></i>&nbsp;Add</a>
                    <a href="#!" class="btn btn-warning"><i class="fas fa-pencil-alt"></i>&nbsp;Manage</a>
                </div>
            </div>
        </div>

    </div>
</div>

<?php require_once 'includes/templates/footer.php'?>
