<DOCTYPE HTML>
  <html>
    <head>
    <style>
        .abc {
            display: flex;
            justify-content: center;
            gap: 10px;
        }
    </style>
</head>
<body style="background-color:white">
  <center>
  <h2 style="font-size:3em">Filter By</h2>
  <div class="abc">
   <form action="cgpa.php"> 
  <button style="padding: 10px 20px; background-color: #4CAF50; color: #fff; border: none; border-radius: 5px; font-size: 18px; cursor: pointer; transition: background-color 0.3s ease;">CGPA</button>
</form>
<form action="skills.php"> 
  <button style="padding: 10px 20px; background-color: #4CAF50; color: #fff; border: none; border-radius: 5px; font-size: 18px; cursor: pointer; transition: background-color 0.3s ease;">SKILLLS</button>
</form>
  
</div>
<center>





</body>
</html>

<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "resumefields";

// Create a new connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare the SQL statement
$stmt = $conn->prepare("SELECT * FROM resumes");

// Execute the statement
$stmt->execute();

// Get the result set
$result = $stmt->get_result();

// Check if there are any records
if ($result->num_rows > 0) {
    echo "<style>
            
            .resume-table {
                width: 100%;
                border-collapse: collapse;
            }
            
            .resume-table th,
            .resume-table td {
                padding: 10px;
                text-align: left;
                border: 1px solid #ddd;
            }
            
            .resume-table th {
                background-color: #f2f2f2;
            }
            
            .resume-table tr:nth-child(even) {
                background-color: #f9f9f9;
            }
            
            .resume-table tr:hover {
                background-color: #f5f5f5;
            }
          </style>";

    echo "<table class='resume-table'>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Profession</th>
                <th>Email</th>
                <th>Phone</th>
                <th>About Me</th>'
                <th>Experience</th>'
                <th>Skills</th>
                <th>Degrees</th>
                <th>CGPA</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['first_name'] . "</td>
                <td>" . $row['last_name'] . "</td>
                <td>" . $row['profession'] . "</td>
                <td>" . $row['email'] . "</td>
                <td>" . $row['phone'] . "</td>
                <td>" . $row['about_me'] . "</td>
                <td>" . $row['experience'] . "</td>
                <td>" . $row['skills'] . "</td>
                <td>" . $row['degrees'] . "</td>
                <td>" . $row['cgpa'] . "</td>
            </tr>";
    }

    echo "</table>";
} else {
    echo "No records found.";
}

// Close the connection
$stmt->close();
$conn->close();
?>
