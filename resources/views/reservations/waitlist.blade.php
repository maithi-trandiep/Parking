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
                        <h1 class="m-0">Liste d'attente</h1>
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
                            <div class="card-header">Réservations</div>

                            <div class="card-body">
                                @if (session()->has('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session()->get('status') }}
                                    </div>
                                @endif

                                <div>
                                    Masquer colonne : <a class="toggle-vis" data-column="0">ID utilisateur</a> - <a class="toggle-vis" data-column="1">Statut</a> - <a class="toggle-vis" data-column="2">Rang d'attente</a> - <a class="toggle-vis" data-column="3">Date de réservation</a> - <a class="toggle-vis" data-column="4">Action</a>
                                </div>
                                <br>
                                <div class="table-responsive">
                                    <table class="table table-reservation">
                                        <thead>
                                            <tr>
                                                <th>ID utilisateur</th>
                                                <th>Statut</th>
                                                <th>Rang d'attente</th>
                                                <th>Date de réservation</th>
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

        <!-- Edit User Modal -->
        <div class="modal" id="EditRangModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Modifier rang d'attente</h4>
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
                            <strong>Rang d'attente a été modifié avec succès.</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div id="EditRangModalBody">
                            
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="SubmitEditRangForm">Modifier</button>
                        <button type="button" class="btn btn-danger modelClose" data-dismiss="modal">Fermer</button>
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
            // pageLength: 5,
            // scrollX: true,
            order: [[ 0, "desc" ]],
            language: { 
                url: "resources/lang/fr/dataTables.french.json"
            },
            ajax: "{{ route('get-adminWaitlist') }}",
            columns: [
                {data: 'user_id', name: 'user_id'},
                {data: 'statutR', render:function(data){
                    if(data==0){
                        return '<span class="badge badge-warning">Attend</span>'
                    }
                    if(data==1){
                        return '<span class="badge badge-success">Réservé</span>'
                    }
                }
            },
                {data: 'rangAttente', name: 'rangAttente'},
                {data: 'dateDemande', name: 'dateDemande'},
                {data: 'Actions', name: 'Actions', orderable:false, serachable:false, sClass:'text-center'},
            ],
            columnDefs: [
                {targets: [0,1,2,3,4], type: "dom-text", render: function(data, type, row, meta){
                return data;
            }},         
            ]
        });


        // Get single article in EditModel
        $('.modelClose').on('click', function(){
            $('#EditRangModal').hide();
        });
        var id;
        $('body').on('click', '#getEditRangData', function(e) {
            // e.preventDefault();
            $('.alert-danger').html('');
            $('.alert-danger').hide();
            id = $(this).data('id');
            $.ajax({
                url: "admin-reservations/"+id+"/edit",
                method: 'GET',
                // data: {
                //     id: id,
                // },
                success: function(result) {
                    console.log(result);
                    $('#EditRangModalBody').html(result.html);
                    $('#EditRangModal').show();
                }
            });
        });

        // Update article Ajax request.
        $('#SubmitEditRangForm').click(function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "admin-reservations/"+id,
                method: 'PUT',
                data: {
                    rangAttente: $('#rangAttente').val(),
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
                        $('.table-reservation').DataTable().ajax.reload();
                        setTimeout(function(){ 
                            $('.alert-success').hide();
                            $('#EditRangModal').hide();
                        }, 2000);
                    }
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
</body>
</html>


