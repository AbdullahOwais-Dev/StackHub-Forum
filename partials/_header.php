<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Header</title>
  <style>
  .highlight {
    background-color: yellow;
    font-weight: bold;
  }
</style>
</head>
<body>
<?php

echo '<nav class="StackHub navbar navbar-expand-lg navbar-dark bg-dark"> 
        <a class="navbar-brand light-shadow" href="/forum">
          StackHub
        </a> 
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"> 
          <span class="navbar-toggler-icon"></span> 
        </button>;


  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="/forum">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="about.php">About</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="contact.php">Contact</a>
      </li>
    </ul>
    <div class="row mx-2">
        <form class="form-inline my-2 my-lg-0" onsubmit="searchAndHighlight(event)">
          <input class="form-control mr-sm-2" id="searchInput" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-success my-2 my-sm-0" type="submit">Search</button>
        </form>
        <button class="btn btn-outline-success mx-2"  data-toggle="modal" data-target="#signupmodal">Help Us out!</button>
    </div>

  </div>
</nav>';

include 'partials/_loginmodal.php';
include 'partials/_signupmodal.php';

?>

<script>
  function searchAndHighlight(event) {
    event.preventDefault(); // Prevent form submission

    // Remove previous highlights
    const highlights = document.querySelectorAll(".highlight");
    highlights.forEach(el => {
      el.replaceWith(...el.childNodes); // Replace the span with its original content
    });

    // Get the search query
    const query = document.getElementById("searchInput").value.trim().toLowerCase();
    if (!query) return; // Exit if query is empty

    // Recursive function to search and wrap matches
    function highlightText(node) {
      if (node.nodeType === Node.TEXT_NODE) {
        const nodeText = node.textContent.toLowerCase();
        const startIndex = nodeText.indexOf(query);

        if (startIndex !== -1) {
          const matchedText = node.splitText(startIndex);
          matchedText.splitText(query.length);

          const highlightSpan = document.createElement("span");
          highlightSpan.className = "highlight";
          highlightSpan.textContent = matchedText.textContent;

          matchedText.replaceWith(highlightSpan);
        }
      } else if (node.nodeType === Node.ELEMENT_NODE && !["SCRIPT", "STYLE"].includes(node.tagName)) {
        // Avoid breaking <script>, <style>, and nested highlight elements
        node.childNodes.forEach(child => highlightText(child));
      }
    }

    // Start highlighting from the body
    document.body.childNodes.forEach(child => highlightText(child));
  }
</script>
</body>
</html>