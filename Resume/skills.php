<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    .skills {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .skills form {
            text-align: center;
        }

        .skills input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .skills button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .skills button:hover {
            background-color: #45a049;
        }
        </style>
</head>
<body>
<div class="skills">
        <h2>Filter by Skills</h2>
        <form action="skills.php" method="GET">
            <input type="text" name="skills"  placeholder="Enter skill" required>
            <button type="submit">Filter</button>
        </form>
    </div>
    
</body>
</html>
<?php
    if (isset($_GET['skills']) && !empty($_GET['skills'])) {
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
        $skillsFilter = $_GET['skills'];

        // Split the user's input into an array of skills
        $skillsArray = explode(',', $skillsFilter);
        
        // Prepare the SQL statement with multiple conditions using FIND_IN_SET
        $conditions = array_fill(0, count($skillsArray), "skills LIKE ?");
        $conditionString = implode(' OR ', $conditions);
        
        // Prepare the SQL statement
        $stmt = $conn->prepare("SELECT * FROM resumes WHERE $conditionString");
        
        // Bind each skill to its corresponding parameter
        foreach ($skillsArray as $index => $skill) {
            $skill = '%' . trim($skill) . '%'; // Add wildcards to match partial skills
            $stmt->bind_param('s', $skill);
        }
        
        // Execute the query
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
                        <th>About Me</th>
                        <th>Experience</th>
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

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    }
    ?>

</body>
</html>



