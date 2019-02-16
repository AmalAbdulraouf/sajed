<!DOCTYPE html>
<html lang="en">

    <?php $this->load->view('new/pages/template/header') ?>

    <body class="">
        <div class="wrapper ">
            <?php $this->load->view('new/pages/template/sidebar') ?>
            <div class="main-panel">
                <!-- Navbar -->
                <?php $this->load->view('new/pages/template/navbar') ?>
                <!-- End Navbar -->
                <div class="panel-header panel-header-sm">
                </div>
                <!--Content is here !-->
                <div class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">

                                </div>
                                <div class="card-body">
                                    <?php $this->load->view('new/pages/' . $name) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $this->load->view('new/pages/template/footer') ?>
            </div>
        </div>
        <?php $this->load->view('new/pages/template/scripts') ?>
    </body>

</html>