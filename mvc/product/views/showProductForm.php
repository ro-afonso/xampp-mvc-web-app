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
    <form id="form" style="padding:50px; background-color:silver">
        <div class="rendered-form">
            <div class="formbuilder-text form-group field-name">
                <label for="name" class="formbuilder-text-label">Name</label>
                <input type="text" class="form-control" name="name" access="false" id="name">
            </div>
            <div class="formbuilder-number form-group field-price">
                <label for="price" class="formbuilder-number-label">Price</label>
                <input type="number" class="form-control" name="price" access="false" id="price">
            </div>
            <div class="formbuilder-textarea form-group field-description">
                <label for="description" class="formbuilder-textarea-label">Description</label>
                <textarea type="textarea" class="form-control" name="description" access="false" rows="2" id="description"></textarea>
            </div>
            <div class="formbuilder-number form-group field-existingstock">
                <label for="existingstock" class="formbuilder-number-label">Existing Stock</label>
                <input type="number" class="form-control" name="existingstock" access="false" id="existingstock">
            </div>
            <div class="formbuilder-number form-group field-totalsalesyear">
                <label for="totalsalesyear" class="formbuilder-number-label">Total Sales Year</label>
                <input type="number" class="form-control" name="totalsalesyear" access="false" id="totalsalesyear"></input>
            </div>
            <div class="formbuilder-button form-group field-button">
                <button type="button" class="btn-info btn" name="button" value="Submit" access="false"  id="button">Button</button>
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
            document.getElementById('price').readOnly = false;
            document.getElementById('description').readOnly = false;
            document.getElementById('existingstock').readOnly = false;
            document.getElementById('totalsalesyear').readOnly = false;
            document.getElementById('button').innerText = "Add";
            document.getElementById('button').onclick = submitNewProductData;
        }else if (mode === "SEE") {
            document.getElementById('name').readOnly = true;
            document.getElementById('price').readOnly = true;
            document.getElementById('description').readOnly = true;
            document.getElementById('existingstock').readOnly = true;
            document.getElementById('totalsalesyear').readOnly = true;
            document.getElementById('button').innerText = "Go back";
            document.getElementById('button').onclick = function() {
                window.location.href = "app.php?service=showProductsAsTable";
            };
        }else if (mode === "UPDATE" ) {
            document.getElementById('name').readOnly = false;
            document.getElementById('price').readOnly = false;
            document.getElementById('description').readOnly = false;
            document.getElementById('existingstock').readOnly = false;
            document.getElementById('totalsalesyear').readOnly = false;
            document.getElementById('button').innerText = "Update";
            document.getElementById('button').style.backgroundColor="red"; 
            document.getElementById('button').onclick = updateProduct;
        }else if (mode === "DELETE") {
            document.getElementById('name').readOnly = true;
            document.getElementById('price').readOnly = true;
            document.getElementById('description').readOnly = true;
            document.getElementById('existingstock').readOnly = true;
            document.getElementById('totalsalesyear').readOnly = true;
            document.getElementById('button').innerText = "DELETE";
            document.getElementById('button').style.backgroundColor="red"; 
            id = urlParams.get('id');
            document.getElementById('button').onclick = function() { deleteProduct(id); };
        }

        if(mode==="UPDATE" || mode==="SEE" || mode==="DELETE") {
            id = urlParams.get('id');
            fetchProduct(id);
        }
    }

    function submitNewProductData() {
        const form = document.getElementById('form');
        const formData = new FormData(form);

        ajax_post_request("app.php?service=insertProductFromView", formData,
            function success(result) {
                console.log(result);
                const requestResult = JSON.parse(result);

                if (requestResult.result == requestResult.resultTypes.SUCCESS) {
                    document.getElementById("msgStatus").innerHTML = "Inserted Product with id = " + requestResult.id;
                    document.getElementById("msgStatus").style.display = "block";
                    document.getElementById('button').innerText = "Go back";
                    document.getElementById('button').onclick = function() {
                        window.location.href = "app.php?service=showProductsAsTable";
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

    function fetchProduct(id) {
        ajax_post_request("app.php?service=selectProduct&id=" + id , "",
            function success(result) {
                console.log(result);
                const requestResult = JSON.parse(result);

                if (requestResult.result == requestResult.resultTypes.SUCCESS) {
                    document.getElementById("msgStatus").innerHTML = "Got Product with id = " + requestResult.data[0].id;
                    document.getElementById("msgStatus").style.display = "block";

                    document.getElementById("id").value= requestResult.data[0].id;   //this doesn't work for some reason
                    document.getElementById("name").value= requestResult.data[0].name;
                    document.getElementById("price").value= requestResult.data[0].price;
                    document.getElementById("description").value= requestResult.data[0].description;
                    document.getElementById("existingstock").value= requestResult.data[0].existingstock;
                    document.getElementById("totalsalesyear").value= requestResult.data[0].totalsalesyear;

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

    // showProductForm.php
    function updateProduct() {
        const form = document.getElementById('form');
        const formData = new FormData(form);

        ajax_post_request("app.php?service=updateProduct", formData,
            function success(result) {
                console.log(result);
                const requestResult = JSON.parse(result);

                if (requestResult.result == requestResult.resultTypes.SUCCESS) {
                    document.getElementById("msgStatus").innerHTML = "Updated Product with id = " + requestResult.id;
                    document.getElementById("msgStatus").style.display = "block";
                    document.getElementById('button').innerText = "Go back";
                    document.getElementById('button').style.backgroundColor="Blue";
                    document.getElementById('button').onclick = function() {
                        window.location.href = "app.php?service=showProductsAsTable";
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

    // showProductAsForm.php
    function deleteProduct(id) {
        ajax_post_request("app.php?service=deleteProduct&id=" + id , "",
            function success(result) {
                console.log(result);
                const requestResult = JSON.parse(result);

                if (requestResult.result == requestResult.resultTypes.SUCCESS) {
                    document.getElementById("msgStatus").innerHTML = "Deleted Product with id = " + requestResult.id;
                    document.getElementById("msgStatus").style.display = "block";
                    document.getElementById('button').innerText = "Go back";
                    document.getElementById('button').style.backgroundColor="Blue";
                    document.getElementById('button').onclick = function() {
                        window.location.href = "app.php?service=showProductsAsTable";
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
