

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Darbs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container col-md-3">
        <div class="text-fluid col-md-auto py-3 text-center">
            <h1>Pieslēgties</h1>
        </div>
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
            <div class="lietotajs-fluid col-md-auto d-flex py-3 justify-content-center">
                <input type="text" class="form-control lietotajsIn center-text-input" name="lietotajs" id="lietotajs" placeholder="lietotājs">
            </div>
            <div class="parole-fluid col-md-auto d-flex py-3 justify-content-center">
                <input type="password" class="form-control paroleIn center-text-input" name="parole" id="parole" placeholder="parole">
            </div>
            <div class="pieslegties-fluid col-md-auto d-flex py-3 justify-content-center">
                <button type="submit" id="pieslegties" class="btn btn-outline-primary pieslegties-btn" onclick="">Pieslēgties</button>
                <button type="submit" id="registreties" class="btn btn-outline-secondary registreties-btn" onclick="window.location.href = 'register.php';">Reģistrēties</button>
            </div>
        </form>
    </div>
</body>

</html>

<?php
include("database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lietotajs = filter_input(INPUT_POST, "lietotajs", FILTER_SANITIZE_SPECIAL_CHARS);
    $parole = filter_input(INPUT_POST, "parole", FILTER_SANITIZE_SPECIAL_CHARS);

    // Check if fields are empty
    if (empty($lietotajs)) {
        echo "<script>alert('Lūdzu, ievadiet lietotājvārdu.')</script>";
    } elseif (empty($parole)) {
        echo "<script>alert('Lūdzu, ievadiet paroli.')</script>";
    } else {
        // Prepare the SQL query to find the user
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = mysqli_prepare($connect, $sql);

        if ($stmt) {
            // Bind parameters and execute query
            mysqli_stmt_bind_param($stmt, "s", $lietotajs);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            // Check if user exists
            if ($result && mysqli_num_rows($result) > 0) {
                $user = mysqli_fetch_assoc($result);
                
                // Verify password
                if (password_verify($parole, $user['password'])) {
                    // Password is correct, log in the user
                    $_SESSION['username'] = $user['username']; // Store username in session
                    echo "<script>alert('Pieslēgšanās veiksmīga!'); window.location.href='welcome.php';</script>";
                } else {
                    echo "<script>alert('Nepareiza parole!')</script>";
                }
            } else {
                echo "<script>alert('Lietotājs ar šo lietotājvārdu nav atrasts!')</script>";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        } else {
            echo "<script>alert('Kļūda izpildot vaicājumu.')</script>";
        }
    }
}

// Close database connection
mysqli_close($connect);
?>