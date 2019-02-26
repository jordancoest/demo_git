<?php


function form(string $action, string $methode, string $legend): string{
    $code = "<form action=\"$action\" method=\"$methode\" >\n";
    $code .= "<fieldset><legend>$legend</legend>\n";
    return $code;
}
function text(string $libtexte, string $nomtexte): string {
    $code = "<label><b> $libtexte </b></label> <input type=\"text\" name=\"$nomtexte\" size=\"60\" maxlength=\"255\" /><br />\n";
    return $code;
}

function radio(string $libradio, string $nomradio, string $valradio): string {
    $code = "<label><b> $libradio </b></label><input type=\"radio\" name=\"$nomradio\" value=\"$valradio\" /><br />\n";
    return $code;
}

function submit(string $libsubmit, string $libreset): string
{
    $code = "<input type=\"submit\" name=\"Aff\" value=\"$libsubmit\" />&nbsp;&nbsp;&nbsp;\n";
    $code .= "<input type=\"reset\" value=\"$libreset\" /><br />\n";
    return $code;
}

function finform(): string{
    $code = "</fieldset></form>\n";
    return $code;
}

?>
