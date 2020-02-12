# <h1>Google Keep Visualizer</h1>

A tool to visualize Google Keep notes exported via Takeout. Instead of having to open each .html to see the notes, the script will read the .json files of each note for you and and generate a grid with their content. You could host an website with the script and the notes, and give access to your whoever you want.

<h3> Instructions </h3>
<hr>
<ul>
  <li>Download your Google Keep notes using <a href="https://takeout.google.com/">Google Takeout</a></li>
  <li>Download or clone this repository into your machine</li>
  <li>Unzip the file, and copy the 'Takeout' folder into the visualizer repository (You can use other directory structure, just change it in the Settings)</li>
  <li>You need to start a php server and host the repository. (Learn how to install PHP here - <a href="https://phptherightway.com/#getting_started" target="_blank">PHP The Right Way</a>)</li>
  <li>Access index.php and enjoy your notes.</li>
</ul>

<hr>
<h3> Features </h3>
<ul>
  <li> Google Keep-like grid view </li>
  <li> Support multiple images and voice records </li>
  <li> Create preview for links, and list the note sharees </li>
  <li> Differentiate between pinned, trashed, archived, and regular notes </li>
  <li> Groups the notes by category </li>
  <li> Build the notes with accurate JSON formatted data, instead of scrapping HTML tags </li>
  <li> Settings page with display and grouping options </li>
  <li> Doesn't limit the size for the notes, so you have full-lenght content</li>
 </ul>
 <hr>
 <h4>To be implemented</h4>
 <ul>
  <li> Node.js approach </li> 
  <li> Note modal </li>
  <li> Note editing </li>
 </ul>
