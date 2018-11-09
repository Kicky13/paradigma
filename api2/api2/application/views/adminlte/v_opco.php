<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Notify Reciever
        <small></small>
    </h1>

</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-xs-12">



            <div class="box">
                <table><tr><td>
                            <div class="box-header">
                                <h3 class="box-title"></h3>
                                <?php // if($this->PERM_WRITE): ?>
                                <div class="box-tools">
                                    <div class="input-group input-group-sm" style="width: 150px; ">
                                        <a href="<?php echo site_url("opco/add") ?>" type="button" class="btn btn-block btn-primary btn-sm">Create New</a>

                                    </div>
                                </div>
                                <?PHP // ENDIF; ?>

                            </div>
                        </td></tr>
                    <!-- /.box-header -->
                    <tr><td>
                            <div class="box-body table-responsive no-padding">
                                <table class="table-fixed table-hover">
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Company</th>
                                        <th>Plant</th>
                                        <th>Area</th>
                                        <?php // if($this->PERM_WRITE): ?><th></th><?php // endif; ?>
                                    </tr>
                                    <?php $x = 1;
                                    foreach ($this->list_opco as $opco):
                                        ?>
                                        <tr>
                                            <td><?php echo $x++; ?></td>
                                            <td><?php echo $opco->FULLNAME ?></td>
                                            <td><?php echo $opco->EMAIL ?></td>
                                            <td><?php echo $opco->NM_COMPANY ?></td>
                                            <td><?php echo $opco->NM_PLANT ?></td>
                                            <td><?php echo $opco->NM_AREA ?></td>
    <?php // if($this->PERM_WRITE):   ?>
                                            <td> 
                                                <a type="button" class="btn btn-warning btn-xs" href="<?php echo site_url("opco/edit/" . $opco->ID_OPCO) ?>">Edit</a>
                                                <a 
                                                    type="button" 
                                                    class="btn btn-danger btn-xs delete" 
                                                    href="<?php echo site_url("opco/delete/" . $opco->ID_OPCO) ?>"
                                                    data-title="Remove Group Employee"
                                                    data-text="This employee group will be removed. Are you sure?"
                                                    >Remove</a>

                                            </td>
    <?php // endif;   ?>
                                            </td>
                                        </tr>
<?php endforeach; ?>
                                </table>
                            </div>
                        </td></tr></table>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>

</section>
<!-- /.content -->
<!-- msg confirm -->
<?php if ($notice->error): ?>
    <a  id="a-notice-error"
        class="notice-error"
        style="display:none";
        href="#"
        data-title="Something Error"
        data-text="<?php echo $notice->error; ?>"
        ></a>

<?php endif; ?>

<?php if ($notice->success): ?>
    <a  id="a-notice-success"
        class="notice-success"
        style="display:none";
        href="#"
        data-title="Done!"
        data-text="<?php echo $notice->success; ?>"
        ></a>            
<?php endif; ?>
<!-- eof msg confirm -->


<script language="javascript" type="text/javascript" src="<?php echo base_url("js/jquery.confirm.js"); ?>" ></script>

<script>

    $(document).ready(function() {
        $(".delete").confirm({
            confirmButton: "Remove",
            cancelButton: "Cancel",
            confirmButtonClass: "btn-danger"
        });

        $(".notice-error").confirm({
            confirm: function(button) { /* Nothing */
            },
            confirmButton: "OK",
            cancelButton: "Cancel",
            confirmButtonClass: "btn-danger"
        });

        $(".notice-success").confirm({
            confirm: function(button) { /* Nothing */
            },
            confirmButton: "OK",
            cancelButton: "Cancel",
            confirmButtonClass: "btn-success"
        });

<?php if ($notice->error): ?>
            $("#a-notice-error").click();
<?php endif; ?>

<?php if ($notice->success): ?>
            $("#a-notice-success").click();
<?php endif; ?>
    });
</script>
