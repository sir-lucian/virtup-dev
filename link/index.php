<?php

define("LINKS", [
//  "example-link-id" => "https://www.examplelink.com/here?go=value&to=value2",
    "2025-riseon-audition" => "https://forms.gle/Db37TKnUPDTpQLUZ8",
]);
define("HOMEPAGE", "https://virtup.me");

if (isset($_GET["to"]) && array_key_exists($_GET["to"],LINKS)) {
    $goto = $_GET["to"];
    header( "Location: ".LINKS[$goto] );
} else {
    header( "Location: ".HOMEPAGE );
}
exit(0);