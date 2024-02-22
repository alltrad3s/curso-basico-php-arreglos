<?php

define("MAX_ATTEMPTS", 6);

function clear() {
    if (PHP_OS === "WINNT") {
        system("cls");
    } else {
        system("clear");
    }
}

function check_letters($word, $letter, &$discovered_letters) {
    // Esta función busca letras en la palabra y actualiza las letras descubiertas.
    $found = false;
    for ($i = 0; $i < strlen($word); $i++) {
        if ($word[$i] === $letter) {
            $discovered_letters[$i] = $letter;
            $found = true;
        }
    }
    return $found;
}

function print_wrong_letter(&$attempts) {
    // Incrementa los intentos y muestra los intentos restantes.
    clear();
    $attempts++;
    echo "Letra incorrecta 😾. Te quedan " . (MAX_ATTEMPTS - $attempts) . " intentos.\n";
    sleep(2);
}

function print_man($attempts) {
    // Muestra el estado del ahorcado basado en el número de intentos fallidos.
    echo "\n";
    switch ($attempts) {
        case 0:
            echo "  +---+\n";
            echo "  |   |\n";
            echo "      |\n";
            echo "      |\n";
            echo "      |\n";
            echo "      |\n";
            echo "=========\n";
            break;
        case 1:
            echo "  +---+\n";
            echo "  |   |\n";
            echo "  O   |\n";
            echo "      |\n";
            echo "      |\n";
            echo "      |\n";
            echo "=========\n";
            break;
        case 2:
            echo "  +---+\n";
            echo "  |   |\n";
            echo "  O   |\n";
            echo "  |   |\n";
            echo "      |\n";
            echo "      |\n";
            echo "=========\n";
            break;
        case 3:
            echo "  +---+\n";
            echo "  |   |\n";
            echo "  O   |\n";
            echo " /|   |\n";
            echo "      |\n";
            echo "      |\n";
            echo "=========\n";
            break;
        case 4:
            echo "  +---+\n";
            echo "  |   |\n";
            echo "  O   |\n";
            echo " /|\\  |\n";
            echo "      |\n";
            echo "      |\n";
            echo "=========\n";
            break;
        case 5:
            echo "  +---+\n";
            echo "  |   |\n";
            echo "  O   |\n";
            echo " /|\\  |\n";
            echo " /    |\n";
            echo "      |\n";
            echo "=========\n";
            break;
        case 6:
            echo "  +---+\n";
            echo "  |   |\n";
            echo "  O   |\n";
            echo " /|\\  |\n";
            echo " / \\  |\n";
            echo "      |\n";
            echo "=========\n";
            break;
    }
}

function print_game($word_length, $discovered_letters, $attempts) {
    // Limpia la pantalla y muestra el estado actual del juego, incluyendo el ahorcado.
    clear();
    print_man($attempts);
    echo "Palabra de $word_length letras: \n\n";
    echo implode(' ', str_split($discovered_letters)) . "\n\n";
}

function end_game($win, $choosen_word, $discovered_letters, $attempts) {
    // Muestra el resultado del juego y, si se ganó, cuántos intentos quedaron.
    clear();
    if ($win) {
        echo "¡Felicidades! Has adivinado la palabra. 😸 \n\n";
        // R1: Muestra cuántos intentos quedaron al ganar.
        echo "Te quedaron " . (MAX_ATTEMPTS - $attempts) . " intentos.\n";
    } else {
        echo "Suerte para la próxima, amigo. 😿 \n\n";
        print_man($attempts);
    }
    echo "La palabra era: $choosen_word\n";
    echo "Tú descubriste: " . implode(' ', str_split($discovered_letters)) . "\n";
}

function game_loop() {
    // Esta función encapsula la lógica del juego, permitiendo reiniciar fácilmente.
    $possible_words = ["bebida", "prisma", "ala", "dolor", "piloto", "baldosa", "terremoto", "asteroide", "gallo", "platzi"];
    $choosen_word = $possible_words[array_rand($possible_words)];
    $word_length = strlen($choosen_word);
    $discovered_letters = str_pad("", $word_length, "_");
    $attempts = 0;

    do {
        print_game($word_length, $discovered_letters, $attempts);
        $player_letter = strtolower(readline("Escribe una letra: "));
        if (!check_letters($choosen_word, $player_letter, $discovered_letters)) {
            print_wrong_letter($attempts);
        }
    } while ($attempts < MAX_ATTEMPTS && $discovered_letters != $choosen_word);

    end_game($discovered_letters == $choosen_word, $choosen_word, $discovered_letters, $attempts);
}

// Juego principal
do {
    game_loop();
    // R2: Pregunta si se quiere jugar de nuevo y reinicia el juego si es afirmativo.
    $play_again = strtolower(readline("¿Quieres jugar de nuevo? (s/n): "));
} while ($play_again == "s");