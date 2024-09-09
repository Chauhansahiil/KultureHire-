<?php
    // Database connection
    $conn = new mysqli("localhost", "root", "", "hee111");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Registration logic
    if (isset($_POST['register'])) {
        $firstname = $_POST['FirstName'];
        $lastname = $_POST['Lastname'];
        $email = $_POST['Email'];
        $password = password_hash($_POST['Password'], PASSWORD_DEFAULT); // Hash the password

        $sql = "INSERT INTO users (FirstName, Lastname, Email, Password) VALUES ('$firstname', '$lastname', '$email', '$password')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Registration successful! Please login.');</script>";
            echo "<script>window.location.href = '#login';</script>"; // Redirect to login
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Login logic
    if (isset($_POST['login'])) {
        $username_or_email = $_POST['username_or_email'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE Email='$username_or_email' OR FirstName='$username_or_email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['Password'])) {
                echo "<script>alert('Login successful!');</script>";
                // Redirect to a new page after successful login
                echo "<script>window.location.href = 'after_login_page.html';</script>";
            } else {
                echo "<script>alert('Incorrect password!');</script>";
            }
        } else {
            echo "<script>alert('No user found with that email or username!');</script>";
        }
    }

    $conn->close();
    ?>
</body>
</html>