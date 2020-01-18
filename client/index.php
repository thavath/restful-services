<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Task Management App.</title>  
     <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/bootstrap/bootstrap.min.css"> 
    <!-- <link rel="stylesheet" href="assets/plugins/fontawesome/font-awesome.min.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <!-- include header -->
    <?php require("layouts/header.php")?>
    <!-- include menu bar -->
    <!-- container section -->
    <div class="container shadow-sm rounded-lg border mb-2">
        <h3 class="text-center p-2 text-info">Hello Client Page. 
            <span class="float-right font-weight-light">
                <a class="text-info" style="font-size: 1.1rem;" href="http://php.thavath.com:8080/backend/">BackEnd</a>
            </span>
        </h3> 
        <div class="card mb-3">
            <div class="card-header"> 
                    <h4 class="card-title text-center bg-info text-white p-1">Create New User</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 offset-3">
                        <form id="user_form">
                            <div class="form-group">
                                <label for="username">User Name:</label>
                                <input type="text" class="form-control form-control-sm" 
                                placeholder="Enter username" id="username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email address:</label>
                                <input type="email" class="form-control form-control-sm" 
                                placeholder="Enter email" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="pwd">Password:</label>
                                <input type="password" class="form-control form-control-sm" 
                                placeholder="Enter password" id="password" name="password" required>
                            </div> 
                            <div class="form-group">
                                <label for="code">Phone Number:</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <select name="country_code" id="country_code" name="country_code"
                                        class="form-control form-control-sm">
                                            <option value="+855">+855</option>
                                            <option value="+885">+885</option>
                                            <option value="+893">+893</option>
                                        </select>
                                    </div>
                                    <input type="text" required 
                                    class="form-control form-control-sm" 
                                    placeholder="phone number" id="phone_number" name="phone_number">
                                </div>
                            </div>  
                            <button type="submit" class="btn btn-sm btn-primary">
                                <i class="fa fa-save"></i> Submit</button>
                        </form> 
                    </div>
                </div>
            </div>
            <div class="card-body"> 
                <div class="table-responsive-lg">
                    <table class="table table-sm table-striped table-hover">
                        <thead class="bg-info text-white text-center align-middle">
                            <th>ID</th>
                            <th>User Name</th>
                            <th>Password</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Created At</th>
                        </thead>
                        <tbody class="align-middle text-center"> 
                        </tbody>
                    </table>
                </div>
            </div>
        </div>   
    </div>  
    <!-- include footer -->
    <?php require("layouts/footer.php")?>
    <script>
        // https://dev.to/gyi2521/ajax---get-post-putand-delete--m9j
        $(document).ready(function(){ 
            // GET USER LIST
            $.get("../backend/api/users/get.php", function(result, status){
                console.log(status);
                if(status === "success"){
                    $.each(result, function(index, row){
                        console.log(row);
                        $("tbody").append(`<tr><td>${row.id}</td><td>${row.username}</td>
                        <td>${row.password}</td><td>${row.email}</td><td>${row.phone_number}</td>
                        <td>${row.created_at}</td></tr>`);
                    });
                }
            });
            // POST NEW USER 
            // Bind to the submit event of our form
            $("#user_form").submit(function(event){  
                console.log($(this).serialize());
                $.ajax({
                    url: "../backend/api/users/post.php", 
                    dataType: 'text',
                    method: 'POST', 
                    data: $(this).serialize(),
                    success: function( data, textStatus, jQxhr ){
                        console.log(data);
                    },
                    error: function( jqXhr, textStatus, errorThrown ){
                        console.log( errorThrown );
                    }
                });  
                // Prevent default posting of form - put here to work in case of errors
                event.preventDefault(); 
            });
        });
    </script>
    </body>
</html>