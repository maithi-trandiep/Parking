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
                        <h1 class="m-0">Liste des réservations</h1>
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
                        @if(session('warning'))
                        <div class="alert alert-warning">
                            {{session('warning')}}
                        </div>
                        @endif
                        <div class="card">
                            <div class="card-header">Réservations</div>

                            <div class="card-body">
                                @if (session()->has('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session()->get('status') }}
                                    </div>
                                @endif

                                <div class="table-responsive">
                                    <table class="table table-reservation">
                                        <thead>
                                            <tr>
                                                <th>ID utilisateur</th>
                                                <th>Place</th>
                                                <th>Statut</th>
                                                <th>Date de réservation</th>
                                                <th>Date de début</th>
                                                <th>Date de fin</th>
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
                <a href="{{ route('make-userReservations') }}" style="margin:auto;display:block; font-weight: 900;" class="btn btn-info btn-sm" role="button" id="makeReservation">
                    Réserver une place
                </a>
                </div>
                <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Delete Place Modal -->
        <div class="modal" id="DeleteArticleModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Supprimer réservation</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <h4>Etes-vous sûr de vouloir supprimer cette réservation ?</h4>
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
        var dataTable = $('.table-reservation').DataTable({
            processing: true,
            serverSide: true,
            // autoWidth: false,
            pageLength: 5,
            // scrollX: true,
            "order": [[ 0, "desc" ]],
            ajax: "{{ route('get-userReservations') }}",
            columns: [
                {data: 'user_id', name: 'user_id'},
                {data: 'place_id', name: 'place_id'},
                {data: 'statutR', render:function(data){
                    if(data==0){
                        return '<span class="badge badge-warning">Attend</span>'
                    }
                    if(data==1){
                        return '<span class="badge badge-success">Réservé</span>'
                    }
                }
            },
                {data: 'dateDemande', name: 'dateDemande'},
                {data: 'dateDebut', name: 'dateDebut'},
                {data: 'dateFin', name: 'dateFin'},
                {data: 'Actions', name: 'Actions', orderable:false, serachable:false, sClass:'text-center'},
            ]
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
                url: "user-reservations/"+id,
                method: 'DELETE',
                success: function(result) {
                    setTimeout(function(){ 
                        $('.table-reservation').DataTable().ajax.reload();
                        $('#DeleteArticleModal').modal('hide');
                    }, 1000);
                }
            });
        });
        
    
  });
</script>

<!-- <script type="text/javascript">
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
                        setInterval(function(){ 
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
                    password: $('#password').val(),
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
                        setInterval(function(){ 
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
    });
</script> -->
</body>
</html>


