<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product</title>
  <script src="public/responsivity/responsivity.js"></script>
  <style>
    body {
      position: absolute;
      left: 50px;
      top: 10px;
      width: 70%
    }
    table {
      border-collapse: collapse;
      width: 100%;
      background-color: lightgrey;
    }
    th,
    td {
      padding: 8px;
      text-align: left;
      border-bottom: 1px solid green;
    }

    tr:hover {
      background-color: coral;
    }
    tr:nth-child(1):hover{
      background-color: lightyellow;
    }
  </style>
</head>

<body>
  <h1>Products in the database</h1>
  <label id="msgStatus"></label>
  <input type="button" value="Add Product" onclick="addProduct();" style="margin:5px">
  
    <table id="tableProducts">
      <thead>
        <tr>
          <th>Id</th>
          <th>Name</th>
          <th>Price</th>
          <th>Description</th>
          <th>existing stock</th>
          <th>total sales year</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
    <script>
      ajax_post_request("app.php?service=selectAllProducts", "", function(result) {
        const product = JSON.parse(result);
        var table = document.getElementById("tableProducts");
        // debugger;
        if (product.result == product.resultTypes.SUCCESS) {
          product.data.forEach((product) => {
            
            var row = table.insertRow();
            row.insertCell().innerHTML = product.id;
            row.insertCell().innerHTML = product.name;
            row.insertCell().innerHTML = product.price;
            row.insertCell().innerHTML = product.description;
            row.insertCell().innerHTML = product.existingstock;
            row.insertCell().innerHTML = product.totalsalesyear;

            let btnSee = document.createElement("button");
            btnSee.innerHTML = "See";
            btnSee.onclick = function() {
              seeProduct(product.id)
            };

            let btnUpdate = document.createElement("button");
            btnUpdate.innerHTML = "Update";
            btnUpdate.onclick = function() {
              updateProduct(product.id)
            };

            let btnDelete = document.createElement("button");
            btnDelete.innerHTML = "Delete";
            btnDelete.onclick = function() {
              deleteProduct(product.id)
            };

            let actionsCell = row.insertCell();
            actionsCell.appendChild(btnSee);
            actionsCell.appendChild(btnUpdate);
            actionsCell.appendChild(btnDelete);
          });
        } else {
          document.getElementById("msgStatus").innerHTML = product.msg;
        }
      });

      function addProduct() {
        window.location.href = "app.php?service=showProductForm&MODE=INSERT";  //add &MODE later
      }

      function seeProduct(id) {
        window.location.href = `app.php?service=showProductForm&id=${id}&MODE=SEE`;
      }

      function updateProduct(id) {
        window.location.href = `app.php?service=showProductForm&id=${id}&MODE=UPDATE`;
      }

      function deleteProduct(id) {
        window.location.href = `app.php?service=showProductForm&id=${id}&MODE=DELETE`;
      }
    
    </script>
</body>
</html>