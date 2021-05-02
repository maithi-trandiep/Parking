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
                        <div class="card">
                            <div class="card-header">Réservations</div>

                            <div class="card-body">
                                @if (session()->has('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session()->get('status') }}
                                    </div>
                                @endif

                                <div>
                                    Masquer colonne : <a class="toggle-vis" data-column="0">ID utilisateur</a> - <a class="toggle-vis" data-column="1">Place</a> - <a class="toggle-vis" data-column="2">Statut</a> - <a class="toggle-vis" data-column="3">Date de réservation</a> - <a class="toggle-vis" data-column="4">Date de début</a>
                                    - <a class="toggle-vis" data-column="5">Date de fin</a> - <a class="toggle-vis" data-column="6">Action</a>
                                </div>
                                <br>
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
            ajax: "{{ route('get-adminReservations') }}",
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
            ],
            columnDefs: [
                {targets: [0,1,2,3,4,5,6], type: "dom-text", render: function(data, type, row, meta){
                return data;
            }},
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


