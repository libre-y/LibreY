<!DOCTYPE html >
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta charset="UTF-8"/>
        <meta name="description" content="A privacy respecting meta search engine."/>
        <meta name="referrer" content="no-referrer"/>
        <link rel="stylesheet" type="text/css" href="static/styles.css"/>
        <link title="LibreX search" type="application/opensearchdescription+xml" href="/opensearch.xml?method=POST" rel="search"/>
        <link rel="shortcut icon" href="static/images/librex.png" />

        <link rel="stylesheet" type="text/css" href="<?php echo "static/" . (isset($_REQUEST["theme"]) ? $_REQUEST["theme"] . ".css" : "dark.css"); ?>"/>