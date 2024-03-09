<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>People</title>
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
  <h1>People in the database</h1>
  <label id="msgStatus"></label>
  <input type="button" value="Add Person" onclick="addPerson();" style="margin:5px">
  
    <table id="tablePeople">
      <thead>
        <tr>
          <th>Id</th>
          <th>Name</th>
          <th>Address</th>
          <th>City</th>
          <th>Postal Code</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
    <script>
    </script>
</body>
</html>

<script>
    ajax_post_request("app.php?service=selectAllPeople", "", function(result) {
      const people = JSON.parse(result);
      var table = document.getElementById("tablePeople");
      // debugger;
      if (people.result == people.resultTypes.SUCCESS) {
        people.data.forEach((person) => {
          var row = table.insertRow();
          row.insertCell().innerHTML = person.id;
          row.insertCell().innerHTML = person.name;
          row.insertCell().innerHTML = person.address;
          row.insertCell().innerHTML = person.city;
          row.insertCell().innerHTML = person.postalcode;

          let btnSee = document.createElement("button");
          btnSee.innerHTML = "See";
          btnSee.onclick = function() {
            seePerson(person.id)
          };

          let btnUpdate = document.createElement("button");
          btnUpdate.innerHTML = "Update";
          btnUpdate.onclick = function() {
            updatePerson(person.id)
          };


          let btnDelete = document.createElement("button");
          btnDelete.innerHTML = "Delete";
          btnDelete.onclick = function() {
            deletePerson(person.id)
          };
    

          let actionsCell = row.insertCell();
          actionsCell.appendChild(btnSee);
          actionsCell.appendChild(btnUpdate);
          actionsCell.appendChild(btnDelete);
        });
      } else {
        document.getElementById("msgStatus").innerHTML = people.msg;
      }
    });

    function addPerson() {
        window.location.href = "app.php?service=showPersonForm&MODE=INSERT";
    }

    function seePerson(id) {
        window.location.href = `app.php?service=showPersonForm&id=${id}&MODE=SEE`;
    }

    function updatePerson(id) {
      window.location.href = `app.php?service=showPersonForm&id=${id}&MODE=UPDATE`;
    }

    function deletePerson(id) {
      window.location.href = `app.php?service=showPersonForm&id=${id}&MODE=DELETE`;
    }

</script>