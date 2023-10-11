<?php 
include('db-conection.php');

$objConection = new conectionDb();                      
$result = $objConection->query("SELECT * FROM `contacto`");

if($_POST) {
  $name = clearInput($_POST['i-name']);
  $phone = clearInput($_POST['i-phone']);
  $email = clearInput($_POST['i-email']);
  $birth = clearInput($_POST['i-birth']);
  if(!empty($name) && !empty($phone) && !empty($birth) && !empty($email) ) {
    $objConection = new conectionDb();   
    $sql =  $sql="INSERT INTO `contacto` (`name`, `phone`, `email`, `birthday`) VALUES ('$name', '$phone', '$email', '$birth')";
    $objConection->execute($sql);
    header("location:main.php");
  } else {
    echo '<script> alert("Please, complete all inputs")  </script>';
  }
}

if ($_GET) {
  $urlName = $_GET['borrar'];
  $objConection = new conectionDb();
  $query = "DELETE FROM `contacto` WHERE `contacto`.`name` = '$urlName'";
  $objConection->execute($query);
  header("location:main.php");
}
/**
 * clears data (remove slashes,remove blank spaces,encode data) introduced by user 
 */
function clearInput($data) { 
  $data = trim($data);
  $data = htmlspecialchars($data);
  $data = stripslashes($data);
  return $data;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="test.css">
    <title>Contacts</title>
</head>
<body>
  <main>
    <div class="m-container">
        <div class="l-container">
            <h1>Contacts</h1>
            <form action="main.php" method="post">
                <div class="f-container">
                  <label>Name</label>
                  <input type="text" name="i-name" id="" >
                </div>  
                <div class="f-container">
                  <label>Phone</label>
                  <input type="number" name="i-phone" id="">
                </div>
                <div class="f-container">
                  <label>Email</label>
                  <input type="email" name="i-email" id="">
                </div>
                <div class="f-container">
                  <label>Birthday</label>
                  <input type="date" name="i-birth" id="">
                </div>
                <input type="submit" value="Add" class="input-submit">
            </form>
        </div>
        <div class="r-container">
            <div class="contacts-container" id="asd">
                <table id="table">
                  <thead id="thead">
                    <?php  foreach($result as $contacto) { ?>
                    <tr>
                      <td>  <?php echo $contacto['name']  ?>  </td>
                      <td> <button class="boton" id="b-view" onclick="test('<?php echo $contacto['name']; ?>', '<?php echo $contacto['email']; ?>', '<?php echo $contacto['phone']; ?>', '<?php echo $contacto['birthday']; ?>')"> View </button>
                           <button class="boton" id="b-delete">  <a href="?borrar=<?php echo $contacto['name']; ?>">Delete</a> </button>
                      </td>
                    </tr>
                    <?php }  ?>
                  </thead>
                </table>
            </div>
        </div>
    </div>
  </main>
<script>

const rightPanelElement =document.getElementById('asd');
const viewButtonElement = document.getElementById('b-view');
const tableElement = document.getElementById('table')
const theadElement = document.getElementById('thead');

/**
 * Creates a new container that contains user data, manipulating DOM. 
 * @param string $name , $email 
 * @param int $phone
 */

function test(name, email, phone, birthday) {
   tableElement.style.opacity = "0";
   tableElement.className = "tableElement";

   setTimeout(function() {
   let newDivContainer = document.createElement("div");
   rightPanelElement.appendChild(newDivContainer);
   newDivContainer.className = "newDiv"
  
   let img =document.createElement("img");
   newDivContainer.appendChild(img)
   img.className = "imgUser"
   img.src="user.png"
   
   let nameElement = document.createElement("p");
   let phoneElement = document.createElement("p");
   let emailElement = document.createElement("p");
   let birthdayElement = document.createElement("p");

   newDivContainer.appendChild(nameElement)
   newDivContainer.appendChild(phoneElement)
   newDivContainer.appendChild(emailElement)
   newDivContainer.appendChild(birthdayElement)

   nameElement.innerHTML = "Name: " + name;
   emailElement.innerHTML = "Email: " + email;
   phoneElement.innerHTML = "Phone: " + phone;
   birthdayElement.innerHTML = "Birth: " + birthday;

   let closeButton = document.createElement("button");
   newDivContainer.appendChild(closeButton);
   closeButton.className = "boton"
   closeButton.innerHTML = "Back";

   closeButton.addEventListener("click" , function() {
    newDivContainer.remove()
    tableElement.style.opacity = "1";
   })

  }, 100)
}
</script>
</body>
</html>
