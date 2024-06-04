<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Učitavanje korisničkog imena i lozinke iz forme
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Provjera učitavanja XML datoteke
    if (file_exists('users.xml')) {
        $xml = simplexml_load_file('users.xml');
    } else {
        die('Error: Cannot find users.xml file.');
    }

    // Provjera korisničkog imena i lozinke
    $authenticated = false;
    $firstname = "";
    $lastname = "";
    foreach ($xml->user as $user) {
        if ($user->username == $username && $user->password == $password) {
            $authenticated = true;
            $firstname = $user->firstname;
            $lastname = $user->lastname;
            break;
        }
    }

    // Provjera učitavanja JSON datoteke
    if (file_exists('heroes.json')) {
        $heroes = json_decode(file_get_contents('heroes.json'), true);
    } else {
        die('Error: Cannot find heroes.json file.');
    }

    // Nasumično odabiranje 10 heroja
    $random_heroes = array_rand($heroes, 10);
    $selected_heroes = array();
    foreach ($random_heroes as $index) {
        $selected_heroes[] = $heroes[$index];
    }

    // Razvrstavanje heroja po glavnom statutu
    usort($selected_heroes, function ($a, $b) {
        return strcmp($a["main_stat"], $b["main_stat"]);
    });

    // Prikaz rezultata autentifikacije i tablice heroja
    if ($authenticated) {
        echo '<!DOCTYPE html>
        <html lang="hr">
        <head>
            <meta charset="UTF-8">
            <title>Dobrodošli</title>
            <link rel="stylesheet" href="styles.css">
        </head>
        <body>
            <div class="welcome-container">
                <h2>Prijava uspješna</h2>
                <p>Dobrodošli, ' . htmlspecialchars($firstname) . ' ' . htmlspecialchars($lastname) . '!</p>
                <a href="index.html">Povratak na početnu stranicu</a>
            </div>
            <div class="heroes-table">
                <h2>Popis Dota 2 heroja</h2>
                <table>
                    <tr>
                        <th>Ime heroja</th>
                        <th>Glavni stat</th>
                    </tr>';
        foreach ($selected_heroes as $hero) {
            echo '<tr>
                    <td>' . htmlspecialchars($hero["name"]) . '</td>
                    <td>' . htmlspecialchars($hero["main_stat"]) . '</td>
                  </tr>';
        }
        echo '  </table>
            </div>
        </body>
        </html>';
    } else {
        echo '<!DOCTYPE html>
        <html lang="hr">
        <head>
            <meta charset="UTF-8">
            <title>Neuspješna prijava</title>
            <link rel="stylesheet" href="styles.css">
        </head>
        <body>
            <div class="error-container">
                <h2>Prijava neuspješna</h2>
                <p>Pogrešno korisničko ime ili lozinka.</p>
                <a href="index.html">Pokušajte ponovo</a>
            </div>
        </body>
        </html>';
    }
}
?>
