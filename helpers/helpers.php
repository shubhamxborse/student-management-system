<?php

function clean($value)
{
    return htmlspecialchars(trim($value));
}

function isValidPhone($phone)
{
    return preg_match("/^[0-9]{10}$/", $phone);
}