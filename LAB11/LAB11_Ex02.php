<?php
class User {
    private string $message = "Ths is a message from";

    function introduce(string $name): string {
        return "$this->message $name";
    }
}
$user = new User();
echo $user->introduce("YourNameHere");