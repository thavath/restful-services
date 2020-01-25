<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Task Management App.</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="assets/bootstrap/animate.css">
    <!-- <link rel="stylesheet" href="assets/plugins/fontawesome/font-awesome.min.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <!-- include header -->
    <?php require("layouts/header.php") ?>
    <!-- include menu bar -->
    <!-- container section -->
    <div class="container-fluid pl-2 pr-2 shadow-sm rounded-lg border mb-2">
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
                    <div class="col-md-3">
                        <div class="row border p-2 m-0">
                            <div class="col-md-12">
                                <form id="user_form">
                                    <div class="form-group bounceInLeft animated fast d-none" id="user_id">
                                        <label for="id">User Id:</label>
                                        <input type="text" name="id" id="id" disabled class="form-control form-control-sm w-100 mb-1 rounded-pill pl-3">
                                    </div>
                                    <div class="form-group">
                                        <label for="username">User Name:</label>
                                        <input type="text" class="form-control form-control-sm w-100 mb-1 rounded-pill pl-3" placeholder="Enter username" id="username" name="username" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email address:</label>
                                        <input type="email" class="form-control form-control-sm w-100 mb-1 rounded-pill pl-3" placeholder="Enter email" id="email" name="email" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="pwd">Password:</label>
                                        <input type="password" class="form-control form-control-sm w-100 mb-1 rounded-pill pl-3" placeholder="Enter password" id="password" name="password" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="code">Phone Number:</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <select name="country_code" id="country_code" class="form-control form-control-sm w-100 mb-1 rounded-pill pl-3">
                                                    <option value="+855">+855</option>
                                                    <option value="+885">+885</option>
                                                    <option value="+893">+893</option>
                                                </select>
                                            </div>
                                            <input type="text" required class="form-control form-control-sm w-100 mb-1 rounded-pill pl-3" placeholder="phone number" id="phone_number" name="phone_number">
                                        </div>
                                    </div>
                                    <button id="save" type="submit" class="btn btn-sm btn-primary">
                                        <i class="fa fa-save"></i> <span id="save_text">Submit</span></button>
                                    <button id="new" type="button" class="btn btn-sm btn-success">
                                        <i class="fa fa-refresh"></i> New</button>
                                </form>
                                <div id="response" class="mt-2"></div>
                            </div>
                        </div>
                    </div>
                    <!-- Table List -->
                    <div class="col-md-9">
                        <div class="border p-2 m-0">
                            <!-- Table 1 -->
                            <div class="table-responsive fadeInDown">
                                <span class="pull-left mb-1">
                                    <button class="btn btn-sm btn-success" onclick="exportTableToExcel('user_list', 'list-users')">
                                        <i class="fa fa-file-excel-o"></i> Excel</button>
                                    &nbsp;
                                    <button class="btn btn-sm btn-info" onclick="exportTableToCSV('user_list','user.csv')">
                                        <i class="fa fa-file"></i> CSV</button>
                                </span>

                                <table id="user_list" class="table table-sm table-bordered table-striped table-hover">
                                    <thead class="bg-info text-center text-white"></thead>
                                    <tbody class="text-center" style="cursor: pointer;"></tbody>
                                </table>
                            </div>
                            <!-- End Table 1 -->
                            <!-- Table 2 -->
                            <!-- Start Table -->

                            <!-- <div class="table-responsive-lg">
                           
                            <table id="userlist" class="table table-sm table-striped table-hover">
                                <thead class="bg-info text-white text-center align-middle">
                                    <th>ID</th>
                                    <th>User Name</th>
                                    <th>Password</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </thead>
                                <tbody class="align-middle text-center"> 
                                </tbody>
                            </table> 
                        </div> -->
                            <!-- End Table -->
                            <!-- End Table 2 -->
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- include footer -->
    <?php require("layouts/footer.php") ?>

    <script src="assets/bootstrap/jquery.min.js"></script>
    <script src="assets/bootstrap/popper.min.js"></script>
    <script src="assets/bootstrap/bootstrap.min.js"></script>
    <script src="assets/plugins/jsonserializeobject/jquery.serialize-object.js"></script>
    <script>
        // https://dev.to/gyi2521/ajax---get-post-putand-delete--m9j
        $(document).ready(function() {
            // GET ALL USER 
            // loadData();
            // GET ALL USERS
            getDataTable();
            // Clear Form
            $("#new").click(() => {
                $("#user_id").addClass("fadeOutRight");
                $("#user_id").removeClass("bounceInLeft");
                setTimeout(() => $("#user_id").addClass("d-none"), 380);
                $("#id").val("");
                $("#username").val("");
                $("#email").val("");
                $("#password").val("");
                $("#phone_number").val("");
                $("#save_text").text("Submit");
            });
            // POST NEW USER 
            // Bind to the submit event of our form
            $(document).on('submit', '#user_form', function(event) {
                event.preventDefault(); 
                if ($("#save_text").text() == "Submit") {
                    // get form data
                    var sign_up_form = $(this);
                    sign_up_form_obj = sign_up_form.serializeObject();
                    var form_data = JSON.stringify(sign_up_form_obj);
                    // submit form data to api
                    console.log(form_data);
                    console.log(sign_up_form_obj);
                    $.ajax({
                        url: "http://php.thavath.com:8080/backend/api/users/create.php",
                        type: "POST",
                        contentType: 'application/json',
                        data: form_data,
                        success: function(result) {
                            console.log(result);
                            sign_up_form.find('input').val('');
                            $('#response').html("<div class='alert alert-success p-1 pl-3 rounded-pill'>User was created.</div>");
                              // GET ALL USERS
                            getDataTable();
                        },
                        error: function(xhr, resp, text) {
                            // on error, tell the user sign up failed
                            $('#response').html("<div class='alert alert-danger p-1 pl-3 rounded-pill'>Unable to sign up. Please contact admin.</div>");
                        }
                    });
                    return false;
                } else {
                    console.log("Nothing");
                }
            });
        });
        // Get Data
        function getDataTable() {
            // Get From Database SQL Server.
            $.get("../backend/api/users/get.php", (data, status) => {
                if (status === "success") {
                    // Start Column Name
                    // console.log(data);
                    // console.log(data.length);
                    if (data.length > 0) {
                        $("#user_list thead").empty();
                        var th = "<tr>";
                        $.each(data[0], (key, value) => {
                            console.log(key + " : " + value);
                            th += `<th class="text-uppercase">${key}</th>`;
                        });
                        th += "<th>ACTION</th></tr>";
                        $("#user_list thead").append(th);
                        // End Column Name
                        var tr = "";
                        $("#user_list tbody").empty();
                        $.each(data, (index, row) => {
                            tr = "<tr class='p-0 m-0'>";
                            // console.log(row.USER_NAME);
                            $.each(row, (value, text) => {
                                if (value === "phone_number") {
                                    tr += `<td class="m-1 p-1 badge badge-info badge-pill">${text}</td>`;
                                } else if (value === "password") {
                                    tr += `<td class="m-1 pt-1 badge badge-danger badge-pill">********</td>`;
                                } else {
                                    tr += `<td class='p-0 m-0'>${text}</td>`;
                                }
                            });
                            var btnEdit =
                                '<td class="p-0 m-0"><button class="btn p-0 pl-1 pr-1 m-0 btn-outline-primary btn-edit"><i class="fa fa-edit"></i></button>';
                            btnEdit += '&nbsp;<button class="btn p-0 pl-1 pr-1 m-0 btn-outline-danger btn-delete"><i class="fa fa-trash"></i></button></td>';
                            tr += btnEdit + "</tr>";
                            $("#user_list tbody").append(tr);
                        });
                        //  Initialize Edit 

                        $(".btn-edit").on("click", function() {
                            // get current row of button edit
                            var row = $(this).closest("tr");
                            $("#user_id").addClass("bounceInLeft");
                            $("#user_id").removeClass("fadeOutRight d-none");
                            $("#id").val(row.find('td:eq(0)').text());
                            $("#username").val(row.find('td:eq(1)').text());
                            $("#password").val(row.find('td:eq(2)').text());
                            $("#email").val(row.find('td:eq(3)').text());
                            var phonenumber = row.find('td:eq(4)').text();
                            $("#phone_number").val("0" + phonenumber.substring(4, phonenumber.legnth));
                            $("#country_code").val(phonenumber.substring(0, 4));
                            // change button
                            $("#save_text").text("Update");
                        });
                    } else {
                        $("#user_list thead").empty();
                        var title =
                            '<tr><th>There is no Data<th></tr>';
                        $("#user_list thead").append(title);
                    }
                } else {
                    console.log("Error 404");
                }
            });
        }
        // End Get Data
        // function loadData(){
        //     // GET USER LIST
        //     $.get("../backend/api/users/get.php", function(result, status){
        //         console.log(status);
        //         if(status === "success"){
        //             $.each(result, function(index, row){
        //                 console.log(row);
        //                 $("#userlist tbody").append(`
        //                     <tr><td>${row.id}</td><td class="text-left pl-3">${row.username}</td>
        //                     <td class="mt-1 badge badge-danger">********</td><td class="text-left pl-3">${row.email}</td>
        //                     <td class="text-left pl-3">${row.phone_number}</td><td class="text-left pl-3">${row.created_at}</td>
        //                     <td class="text-center"><button class="btn btn-sm btn-outline-info"><i class="fa fa-eye"></i></button>
        //                     &nbsp;<button class="btn btn-sm btn-outline-primary"><i class="fa fa-edit"></i></button>
        //                     &nbsp;<button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button></td>
        //                     </tr>
        //                 `);
        //             });
        //         }
        //     });
        // }
        // Export to Excel File
        function exportTableToExcel(tableID, filename = '') {
            var downloadLink;
            var dataType = 'application/vnd.ms-excel';
            var tableSelect = document.getElementById(tableID);
            var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');

            // Specify file name
            filename = filename ? filename + '.xls' : 'excel_data.xls';

            // Create download link element
            downloadLink = document.createElement("a");

            document.body.appendChild(downloadLink);

            if (navigator.msSaveOrOpenBlob) {
                var blob = new Blob(['\ufeff', tableHTML], {
                    type: dataType
                });
                navigator.msSaveOrOpenBlob(blob, filename);
            } else {
                // Create a link to the file
                downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
                // Setting the file name
                downloadLink.download = filename;
                //triggering the function
                downloadLink.click();
            }
        } // End Export Excel
        // Export CSV File
        function downloadCSV(csv, filename) {
            var csvFile;
            var downloadLink;

            // CSV file
            csvFile = new Blob([csv], {
                type: "text/csv"
            });

            // Download link
            downloadLink = document.createElement("a");

            // File name
            downloadLink.download = filename;

            // Create a link to the file
            downloadLink.href = window.URL.createObjectURL(csvFile);

            // Hide download link
            downloadLink.style.display = "none";

            // Add the link to DOM
            document.body.appendChild(downloadLink);

            // Click download link
            downloadLink.click();
        }
        // ==============
        function exportTableToCSV(tableName, filename) {
            var csv = [];
            var rows = document.querySelectorAll("table tr");
            for (var i = 0; i < rows.length; i++) {
                var row = [],
                    cols = rows[i].querySelectorAll("td, th");

                for (var j = 0; j < cols.length; j++)
                    row.push(cols[j].innerText);
                csv.push(row.join(","));
            }
            // Download CSV file
            downloadCSV(csv.join("\n"), filename);
        }
        // End Export CSV
    </script>
</body>

</html>