<?php

function gravatar_url(string $email)
{
    $email = md5($email);

    return "https://gravatar.com/avatar/{ $email }.png?s=60";
}
