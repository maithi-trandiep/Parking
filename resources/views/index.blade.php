<!DOCTYPE html>
<html lang="en">
@include('includes.header')
<body class="hold-transition sidebar-mini sidebar-collapse">
<div class="wrapper">
    <!-- Navbar -->
    @include('includes.navbar')
    <!-- /.navbar -->
    
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
            <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Accueil</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index">Accueil</a></li>
                    <li class="breadcrumb-item active">Info</li>
                    </ol>
                </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
            <div class="container-fluid"> 
                <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Informations</h5>

                    <p class="card-text">
                    Cet outil Web permet de gérer le parking du personnel des ligues.
                    </p>

                </div>
                </div>
            </div>
            </div>
            <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    @include('includes.footer')
</div>
<!-- ./wrapper -->

<!-- jQuery -->
@include('includes.jQuery')
</body>
</html>
