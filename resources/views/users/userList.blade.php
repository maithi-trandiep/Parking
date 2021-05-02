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
                        <h1 class="m-0">Liste des utilisateurs</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
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
                    <div class="row justify-content-center">
                    <div class="col-md-12">
                        @if(session('message'))
                        <div class="alert alert-success">
                            {{session('message')}}
                        </div>
                        @endif
                        <div class="card">
                            <div class="card-header">Liste des utilisateurs</div> 
                            <div class="card-body">
                                <button style="float: left; font-weight: 900;" class="btn btn-info btn-sm" type="button"  data-toggle="modal" id="getCreateArticleModal" data-target="#CreateArticleModal">
                                Créer utilisateur
                                </button>
                            </br>
                            </br>
                            <div>
                            Masquer colonne : <a class="toggle-vis" data-column="0">ID</a> - <a class="toggle-vis" data-column="1">Prénom</a> - <a class="toggle-vis" data-column="2">Nom</a> - <a class="toggle-vis" data-column="3">Email</a> - <a class="toggle-vis" data-column="4">Date de création</a>
                            - <a class="toggle-vis" data-column="5">Action</a>
                            </div>
                            <br>
                            <div class="table-responsive">
                                <table class="table table-user">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Prénom</th>
                                            <th>Nom</th>
                                            <th>Email</th>
                                            <th>Date de création</th>
                                            <th width="150" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>    
                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
                <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Create User Modal -->
        <div class="modal" id="CreateArticleModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    
                    <div class="modal-header">
                        <h4 class="modal-title">Créer utilisateur</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    
                    <div class="modal-body">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                            <strong>L'utilisateur a été ajouté avec succès.</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="form-group">
                            <label for="name">Prénom:</label>
                            <input type="text" class="form-control" name="nameCreate" id="nameCreate">
                        </div>
                        <div class="form-group">
                            <label for="lname">Nom:</label>
                            <input type="text" class="form-control" name="lnameCreate" id="lnameCreate">
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="text" class="form-control" name="emailCreate" id="emailCreate">
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="text" class="form-control" name="passwordCreate" id="passwordCreate">
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="SubmitCreateArticleForm">Créer</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit User Modal -->
        <div class="modal" id="EditArticleModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Modifier utilisateur</h4>
                        <button type="button" class="close modelClose" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                            <strong>L'utilisateur a été modifié avec succès.</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div id="EditArticleModalBody">
                            
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="SubmitEditArticleForm">Modifier</button>
                        <button type="button" class="btn btn-danger modelClose" data-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete User Modal -->
        <div class="modal" id="DeleteArticleModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Supprimer utilisateur</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <h4>Etes-vous sûr de vouloir supprimer cet utilisateur ?</h4>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" id="SubmitDeleteArticleForm">Oui</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Non</button>
                    </div>
                </div>
            </div>
        </div>

    <!-- Main Footer -->
    @include('includes.footer')
</div>
<!-- ./wrapper -->

<!-- jQuery -->
@include('includes.jQuery')

<script type="text/javascript">
    $(document).ready(function() {
        // init datatable.
        var dataTable = $('.table-user').DataTable({
            processing: true,
            serverSide: true,
            // autoWidth: false,
            pageLength: 5,
            // scrollX: true,
            "order": [[ 0, "desc" ]],
            ajax: "{{ route('get-users') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'lname', name: 'lname'},
                {data: 'email', name: 'email'},
                {data: 'created_at', name: 'created_at'},
                {data: 'Actions', name: 'Actions', orderable:false, serachable:false, sClass:'text-center'},
            ],
            columnDefs: [
                {targets: [0,1,2,3,4,5], type: "dom-text", render: function(data, type, row, meta){
                return data;
            }},
            ]
        });

        // Create article Ajax request.
        $('body').on('click', '#getCreateArticleModal', function(){
            $('#CreateArticleModal').modal('show');
        });
        $('#SubmitCreateArticleForm').click(function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('users.store') }}",
                method: 'post',
                data: {
                    name: $('#nameCreate').val(),
                    lname: $('#lnameCreate').val(),
                    email: $('#emailCreate').val(),
                    password: $('#passwordCreate').val(),
                },
                success: function(result) {
                    if(result.errors) {
                        $('.alert-danger').html('');
                        $.each(result.errors, function(key, value) {
                            $('.alert-danger').show();
                            $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
                        });
                    } else {
                        $('.alert-danger').hide();
                        $('.alert-success').show();
                        $('.table-user').DataTable().ajax.reload();
                        setTimeout(function(){ 
                            $('.alert-success').hide();
                            $('#CreateArticleModal').modal('hide');
                            location.reload();
                        }, 2000);
                    }
                }
            });
        });

        // Get single article in EditModel
        $('.modelClose').on('click', function(){
            $('#EditArticleModal').hide();
        });
        var id;
        $('body').on('click', '#getEditArticleData', function(e) {
            // e.preventDefault();
            $('.alert-danger').html('');
            $('.alert-danger').hide();
            id = $(this).data('id');
            $.ajax({
                url: "users/"+id+"/edit",
                method: 'GET',
                // data: {
                //     id: id,
                // },
                success: function(result) {
                    console.log(result);
                    $('#EditArticleModalBody').html(result.html);
                    $('#EditArticleModal').show();
                }
            });
        });

        // Update article Ajax request.
        $('#SubmitEditArticleForm').click(function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "users/"+id,
                method: 'PUT',
                data: {
                    name: $('#name').val(),
                    lname: $('#lname').val(),
                    email: $('#email').val(),
                },
                success: function(result) {
                    if(result.errors) {
                        $('.alert-danger').html('');
                        $.each(result.errors, function(key, value) {
                            $('.alert-danger').show();
                            $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
                        });
                    } else {
                        $('.alert-danger').hide();
                        $('.alert-success').show();
                        $('.table-user').DataTable().ajax.reload();
                        setTimeout(function(){ 
                            $('.alert-success').hide();
                            $('#EditArticleModal').hide();
                        }, 2000);
                    }
                }
            });
        });

        // Delete article Ajax request.
        var deleteID;
        $('body').on('click', '.btnDelete', function(){
            deleteID = $(this).data('id');
            console.log('deleteid', deleteID);
            $('#DeleteArticleModal').modal('show');
        });
        $('#SubmitDeleteArticleForm').click(function(e) {
            e.preventDefault();
            var id = deleteID;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "users/"+id,
                method: 'DELETE',
                success: function(result) {
                    setTimeout(function(){ 
                        $('.table-user').DataTable().ajax.reload();
                        $('#DeleteArticleModal').modal('hide');
                    }, 1000);
                }
            });
        });
        // Hide column
        $("a.toggle-vis").on("click", function(e) {
            e.preventDefault();
            var column = dataTable.column($(this).attr("data-column"));
            column.visible(!column.visible());
        });
});
</script>