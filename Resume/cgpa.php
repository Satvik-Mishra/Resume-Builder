<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CGPA Filter</title>

    <style>
        body {
            background-color: #f1f1f1;
            font-family: Arial, sans-serif;
        }

        .cgpa1 {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .cgpa1 form {
            text-align: center;
        }

        .cgpa1 input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .cgpa1 button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .cgpa1 button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="cgpa1">
        <h2>Filter by CGPA</h2>
        <form action="cgpa.php" method="GET">
            <input type="number" name="cgpa" step="0.01" placeholder="Enter CGPA" required>
            <button type="submit">Filter</button>
        </form>
    </div>

    <?php
    if (isset($_GET['cgpa']) && !empty($_GET['cgpa'])) {
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

        $cgpaFilter = $_GET['cgpa'];

        // Prepare the SQL statement with CGPA filter
        $stmt = $conn->prepare("SELECT * FROM resumes WHERE cgpa >= ?");
        $stmt->bind_param("d", $cgpaFilter);

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



