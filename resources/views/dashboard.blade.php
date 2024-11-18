<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>


  </head>
  <body>
    <div class="container">
        <h1>Dashboard</h1>
        <a href="logout">Logout</a>
        <a href="javascript:void(0)"  id ="task_new" class="edit btn btn-success btn-sm">Add</a> 
        <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
                <th width="105px">Action</th>
            </tr>
        </thead>
        <tbody>
                <td>{{$data->user_name}}</td>
                <td>{{$data->user_email}}</td>
                <td>{{$data->user_status}}</td>
                <td></td>
        </tbody>
    </table>
<!-- Modal View -->
<div id="view-modal" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-white">Modal title</h5>
                <button type="button" class="btn btn-light" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" name="name" class="form-control" id="name">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control"id="email">
                        <input type="text" name="id" class="form-control"id="id">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" id="password">
                    </div>   
                    <div class="form-group">
                        <label for="password">Status</label>
                        <input type="text" name="status" class="form-control" id="status">
                    </div> 
                    <button id="save" type="submit" class="btn btn-block btn-success">Save</button>  
            </div>
            <div class="modal-footer">
              
                <!-- <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button> -->
            </div>
        </div>
    </div>
</div>

<div id="view-modaladd" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-white">Modal title</h5>
                <button type="button" class="btn btn-light" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" name="name" class="form-control" id="name">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control"id="email">
                        <input type="text" name="id" class="form-control"id="id">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" id="password">
                    </div>   
                    <div class="form-group">
                        <label for="password">Status</label>
                        <input type="text" name="status" class="form-control" id="status">
                    </div> 
                    <button id="save" type="submit" class="btn btn-block btn-success">Save</button>  
            </div>
            <div class="modal-footer">
              
                <!-- <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button> -->
            </div>
        </div>
    </div>
</div>
</div>
  </body>
  <script type="text/javascript">
  $(function () {
      
    let table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('dashboard') }}",
        columns: [
            {data: 'user_id', name: 'user_id'},
            {data: 'user_fullname', name: 'name'},
            {data: 'user_email', name: 'email'},
            {data: 'user_status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });


    $('body').on('click', '#task_add', function(e) {    

        $.post("{{ route('user_edit') }}", {
                id: $(this).data('id'),
                _token: '{{ csrf_token() }}'
            }).done(function(res) { 
                $("#view-modal").modal('show');
                $('#id').val(res.data[0].user_id);
                $('#name').val(res.data[0].user_fullname);
                $('#email').val(res.data[0].user_email);
                $('#password').val(res.data[0].user_password);
                $('#status').val(res.data[0].user_status);
            }).fail(function(data) {
                console.log(data.responseText)
        });

    });

    $('#save').click(function(e) {
            $.post("{{ route('user_update') }}", {
                id: $('#id').val(),
                name: $('#name').val(),
                email: $('#email').val(),
                password: $('#password').val(),
                status: $('#status').val(),
                _token: '{{ csrf_token() }}'
            }).done(function(res) { 
                $("#view-modal").modal('hide');
            }).fail(function(data) {
                console.log(data.responseText)
        });
    });  
    
    $('body').on('click', '#task_dell', function(e) {    

        $.post("{{ route('user_delete') }}", {
                id: $(this).data('id'),
                _token: '{{ csrf_token() }}'
            }).done(function(res) { 
                alert('Success');
            }).fail(function(data) {
                console.log(data.responseText)
        });

    });    

    $('body').on('click', '#task_new', function(e) {  
        $("#view-modaladd").modal('show');
    });   

    $('body').on('click', '#task_new_add', function(e) {    
        $("#view-modaladd").modal('hide');

        $.post("{{ route('user_new') }}", {
            id: $('#id').val(),
                name: $('#name').val(),
                email: $('#email').val(),
                password: $('#password').val(),
                status: $('#status').val(),
                _token: '{{ csrf_token() }}' 
            }).done(function(res) { 
                alert('Success');
            }).fail(function(data) {
                console.log(data.responseText)
        });

    }); 
      
  });
</script>
</html>