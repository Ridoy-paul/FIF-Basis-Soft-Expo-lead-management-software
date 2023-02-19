@extends('layouts.app')
@section('body_content')

<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>


    <div class="container p-4">
    <div class="row shadow rounded bg-light" style="padding-top:20px">
      <div class="col-md-10">
      <h2>All Visitors Data</h2>
      </div>
      
      <div class="col-md-12 mb-3">
        <table class="table table-bordered data-table display nowrap">
          <thead>
              <tr>
                  <th>Visitor Info</th>
                  <th>Added By</th>
                  <th>Action</th>
              </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
</div>
</body>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>


<script type="text/javascript">
  $(function () {
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('visitor.index.data') }}",
        columns: [
            {data: 'visitor_info', name: 'visitor_info'},
            {data: 'added_by', name: 'added_by'},
            {data: 'action', name: 'action'},
        ],
        "scrollY": "300px",
        "pageLength": 50,
        "ordering": false,
    });
    
  });

</script>
@endsection
