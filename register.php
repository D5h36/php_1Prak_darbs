<?php include("database.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reģistrejies</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="reg-style.css">
</head>

<body>

    <div class="container col-md-3">
        <div class="text-fluid col-md-auto py-3 text-center">
            <h1>Reģistrējies</h1>
        </div>
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
            <div class="vards-fluid col-md-auto d-flex py-3 justify-content-center">
                <input type="text" class="form-control lietotajsIn center-text-input" name="vards" id="vards" placeholder="vārds" required>
            </div>
            <div class="uzvards-fluid col-md-auto d-flex py-3 justify-content-center">
                <input type="text" class="form-control uzvards" id="uzvardsId" name="uzvards" placeholder="uzvārds"
                    required>
            </div>
            <div class="NewLietotajs-fluid col-md-auto d-flex py-3 justify-content-center">
                <input type="text" class="form-control NewLietotajs" id="lietotajsId" name="lietotajs" placeholder="lietotājs"
                    required>

            </div>
            <div class="email-fluid col-md-auto d-flex py-3 justify-content-center">
                <input type="text" class="form-control email1" id="email1Id" name="Email1" placeholder="piem: karlis.berzins" required>
                <span class="input-group-text">@</span>
                <input type="text" class="form-control email2" id="email2Id" name="Email2" placeholder="gmail.com" required>
            </div>
            <div class="NewParole-fluid col-md-auto d-flex py-3 justify-content-center">
                <input type="password" class="form-control NewPassword" id="paswordId" name="parole" placeholder="parole"
                    required>
            </div>
            <div class="NewParole2-fluid col-md-auto d-flex py-3 justify-content-center">
                <input type="password" class="form-control NewPassword2" id="paswordId2" name="parole2" placeholder="Otreiz paroli"
                    required>
            </div>
            <div class="pieslegties-fluid col-md-auto d-flex py-3 justify-content-center">
                <button type="submit" id="NewRegistreties" class="btn btn-outline-primary NewRegistreties-btn" value="NewRegister">Reģistrēties</button>
                <button type="submit" id="atcelt" class="btn btn-outline-secondary atcelt-btn" value="atcelt" onclick="window.location.href = 'index.php';">Atcelt</button>

            </div>
        </form>


    </div>
</body>

</html>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vards = filter_input(INPUT_POST, "vards", FILTER_SANITIZE_SPECIAL_CHARS);
    $uzvards = filter_input(INPUT_POST, "uzvards", FILTER_SANITIZE_SPECIAL_CHARS);
    $lietotajs = filter_input(INPUT_POST, "lietotajs", FILTER_SANITIZE_SPECIAL_CHARS);
    $email1 = filter_input(INPUT_POST, "Email1", FILTER_SANITIZE_EMAIL);
    $email2 = filter_input(INPUT_POST, "Email2", FILTER_SANITIZE_EMAIL);
    $parole = filter_input(INPUT_POST, "parole", FILTER_SANITIZE_SPECIAL_CHARS);
    $parole2 = filter_input(INPUT_POST, "parole2", FILTER_SANITIZE_SPECIAL_CHARS);

    // Validate input fields
    if (empty($vards) || empty($uzvards) || empty($lietotajs) || empty($email1) || empty($email2) || empty($parole) || empty($parole2)) {
        echo "<script>alert('Visi lauki ir jāaizpilda.')</script>";
    } elseif ($parole !== $parole2) {
        echo "<script>alert('Paroles nesakrīt.')</script>";
    } else {
        // Hash password
        $hash = password_hash($parole, PASSWORD_DEFAULT);
        $email = "$email1@$email2";
        $sql = "INSERT INTO users (username, Name, LastName, password, email) VALUES (?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($connect, $sql)) {
            mysqli_stmt_bind_param($stmt, "sssss", $lietotajs, $vards, $uzvards, $hash, $email);
            if (mysqli_stmt_execute($stmt)) {
                echo "<script>alert('Reģistrācija veiksmīga!')</script>";
            } else {
                echo "<script>alert('Kļūda reģistrējot: " . mysqli_error($connect) . "')</script>";
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "<script>alert('Kļūda sagatavojot vaicājumu.')</script>";
        }
    }
}

// Close database connection
mysqli_close($connect);
?>