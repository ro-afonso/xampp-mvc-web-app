<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="public/responsivity/responsivity.js"></script>

</head>

<body style="left:100px; top:100px; width:70%;  padding:50px; background-color:gray">
    <label id="msgStatus" style="margin-bottom:5px; padding:5px; background-color:burlywood; display:none;"></label>
    <form id="form" style="padding:50px; background-color:darkcyan">
        <div class="form-group row">
            <label for="name" class="col-4 col-form-label">Name</label>
            <div class="col-8">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="fa fa-address-card-o"></i>
                        </div>
                    </div>
                    <input id="name" name="name" type="text" class="form-control">
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="address" class="col-4 col-form-label">Address</label>
            <div class="col-8">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="fa fa-address-book"></i>
                        </div>
                    </div>
                    <input id="address" name="address" type="text" class="form-control">
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="city" class="col-4 col-form-label">City</label>
            <div class="col-8">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="fa fa-address-book"></i>
                        </div>
                    </div>
                    <input id="city" name="city" type="text" class="form-control">
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="postalcode" class="col-4 col-form-label">Postal code</label>
            <div class="col-8">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">PC</div>
                    </div>
                    <input id="postalcode" name="postalcode" type="text" class="form-control">
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="offset-4 col-8">
                <button type="button" id="button" name="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
        <input type="hidden" id="id" name="id" value="-1"> <!-- person id -->
    </form>

    <script>
        const QueryString = window.location.search;
        const urlParams = new URLSearchParams(QueryString);
        var mode = "";
        var id="";
        // debugger;
        if (urlParams.get('MODE') !== null) {
            mode = urlParams.get('MODE');
            if (mode === "INSERT" ) {
                document.getElementById('name').readOnly = false;
                document.getElementById('address').readOnly = false;
                document.getElementById('city').readOnly = false;
                document.getElementById('postalcode').readOnly = false;
                document.getElementById('button').innerText = "Add";
                document.getElementById('button').onclick = submitNewPersonData;
            }else if (mode === "SEE") {
                document.getElementById('name').readOnly = true;
                document.getElementById('address').readOnly = true;
                document.getElementById('city').readOnly = true;
                document.getElementById('postalcode').readOnly = true;
                document.getElementById('button').innerText = "Go back";
                document.getElementById('button').onclick = function() {
                window.location.href = "app.php?service=showPeopleAsTable";
            };
            }else if (mode === "UPDATE" ) {
                document.getElementById('name').readOnly = false;
                document.getElementById('address').readOnly = false;
                document.getElementById('city').readOnly = false;
                document.getElementById('postalcode').readOnly = false;
                document.getElementById('button').innerText = "Update";
                document.getElementById('button').style.backgroundColor="red"; 
                document.getElementById('button').onclick = updatePerson;
            }else if (mode === "DELETE") {
                document.getElementById('name').readOnly = true;
                document.getElementById('address').readOnly = true;
                document.getElementById('city').readOnly = true;
                document.getElementById('postalcode').readOnly = true;
                document.getElementById('button').innerText = "DELETE";
                document.getElementById('button').style.backgroundColor="red"; 
                id = urlParams.get('id');
                document.getElementById('button').onclick = function() { deletePerson(id); };
            }

            if(mode==="UPDATE" || mode==="SEE" || mode==="DELETE") {
                id = urlParams.get('id');
                fetchPerson(id);
            }
        }

        function submitNewPersonData() {
            const form = document.getElementById('form');
            const formData = new FormData(form);

            ajax_post_request("app.php?service=insertPersonFromView", formData,
                function success(result) {
                    console.log(result);
                    const requestResult = JSON.parse(result);

                    if (requestResult.result == requestResult.resultTypes.SUCCESS) {
                        document.getElementById("msgStatus").innerHTML = "Inserted person with id = " + requestResult.id;
                        document.getElementById("msgStatus").style.display = "block";
                        document.getElementById('button').innerText = "Go back";
                        document.getElementById('button').onclick = function() {
                            window.location.href = "app.php?service=showPeopleAsTable";
                        };
                    } else {
                        document.getElementById("msgStatus").innerHTML = requestResult.msg;
                        document.getElementById("msgStatus").style.display = "block";
                    }
                },
                function error(error) {
                    document.getElementById("msgStatus").innerHTML = error;
                    document.getElementById("msgStatus").style.display = "block";
                });
        }

        function fetchPerson(id) {
            ajax_post_request("app.php?service=selectPerson&id=" + id , "",
                function success(result) {
                    console.log(result);
                    const requestResult = JSON.parse(result);

                    if (requestResult.result == requestResult.resultTypes.SUCCESS) {
                        document.getElementById("msgStatus").innerHTML = "Got person with id = " + requestResult.data[0].id;
                        document.getElementById("msgStatus").style.display = "block";

                        document.getElementById("id").value= requestResult.data[0].id;
                        document.getElementById("name").value= requestResult.data[0].name;
                        document.getElementById("address").value= requestResult.data[0].address;
                        document.getElementById("city").value= requestResult.data[0].city;
                        document.getElementById("postalcode").value= requestResult.data[0].postalcode;

                    } else {
                        document.getElementById("msgStatus").innerHTML = requestResult.msg;
                        document.getElementById("msgStatus").style.display = "block";
                    }
                },
                function error(error) {
                    document.getElementById("msgStatus").innerHTML = error;
                    document.getElementById("msgStatus").style.display = "block";
                });
        }

        // showPersonForm.php
        function updatePerson() {
            const form = document.getElementById('form');
            const formData = new FormData(form);

            ajax_post_request("app.php?service=updatePerson", formData,
                function success(result) {
                    console.log(result);
                    const requestResult = JSON.parse(result);

                    if (requestResult.result == requestResult.resultTypes.SUCCESS) {
                        document.getElementById("msgStatus").innerHTML = "Updated person with id = " + requestResult.id;
                        document.getElementById("msgStatus").style.display = "block";
                        document.getElementById('button').innerText = "Go back";
                        document.getElementById('button').style.backgroundColor="Blue";
                        document.getElementById('button').onclick = function() {
                            window.location.href = "app.php?service=showPeopleAsTable";
                        };
                    } else {
                        document.getElementById("msgStatus").innerHTML = requestResult.msg;
                        document.getElementById("msgStatus").style.display = "block";
                    }
                },
                function error(error) {
                    document.getElementById("msgStatus").innerHTML = error;
                    document.getElementById("msgStatus").style.display = "block";
                });
        }

        // showPersonAsForm.php
        function deletePerson(id) {
            ajax_post_request("app.php?service=deletePerson&id=" + id , "",
                function success(result) {
                    console.log(result);
                    const requestResult = JSON.parse(result);

                    if (requestResult.result == requestResult.resultTypes.SUCCESS) {
                        document.getElementById("msgStatus").innerHTML = "Deleted person with id = " + requestResult.id;
                        document.getElementById("msgStatus").style.display = "block";
                        document.getElementById('button').innerText = "Go back";
                        document.getElementById('button').style.backgroundColor="Blue";
                        document.getElementById('button').onclick = function() {
                            window.location.href = "app.php?service=showPeopleAsTable";
                        };
                    } else {
                        document.getElementById("msgStatus").innerHTML = requestResult.msg;
                        document.getElementById("msgStatus").style.display = "block";
                    }
                },
                function error(error) {
                    document.getElementById("msgStatus").innerHTML = error;
                    document.getElementById("msgStatus").style.display = "block";
                });
        }

    </script>

</body>

</html>
