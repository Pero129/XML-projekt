<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Učitavanje korisničkog imena i lozinke iz forme
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Učitavanje XML datoteke
    $xml = simplexml_load_file('users.xml');

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

    // Definicija Dota 2 heroja
    $heroes = [
        ["name" => "Anti-Mage", "main_stat" => "Agility"],
        ["name" => "Axe", "main_stat" => "Strength"],
        ["name" => "Bane", "main_stat" => "Intelligence"],
        ["name" => "Bloodseeker", "main_stat" => "Agility"],
        ["name" => "Crystal Maiden", "main_stat" => "Intelligence"],
        ["name" => "Drow Ranger", "main_stat" => "Agility"],
        ["name" => "Earthshaker", "main_stat" => "Strength"],
        ["name" => "Juggernaut", "main_stat" => "Agility"],
        ["name" => "Mirana", "main_stat" => "Agility"],
        ["name" => "Morphling", "main_stat" => "Agility"],
        ["name" => "Shadow Fiend", "main_stat" => "Agility"],
        ["name" => "Phantom Lancer", "main_stat" => "Agility"],
        ["name" => "Puck", "main_stat" => "Intelligence"],
        ["name" => "Pudge", "main_stat" => "Strength"],
        ["name" => "Razor", "main_stat" => "Agility"],
        ["name" => "Sand King", "main_stat" => "Strength"],
        ["name" => "Storm Spirit", "main_stat" => "Intelligence"],
        ["name" => "Sven", "main_stat" => "Strength"],
        ["name" => "Tiny", "main_stat" => "Strength"],
        ["name" => "Vengeful Spirit", "main_stat" => "Agility"],
    ];

    // Razvrstavanje heroja po glavnom statutu
    usort($heroes, function ($a, $b) {
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
        foreach ($heroes as $hero) {
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
