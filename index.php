<!DOCTYPE html>
<html lang="en">
<head>
  <title>CRUD PHP</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
  <link rel="stylesheet" href="CSS/style.css">
</head>
<body>
  <div class="container back">
    <h1 class="text-center">Crud with PHP, PDO, Ajax and Datatables</h1>
  
    <div class="row">
      <div class="col-2 offset-10">
        <div class="text-center">
          <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#modalUser" id="btnCreate">
            <i class="bi bi-plus-circle-fill"></i>Create
          </button>
        </div>
      </div>  
    </div>
  <br/>
  <br/>

    <div class="table-responsive">
      <table id="data_user" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Last Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Image</th>
            <th>Creation date</th>
            <th>Edit</th>
            <th>Delete</th>
          </tr>
        </thead>
      </table>
    </div>
    
    <!-- Modal -->
    <div class="modal fade" id="modalUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Enter new register</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form action="POST" id="form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-body">
                  <label for="name">Enter your name</label>
                  <input type="text" name="name" id="name" class="form-control">
                  <br/>
                  <label for="lastName">Enter your last name</label>
                  <input type="text" name="lastName" id="lastName" class="form-control">
                  <br/>
                  <label for="phone">Enter your phone</label>
                  <input type="number" name="phone" id="phone" class="form-control">
                  <br/>
                  <label for="email">Enter your email</label>
                  <input type="text" name="email" id="email" class="form-control">
                  <br/>
                  <label for="image">Select your image</label>
                  <input type="file" name="imageUser" id="imageUser" class="form-control">
                  <span id="uploadedImage"></span>
                  <br/>
                </div>
              <div class="modal-footer">
                <input type="hidden" name="idUser" id="idUser">
                <input type="hidden" name="operation" id="operation">
                <input type="submit" name="action" id="action" class="btn btn-success" value="Create">
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript">
      $(document).ready(function(){
        var dataTable = $('#data_user').DataTable({
          "processing":true,
          "serverSide":true,
          "order":[],
          "ajax": {
            url: "get_records.php",
            type: "POST"
          },
          "columnsDefs": [
            {
              "targets": [0, 3, 4],
              "orderable": false,
            },
          ]
        })
      });

      $(document).on('submit', '#form', function(event){
        event.preventDefault();
        var names = $("#name").val();
        var last_names = $("#last_name").val();
        var phone = $("#phone").val();
        var email = $("#email").val();
        var extension = $("#imageUser").val().split('.').pop().toLowerCase();
          
          if(extension != ''){
            if(jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg']) == -1)
              alert("Invalid image extension");
              return false;
          }

          if(names != '' && last_names != '' && email != ''){
            $.ajax({
              url: "create.php",
              method: "POST",
              data: new FormData(this),
              contentType: false,
              processData: false,
              success: function(data){
                alert(data);
                $('#form')[0].reset();
                $('#modalUser').modal.hide();
                dataTable.ajax.reload();
              }
            });
          } else {
            alert("Some fields are required")
          }
      })
  </script>
</body>
</html>